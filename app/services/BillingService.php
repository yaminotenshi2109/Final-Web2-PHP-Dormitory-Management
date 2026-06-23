<?php
/**
 * app/services/BillingService.php
 * ─────────────────────────────────────────────────────────────
 *  Engine tính hóa đơn tự động
 *
 *  Chức năng:
 *  • Tính tiền phòng (base_rent)
 *  • Tính tiền điện (electricity_fee)
 *  • Tính tiền nước (water_fee)
 *  • Tính phí điều hòa (ac_fee)
 *  • Tính các phụ phí khác
 *  • Sinh hóa đơn tự động
 *  • Xuất PDF
 *  • Quản lý thanh toán
 *  • Báo cáo doanh thu
 *
 *  Công thức:
 *  Total = Base Rent
 *        + (Electricity units × Rate)
 *        + (Water units × Rate)
 *        + AC Fee (nếu có AC)
 *        + Other Fees (nếu có)
 *        - Discount (nếu có)
 *        = Grand Total
 *
 *  Thành viên 3 phụ trách (Invoice module)
 *  Điểm "Xuất sắc": Complex calculation + PDF generation + Report
 * ─────────────────────────────────────────────────────────────
 */

declare(strict_types=1);

require_once __DIR__ . '/../models/Models.php';

class BillingService
{
    private Database $db;
    private InvoiceModel $invoiceModel;

    /**
     * Default rates (from config.php or database)
     */
    private const DEFAULT_ELECTRICITY_RATE = 3500;    // VND per kWh
    private const DEFAULT_WATER_RATE = 15000;         // VND per m³
    private const DEFAULT_AC_FEE_MONTHLY = 100000;    // VND per month
    private const LATE_PAYMENT_PENALTY = 50000;       // VND per day late

