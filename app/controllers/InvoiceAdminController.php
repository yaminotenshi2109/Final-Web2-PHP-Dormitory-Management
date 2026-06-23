<?php
/**
 * app/controllers/InvoiceAdminController.php
 * Admin Invoice Management Controller
 */

declare(strict_types=1);

require_once __DIR__ . '/BillingController.php';

class InvoiceAdminController extends BillingController
{
    public function __construct()
    {
        parent::__construct();
        $this->requireAdmin();
    }

    public function showGenerateForm(array $params = []): void
    {
        $contracts = $this->db->select(
            "SELECT c.id, s.full_name, s.student_code, r.room_number
             FROM contracts c
             JOIN students s ON s.id = c.student_id
             JOIN rooms r ON r.id = c.room_id
             WHERE c.status = 'active'
             ORDER BY r.room_number, s.full_name"
        );

        $this->view('admin/invoices/generate', [
            'title' => 'Tạo hóa đơn',
            'contracts' => $contracts
        ]);
    }

    public function generateSingle(array $params = []): void
    {
        $this->verifyCsrf();

        $contractId = (int)$this->request('contract_id');
        $month = (int)$this->request('month');
        $year = (int)$this->request('year');
        $elecCurr = (float)$this->request('elec_curr');
        $waterCurr = (float)$this->request('water_curr');

        if (!$contractId || !$month || !$year || $elecCurr < 0 || $waterCurr < 0) {
            $this->jsonError('Dữ liệu không hợp lệ', 422);
        }

        $billingService = new BillingService();
        $result = $billingService->generateSingleWithUtility($contractId, $month, $year, $elecCurr, $waterCurr);

        if (!$result['success']) {
            $this->jsonError($result['message'], 422);
        }

        $this->jsonOk($result['data'], 'Tạo hóa đơn thành công', 201);
    }

    public function pdf(array $params = []): void
    {
        $this->getPdf($params);
    }
}