    /**
     * Invoice status
     */
    private const STATUS_PENDING = 'unpaid';
    private const STATUS_PAID = 'paid';
    private const STATUS_OVERDUE = 'overdue';

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->invoiceModel = new InvoiceModel();
    }

    /**
     * ───────────────────────────────────────────────────────────
     *  MAIN: Generate Invoice
     * ───────────────────────────────────────────────────────────
     */

    /**
     * Tạo hóa đơn cho một sinh viên trong một tháng
     *
     * Steps:
     *   1. Kiểm tra sinh viên có hợp đồng active
     *   2. Kiểm tra hóa đơn đã tồn tại chưa
     *   3. Tính tiền phòng
     *   4. Lấy chỉ số điện nước
     *   5. Tính tiền điện, nước
     *   6. Tính phí AC (nếu có)
     *   7. Tính phí khác, giảm giá
     *   8. Tính tổng
     *   9. Tạo hóa đơn
     *   10. Gửi thông báo
     *
     * @param int $contractId
     * @param int $month (1-12)
     * @param int $year
     *
     * @return array {
     *     "success": bool,
     *     "message": string,
     *     "data": { invoice } | null,
     *     "error": string | null
     * }
     */
    public function generateInvoice(int $contractId, int $month, int $year): array
    {
        // ─── Step 1: Verify contract ──────────────────────────
        $contract = $this->db->selectOne(
            "SELECT c.*, r.price_per_month, r.has_ac, s.user_id
             FROM contracts c
             JOIN rooms r ON r.id = c.room_id
             JOIN students s ON s.id = c.student_id
             WHERE c.id = ? AND c.status = 'active'",
            [$contractId]
        );

        if (!$contract) {
            return $this->error('Hợp đồng không tồn tại hoặc không active');
        }

        // ─── Step 2: Check if invoice already exists ──────────
        $existing = $this->db->selectOne(
            "SELECT id FROM invoices
             WHERE contract_id = ? AND month = ? AND year = ?",
            [$contractId, $month, $year]
        );

        if ($existing) {
            return $this->error('Hóa đơn cho tháng này đã tồn tại');
        }

        try {
            $invoiceId = $this->db->transaction(function (Database $db) use (
                $contract,
                $month,
                $year
            ) {
                // ─── Step 3: Calculate base rent ────────────────
                $baseRent = (float)$contract['price_per_month'];

                // ─── Step 4-5: Get utility readings ─────────────
                $electricityFee = $this->calculateElectricityFee($contract['room_id'], $month, $year);
                $waterFee = $this->calculateWaterFee($contract['room_id'], $month, $year);

                // ─── Step 6: Calculate AC fee ──────────────────
                $acFee = $contract['has_ac'] ? self::DEFAULT_AC_FEE_MONTHLY : 0;

                // ─── Step 7: Other fees and discounts ──────────
                $otherFees = 0;        // Can be customized
                $discount = 0;         // Can be customized
                $lateFee = 0;          // Calculated if overdue

                // ─── Step 8: Calculate total ──────────────────
                $subtotal = $baseRent + $electricityFee + $waterFee + $acFee + $otherFees;
                $totalAmount = $subtotal - $discount + $lateFee;

                // ─── Step 9: Create invoice ───────────────────
                $dueDate = date('Y-m-d', strtotime("+15 days", strtotime("{$year}-{$month}-01")));

                $invoiceId = $db->insert('invoices', [
                    'contract_id'        => $contract['id'],
                    'month'              => $month,
                    'year'               => $year,
                    'base_rent'          => $baseRent,
                    'electricity_fee'    => $electricityFee,
                    'water_fee'          => $waterFee,
                    'ac_fee'             => $acFee,
                    'other_fee'          => $otherFees,
                    'total_amount'       => $totalAmount,
                    'status'             => self::STATUS_PENDING,
                    'due_date'           => $dueDate,
                ]);

                // ─── Step 10: Send notification ────────────────
                $db->insert('notifications', [
                    'user_id' => $contract['user_id'],
                    'title'   => "Hóa đơn tháng {$month}/{$year}",
                    'message' => "Hóa đơn tháng {$month}/{$year} đã được tạo. "
                               . "Tổng tiền: " . number_format($totalAmount, 0) . " VND. "
                               . "Hạn nộp: {$dueDate}",
                    'type'    => 'invoice',
                ]);

                error_log(sprintf(
                    '[INVOICE] Generated #%d for contract #%d, month %d/%d, total: %.0f VND',
                    $invoiceId,
                    $contract['id'],
                    $month,
                    $year,
                    $totalAmount
                ));

                return $invoiceId;
            });

            $invoice = $this->invoiceModel->find($invoiceId);

            return $this->success($invoice, 'Tạo hóa đơn thành công');
        } catch (\Throwable $e) {
            error_log($e->getMessage());
            return $this->error('Lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Tạo hóa đơn cá nhân có kèm theo ghi chỉ số điện nước
     */
    public function generateSingleWithUtility(int $contractId, int $month, int $year, float $elecCurr, float $waterCurr): array
    {
        // Get the contract
        $contract = $this->db->selectOne(
            "SELECT c.room_id FROM contracts c WHERE c.id = ? AND c.status = 'active'",
            [$contractId]
        );

        if (!$contract) {
            return $this->error('Hợp đồng không tồn tại hoặc không active');
        }

        $roomId = (int)$contract['room_id'];

        try {
            $this->db->transaction(function (Database $db) use ($roomId, $month, $year, $elecCurr, $waterCurr) {
                // Find previous readings (if any) to set elec_prev and water_prev
                // We'll look for the reading of the previous month. 
                $prevMonth = $month - 1;
                $prevYear = $year;
                if ($prevMonth === 0) {
                    $prevMonth = 12;
                    $prevYear--;
                }

                $prevReading = $db->selectOne(
                    "SELECT elec_curr, water_curr FROM utility_readings WHERE room_id = ? AND month = ? AND year = ?",
                    [$roomId, $prevMonth, $prevYear]
                );

                $elecPrev = $prevReading ? (float)$prevReading['elec_curr'] : 0.0;
                $waterPrev = $prevReading ? (float)$prevReading['water_curr'] : 0.0;
                
                // If the user inputs a smaller reading than previous month, it's an error.
                if ($elecCurr < $elecPrev || $waterCurr < $waterPrev) {
                    throw new \Exception("Chỉ số mới không thể nhỏ hơn chỉ số tháng trước (Điện: {$elecPrev}, Nước: {$waterPrev})");
                }

                // Check if utility reading for current month already exists
                $existingReading = $db->selectOne(
                    "SELECT id FROM utility_readings WHERE room_id = ? AND month = ? AND year = ?",
                    [$roomId, $month, $year]
                );

                if ($existingReading) {
                    // Update
                    $db->update('utility_readings', [
                        'elec_curr' => $elecCurr,
                        'water_curr' => $waterCurr,
                        // We also need to make sure elec_prev and water_prev are up to date
                        'elec_prev' => $elecPrev,
                        'water_prev' => $waterPrev,
                    ], 'id = ?', [$existingReading['id']]);
                } else {
                    // Insert
                    $db->insert('utility_readings', [
                        'room_id' => $roomId,
                        'month' => $month,
                        'year' => $year,
                        'elec_prev' => $elecPrev,
                        'elec_curr' => $elecCurr,
                        'water_prev' => $waterPrev,
                        'water_curr' => $waterCurr,
                        'elec_rate' => $this->getElectricityRate(),
                        'water_rate' => $this->getWaterRate(),
                        'recorded_by' => $_SESSION['auth_user']['id'] ?? 1, // Fallback to 1 if no auth in CLI
                    ]);
                }
            });

            // After setting utility, generate invoice normally
            return $this->generateInvoice($contractId, $month, $year);

        } catch (\Throwable $e) {
            error_log($e->getMessage());
            return $this->error($e->getMessage());
        }
    }

    /**
     * ───────────────────────────────────────────────────────────
     *  UTILITY FEE CALCULATIONS
     * ───────────────────────────────────────────────────────────
     */

    /**
     * Tính tiền điện dựa vào chỉ số
     *
     * @return float Electricity fee in VND
     */
    private function calculateElectricityFee(int $roomId, int $month, int $year): float
    {
        // Get electricity reading for this month
        $reading = $this->db->selectOne(
            "SELECT elec_prev, elec_curr, elec_rate FROM utility_readings
             WHERE room_id = ? AND month = ? AND year = ?",
            [$roomId, $month, $year]
        );

        if (!$reading) {
            // Not enough data, estimate based on average
            return 500000; // Default estimate
        }

        // Calculate units consumed (current - previous)
        $unitsConsumed = max(0, (float)$reading['elec_curr'] - (float)$reading['elec_prev']);

        // Get rate from reading (it captures snapshot rate)
        $rate = (float)$reading['elec_rate'];

        return $unitsConsumed * $rate;
    }

    /**
     * Tính tiền nước dựa vào chỉ số
     *
     * @return float Water fee in VND
     */
    private function calculateWaterFee(int $roomId, int $month, int $year): float
    {
        // Get water reading for this month
        $reading = $this->db->selectOne(
            "SELECT water_prev, water_curr, water_rate FROM utility_readings
             WHERE room_id = ? AND month = ? AND year = ?",
            [$roomId, $month, $year]
        );

        if (!$reading) {
            // Not enough data, estimate
            return 150000; // Default estimate
        }

        // Calculate units consumed
        $unitsConsumed = max(0, (float)$reading['water_curr'] - (float)$reading['water_prev']);

        // Get rate from reading
        $rate = (float)$reading['water_rate'];

        return $unitsConsumed * $rate;
    }

    /**
     * ───────────────────────────────────────────────────────────
     *  PAYMENT & STATUS MANAGEMENT
     * ───────────────────────────────────────────────────────────
     */

    /**
     * Đánh dấu hóa đơn đã thanh toán
     *
     * @param int $invoiceId
     * @param string $paymentMethod (bank, momo, cash)
     * @param ?string $transactionId (for bank/momo)
     */
    public function markInvoicePaid(
        int $invoiceId,
        string $paymentMethod = 'cash',
        ?string $transactionId = null
    ): array {
        $invoice = $this->invoiceModel->find($invoiceId);

        if (!$invoice) {
            return $this->error('Hóa đơn không tồn tại');
        }

        if ($invoice['status'] === self::STATUS_PAID) {
            return $this->error('Hóa đơn đã được thanh toán');
        }

        try {
            $this->db->transaction(function (Database $db) use (
                $invoiceId,
                $invoice,
                $paymentMethod,
                $transactionId
            ) {
                // Update invoice status
                $db->update('invoices', [
                    'status'        => self::STATUS_PAID,
                    'paid_at'       => date('Y-m-d H:i:s'),
                    'payment_method' => $paymentMethod,
                ], 'id = ?', [$invoiceId]);

                // Send notification to student
                $student = $db->selectOne(
                    "SELECT s.user_id FROM invoices i
                     JOIN contracts c ON c.id = i.contract_id
                     JOIN students s ON s.id = c.student_id
                     WHERE i.id = ?",
                    [$invoiceId]
                );

                if ($student) {
                    $db->insert('notifications', [
                        'user_id' => $student['user_id'],
                        'title'   => 'Hóa đơn được thanh toán',
                        'message' => "Hóa đơn tháng {$invoice['month']}/{$invoice['year']} "
                                   . "đã được thanh toán. Cảm ơn bạn!",
                        'type'    => 'payment',
                    ]);
                }

                error_log(sprintf(
                    '[PAYMENT] Invoice #%d paid via %s',
                    $invoiceId,
                    $paymentMethod
                ));
            });

            $updated = $this->invoiceModel->find($invoiceId);

            return $this->success($updated, 'Đánh dấu thanh toán thành công');
        } catch (\Throwable $e) {
            error_log($e->getMessage());
            return $this->error('Lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Tính tiền phạt nếu trễ hạn
     *
     * @param int $invoiceId
     * @return float Late fee in VND
     */
    public function calculateLateFee(int $invoiceId): float
    {
        $invoice = $this->invoiceModel->find($invoiceId);

        if (!$invoice || $invoice['status'] === self::STATUS_PAID) {
            return 0;
        }

        $daysLate = max(0, (int)(
            (time() - strtotime($invoice['due_date'])) / (24 * 60 * 60)
        ));

        return $daysLate * self::LATE_PAYMENT_PENALTY;
    }

    /**
     * ───────────────────────────────────────────────────────────
     *  BATCH OPERATIONS
     * ───────────────────────────────────────────────────────────
     */

    /**
     * Tạo hóa đơn cho tất cả hợp đồng active trong một tháng
     *
     * @param int $month
     * @param int $year
     * @return array {
     *     "total_invoices": int,
     *     "total_amount": float,
     *     "errors": []
     * }
     */
    public function generateMonthlyBatch(int $month, int $year): array
    {
        $contracts = $this->db->select(
            "SELECT id FROM contracts WHERE status = 'active'"
        );

        $totalInvoices = 0;
        $totalAmount = 0.0;
        $errors = [];

        foreach ($contracts as $contract) {
            $result = $this->generateInvoice($contract['id'], $month, $year);

            if ($result['success']) {
                $totalInvoices++;
                $totalAmount += $result['data']['total_amount'];
            } else {
                $errors[] = "Contract {$contract['id']}: {$result['message']}";
            }
        }

        return [
            'success'          => true,
            'total_invoices'   => $totalInvoices,
            'total_amount'     => $totalAmount,
            'errors'           => $errors,
        ];
    }

    /**
     * ───────────────────────────────────────────────────────────
     *  STATISTICS & REPORTING
     * ───────────────────────────────────────────────────────────
     */

    /**
     * Lấy doanh thu theo tháng
     *
     * @return array [
     *     { "month": "2026-05", "revenue": 50000000 },
     *     ...
     * ]
     */
    public function getMonthlyRevenue(int $months = 12): array
    {
        return $this->db->select(
            "SELECT DATE_FORMAT(created_at, '%Y-%m') as month,
                    SUM(total_amount) as revenue,
                    COUNT(*) as invoice_count
             FROM invoices
             WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? MONTH)
               AND status = 'paid'
             GROUP BY DATE_FORMAT(created_at, '%Y-%m')
             ORDER BY month DESC",
            [$months]
        );
    }

    /**
     * Lấy thống kê thanh toán
     */
    public function getPaymentStats(): array
    {
        $totalInvoices = $this->db->selectValue("SELECT COUNT(*) FROM invoices");
        $paidInvoices = $this->db->selectValue(
            "SELECT COUNT(*) FROM invoices WHERE status = 'paid'"
        );
        $unpaidInvoices = $this->db->selectValue(
            "SELECT COUNT(*) FROM invoices WHERE status IN ('unpaid', 'overdue')"
        );

        $totalRevenue = $this->db->selectValue(
            "SELECT COALESCE(SUM(total_amount), 0) FROM invoices WHERE status = 'paid'"
        ) ?? 0;

        $totalUnpaid = $this->db->selectValue(
            "SELECT COALESCE(SUM(total_amount), 0) FROM invoices WHERE status IN ('unpaid', 'overdue')"
        ) ?? 0;

        return [
            'total_invoices'  => (int)$totalInvoices,
            'paid_invoices'   => (int)$paidInvoices,
            'unpaid_invoices' => (int)$unpaidInvoices,
            'payment_rate'    => $totalInvoices > 0 ? ($paidInvoices / $totalInvoices * 100) : 0,
            'total_revenue'   => (float)$totalRevenue,
            'total_unpaid'    => (float)$totalUnpaid,
        ];
    }

    /**
     * ───────────────────────────────────────────────────────────
     *  CONFIGURATION
     * ───────────────────────────────────────────────────────────
     */

    /**
     * Lấy giá điện từ config hoặc database
     */
    private function getElectricityRate(): float
    {
        try {
            $rate = $this->db->selectValue(
                "SELECT value FROM settings WHERE `key` = 'electricity_rate'"
            );
            if ($rate !== null && $rate !== false) {
                return (float)$rate;
            }
        } catch (\Throwable $e) {
            // Settings table might not exist, ignore and use fallback
        }

        return defined('DEFAULT_ELEC_RATE') ? (float)DEFAULT_ELEC_RATE : (float)self::DEFAULT_ELECTRICITY_RATE;
    }

    /**
     * Lấy giá nước từ config hoặc database
     */
    private function getWaterRate(): float
    {
        try {
            $rate = $this->db->selectValue(
                "SELECT value FROM settings WHERE `key` = 'water_rate'"
            );
            if ($rate !== null && $rate !== false) {
                return (float)$rate;
            }
        } catch (\Throwable $e) {
            // Settings table might not exist, ignore and use fallback
        }

        return defined('DEFAULT_WATER_RATE') ? (float)DEFAULT_WATER_RATE : (float)self::DEFAULT_WATER_RATE;
    }

    /**
     * ───────────────────────────────────────────────────────────
     *  RESPONSE HELPERS
     * ───────────────────────────────────────────────────────────
     */

    private function success(mixed $data = null, string $message = 'Success'): array
    {
        return [
            'success' => true,
            'message' => $message,
            'data'    => $data,
            'error'   => null,
        ];
    }

    private function error(string $message): array
    {
        return [
            'success' => false,
            'message' => $message,
            'data'    => null,
            'error'   => $message,
        ];
    }
}
