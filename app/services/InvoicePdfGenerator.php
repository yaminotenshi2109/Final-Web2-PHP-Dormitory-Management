<?php
/**
 * app/services/InvoicePdfGenerator.php
 * ─────────────────────────────────────────────────────────────
 *  Sinh hóa đơn PDF với FPDF
 *  • Tiêu đề, logo
 *  • Thông tin sinh viên, phòng
 *  • Chi tiết chi phí
 *  • Hướng dẫn thanh toán
 *  • Footer với chữ ký
 *
 *  Cách sử dụng:
 *    $generator = new InvoicePdfGenerator();
 *    $generator->generate($invoiceId, '/path/to/output.pdf');
 * ─────────────────────────────────────────────────────────────
 */

declare(strict_types=1);

// FPDF must be installed: composer require setasign/fpdf
if (file_exists(dirname(dirname(__DIR__)) . '/vendor/autoload.php')) {
    require_once dirname(dirname(__DIR__)) . '/vendor/autoload.php';
}

if (!class_exists('FPDF\FPDF')) {
    class FPDFMock {
        private array $pages = [];
        private array $currentPage = [];
        private string $orientation;
        private string $unit;
        private string $size;
        private float $pageWidth;
        private float $pageHeight;
        private array $font = ['family' => 'Helvetica', 'style' => '', 'size' => 11];
        private array $textColor = [0, 0, 0];
        private float $x = 10;
        private float $y = 10;
        private int $pageNo = 0;

        public function __construct(string $orientation = 'P', string $unit = 'mm', string $size = 'A4')
        {
            $this->orientation = $orientation;
            $this->unit = $unit;
            $this->size = $size;
            $this->setPageSize($size);
            $this->addPage();
        }

        public function AddPage(string $orientation = '', string $size = '', int $rotation = 0): void
        {
            if ($orientation !== '') {
                $this->orientation = $orientation;
            }
            if ($size !== '') {
                $this->size = $size;
                $this->setPageSize($size);
            }

            $this->currentPage = ['lines' => []];
            $this->pages[] = &$this->currentPage;
            $this->pageNo = count($this->pages);
            $this->x = 10;
            $this->y = 10;
        }

        public function SetFont(string $family, string $style = '', int $size = 0): void
        {
            $normalizedFamily = strtolower($family);
            if ($normalizedFamily === 'arial') {
                $family = 'Helvetica';
            }

            $this->font = [
                'family' => $family,
                'style'  => strtoupper($style),
                'size'   => $size > 0 ? $size : 11,
            ];
        }

        public function SetTextColor(int $r, ?int $g = null, ?int $b = null): void
        {
            if ($g === null) {
                $this->textColor = [$r, $r, $r];
            } else {
                $this->textColor = [$r, $g, $b];
            }
        }

        public function SetXY(float $x, float $y): void
        {
            $this->x = $x;
            $this->y = $y;
        }

        public function Cell(float $w, float $h = 0, string $txt = '', int $border = 0, int $ln = 0, string $align = '', bool $fill = false, string $link = ''): void
        {
            $this->currentPage['lines'][] = [
                'x'     => $this->x,
                'y'     => $this->y,
                'text'  => $this->normalizeText($txt),
                'font'  => $this->font,
                'color' => $this->textColor,
            ];

            if ($ln > 0) {
                $this->y += $h > 0 ? $h : $this->font['size'] * 0.35;
                $this->x = 10;
            } else {
                $this->x += $w;
            }
        }

        public function MultiCell(float $w, float $h, string $txt, int $border = 0, string $align = 'J', bool $fill = false): void
        {
            $lines = explode("\n", $txt);
            foreach ($lines as $line) {
                $this->currentPage['lines'][] = [
                    'x'     => $this->x,
                    'y'     => $this->y,
                    'text'  => $this->normalizeText($line),
                    'font'  => $this->font,
                    'color' => $this->textColor,
                ];
                $this->y += $h > 0 ? $h : $this->font['size'] * 0.35;
            }
            $this->x = 10;
        }

        public function SetDrawColor(int $r, ?int $g = null, ?int $b = null): void {}
        public function SetLineWidth(float $width): void {}
        public function Line(float $x1, float $y1, float $x2, float $y2): void {}
        public function Rect(float $x, float $y, float $w, float $h, string $style = ''): void {}
        public function SetFillColor(int $r, ?int $g = null, ?int $b = null): void {}

        public function PageNo(): int
        {
            return $this->pageNo ?: 1;
        }

        public function GetY(): float
        {
            return $this->y;
        }

        public function GetX(): float
        {
            return $this->x;
        }

        public function Output($dest = '', $name = '', $utf8 = false)
        {
            $content = $this->buildPdf();
            if ($dest === 'F' && $name !== '') {
                file_put_contents($name, $content);
            } else {
                echo $content;
            }
        }

        private function setPageSize(string $size): void
        {
            if ($size === 'A4') {
                $this->pageWidth = 210;
                $this->pageHeight = 297;
            } else {
                $this->pageWidth = 210;
                $this->pageHeight = 297;
            }
        }

        private function mmToPt(float $mm): float
        {
            return $mm * 2.83464567;
        }

        private function normalizeText(string $text): string
        {
            $ascii = @iconv('UTF-8', 'ASCII//TRANSLIT', $text);
            return $ascii === false ? $text : $ascii;
        }

        private function escapePdfString(string $text): string
        {
            return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text);
        }

        private function getFontTag(array $font): string
        {
            $style = strtoupper($font['style'] ?? '');
            return match ($style) {
                'B'       => '/F2',
                'I', 'U'  => '/F3',
                'BI', 'IB' => '/F4',
                default   => '/F1',
            };
        }

        private function buildPdf(): string
        {
            $pageCount = count($this->pages);
            $objects = [];
            $objectOffsets = [];
            $currentOffset = 0;

            $pdf = "%PDF-1.4\n%âãÏÓ\n";
            $currentOffset += strlen($pdf);

            $objects[] = "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n";
            $objects[] = "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count {$pageCount} >>\nendobj\n";

            $pageContent = $this->buildPageContent($this->pages[0]);
            $contentLength = strlen($pageContent);

            $objects[] = "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>\nendobj\n";
            $objects[] = "4 0 obj\n<< /Length {$contentLength} >>\nstream\n{$pageContent}\nendstream\nendobj\n";
            $objects[] = "5 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n";

            foreach ($objects as $object) {
                $objectOffsets[] = $currentOffset;
                $pdf .= $object;
                $currentOffset += strlen($object);
            }

            $xrefOffset = $currentOffset;
            $pdf .= "xref\n0 " . (count($objects) + 1) . "\n";
            $pdf .= str_pad('0', 10, '0', STR_PAD_LEFT) . " 65535 f \n";
            foreach ($objectOffsets as $offset) {
                $pdf .= str_pad((string)$offset, 10, '0', STR_PAD_LEFT) . " 00000 n \n";
            }

            $pdf .= "trailer\n<< /Size " . (count($objects) + 1) . " /Root 1 0 R >>\nstartxref\n{$xrefOffset}\n%%EOF";
            return $pdf;
        }

        private function buildPageContent(array $page): string
        {
            $content = "BT\n";
            foreach ($page['lines'] as $line) {
                $x = $this->mmToPt($line['x']);
                $y = 842 - $this->mmToPt($line['y']);
                $escaped = $this->escapePdfString($line['text']);
                $color = array_map(fn($value) => sprintf('%.3f', min(max($value / 255, 0), 1)), $line['color']);
                $fontTag = $this->getFontTag($line['font']);
                $content .= sprintf("%s %.1f Tf\n%s %s %s rg\n1 0 0 1 %.3f %.3f Tm\n(%s) Tj\n", $fontTag, $line['font']['size'], $color[0], $color[1], $color[2], $x, $y, $escaped);
            }
            $content .= "ET";
            return $content;
        }
    }
    class_alias('FPDFMock', 'FPDF\FPDF');
}

use FPDF\FPDF;

class InvoicePdfGenerator
{
    private FPDF $pdf;
    private Database $db;
    private float $pageWidth = 210;    // A4 width in mm
    private float $pageHeight = 297;   // A4 height in mm
    private float $margin = 10;        // 10mm margins

    /**
     * Colors (RGB)
     */
    private const COLOR_PRIMARY = [24, 95, 165];      // #185FA5
    private const COLOR_TEXT = [44, 44, 42];          // #2C2C2A
    private const COLOR_LIGHT = [241, 239, 232];      // #F1EFE8
    private const COLOR_BORDER = [211, 209, 199];     // #D3D1C7

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->pdf = new FPDF('P', 'mm', 'A4');
    }

    /**
     * ───────────────────────────────────────────────────────────
     *  MAIN GENERATION
     * ───────────────────────────────────────────────────────────
     */

    /**
     * Sinh PDF hóa đơn
     *
     * @param int $invoiceId
     * @param string $outputPath
     * @return bool Success
     */
    public function generate(int $invoiceId, string $outputPath): bool
    {
        try {
            // Get invoice data
            $invoice = $this->getInvoiceData($invoiceId);

            if (!$invoice) {
                error_log("Invoice #$invoiceId not found");
                return false;
            }

            // Create PDF
            $this->pdf->AddPage();
            $this->pdf->SetFont('Helvetica', '', 11);

            // Build layout
            $this->drawHeader($invoice);
            $this->drawInvoiceInfo($invoice);
            $this->drawStudentInfo($invoice);
            $this->drawItemsTable($invoice);
            $this->drawPaymentInfo($invoice);
            $this->drawFooter($invoice);

            // Output
            $this->pdf->Output('F', $outputPath);

            return file_exists($outputPath);
        } catch (\Throwable $e) {
            error_log("PDF generation error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * ───────────────────────────────────────────────────────────
     *  LAYOUT BUILDERS
     * ───────────────────────────────────────────────────────────
     */

    /**
     * Vẽ header: logo, tiêu đề, đơn vị
     */
    private function drawHeader(array $invoice): void
    {
        $y = $this->margin;

        // Title
        $this->pdf->SetFont('Helvetica', 'B', 20);
        $this->pdf->SetTextColor(...self::COLOR_PRIMARY);
        $this->pdf->SetXY($this->margin, $y);
        $this->pdf->Cell(0, 10, 'KTX MANAGEMENT', 0, 1, 'C');

        $y += 12;

        // Subtitle
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->SetTextColor(100, 100, 100);
        $this->pdf->SetXY($this->margin, $y);
        $this->pdf->Cell(0, 5, 'Hệ thống quản lý ký túc xá', 0, 1, 'C');

        $y += 8;

        // Divider
        $this->pdf->SetDrawColor(...self::COLOR_BORDER);
        $this->pdf->SetLineWidth(0.5);
        $this->pdf->Line($this->margin, $y, $this->pageWidth - $this->margin, $y);

        $y += 5;

        // Invoice title
        $this->pdf->SetFont('Helvetica', 'B', 14);
        $this->pdf->SetTextColor(...self::COLOR_TEXT);
        $this->pdf->SetXY($this->margin, $y);
        $this->pdf->Cell(0, 8, 'HÓA ĐƠN TIỀN PHÒNG KTX', 0, 1, 'L');
    }

    /**
     * Vẽ thông tin hóa đơn: số, ngày, hạn nộp
     */
    private function drawInvoiceInfo(array $invoice): void
    {
        $y = $this->pdf->GetY() + 5;

        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->SetTextColor(...self::COLOR_TEXT);

        // Left column: Invoice details
        $left = $this->margin;
        $this->pdf->SetXY($left, $y);
        $this->pdf->Cell(30, 5, 'Số HĐ:', 0, 0);
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->Cell(30, 5, '#' . $invoice['id'], 0, 1);

        $y += 6;
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->SetXY($left, $y);
        $this->pdf->Cell(30, 5, 'Kỳ:', 0, 0);
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->Cell(30, 5, 'Tháng ' . $invoice['month'] . '/' . $invoice['year'], 0, 1);

        // Right column: Dates
        $right = $this->pageWidth / 2;
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->SetXY($right, $y - 6);
        $this->pdf->Cell(30, 5, 'Ngày lập:', 0, 0);
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->Cell(50, 5, date('d/m/Y', strtotime($invoice['created_at'])), 0, 1);

        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->SetXY($right, $y);
        $this->pdf->Cell(30, 5, 'Hạn nộp:', 0, 0);
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->Cell(50, 5, date('d/m/Y', strtotime($invoice['due_date'])), 0, 1);
    }

    /**
     * Vẽ thông tin sinh viên, phòng
     */
    private function drawStudentInfo(array $invoice): void
    {
        $y = $this->pdf->GetY() + 5;

        $this->pdf->SetFont('Arial', 'B', 11);
        $this->pdf->SetTextColor(...self::COLOR_PRIMARY);
        $this->pdf->SetXY($this->margin, $y);
        $this->pdf->Cell(0, 5, 'THÔNG TIN SINH VIÊN', 0, 1);

        $y += 7;

        // Box background
        $this->pdf->SetFillColor(...self::COLOR_LIGHT);
        $this->pdf->Rect($this->margin, $y, $this->pageWidth - 2 * $this->margin, 30, 'F');

        // Student info
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->SetTextColor(...self::COLOR_TEXT);

        $infoX = $this->margin + 3;
        $this->pdf->SetXY($infoX, $y + 3);
        $this->pdf->Cell(40, 5, 'Họ tên:', 0, 0);
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->Cell(50, 5, $invoice['full_name'], 0, 1);

        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->SetXY($infoX, $y + 10);
        $this->pdf->Cell(40, 5, 'Mã SV:', 0, 0);
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->Cell(50, 5, $invoice['student_code'], 0, 1);

        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->SetXY($infoX, $y + 17);
        $this->pdf->Cell(40, 5, 'Phòng:', 0, 0);
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->Cell(50, 5, $invoice['room_number'] . ' - ' . $invoice['building_name'], 0, 1);

        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->SetXY($infoX, $y + 24);
        $this->pdf->Cell(40, 5, 'Trạng thái:', 0, 0);

        $statusText = $invoice['status'] === 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán';
        $statusColor = $invoice['status'] === 'paid' ? [59, 109, 17] : [163, 45, 45];
        $this->pdf->SetTextColor(...$statusColor);
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->Cell(50, 5, $statusText, 0, 1);
    }

    /**
     * Vẽ bảng chi tiết chi phí
     */
    private function drawItemsTable(array $invoice): void
    {
        $y = $this->pdf->GetY() + 5;

        $this->pdf->SetFont('Arial', 'B', 11);
        $this->pdf->SetTextColor(...self::COLOR_PRIMARY);
        $this->pdf->SetXY($this->margin, $y);
        $this->pdf->Cell(0, 5, 'CHI TIẾT CHI PHÍ', 0, 1);

        $y += 8;

        // Table header
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->SetFillColor(...self::COLOR_PRIMARY);
        $this->pdf->SetTextColor(255, 255, 255);

        $this->pdf->SetXY($this->margin, $y);
        $this->pdf->Cell(100, 6, 'Loại chi phí', 1, 0, 'L', true);
        $this->pdf->Cell(40, 6, 'Số lượng', 1, 0, 'C', true);
        $this->pdf->Cell(30, 6, 'Thành tiền', 1, 1, 'R', true);

        $y += 7;

        // Table rows
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->SetTextColor(...self::COLOR_TEXT);

        // Base rent
        $this->pdf->SetXY($this->margin, $y);
        $this->pdf->Cell(100, 5, 'Tiền phòng', 1, 0, 'L');
        $this->pdf->Cell(40, 5, '1 tháng', 1, 0, 'C');
        $this->pdf->Cell(30, 5, $this->formatCurrency($invoice['base_rent']), 1, 1, 'R');

        $y += 6;

        // Electricity
        if ($invoice['electricity_fee'] > 0) {
            $this->pdf->SetXY($this->margin, $y);
            $this->pdf->Cell(100, 5, 'Tiền điện', 1, 0, 'L');
            $this->pdf->Cell(40, 5, '', 1, 0, 'C');
            $this->pdf->Cell(30, 5, $this->formatCurrency($invoice['electricity_fee']), 1, 1, 'R');
            $y += 6;
        }

        // Water
        if ($invoice['water_fee'] > 0) {
            $this->pdf->SetXY($this->margin, $y);
            $this->pdf->Cell(100, 5, 'Tiền nước', 1, 0, 'L');
            $this->pdf->Cell(40, 5, '', 1, 0, 'C');
            $this->pdf->Cell(30, 5, $this->formatCurrency($invoice['water_fee']), 1, 1, 'R');
            $y += 6;
        }

        // AC fee
        if ($invoice['ac_fee'] > 0) {
            $this->pdf->SetXY($this->margin, $y);
            $this->pdf->Cell(100, 5, 'Phí điều hòa', 1, 0, 'L');
            $this->pdf->Cell(40, 5, '', 1, 0, 'C');
            $this->pdf->Cell(30, 5, $this->formatCurrency($invoice['ac_fee']), 1, 1, 'R');
            $y += 6;
        }

        // Other fees
        $otherFee = isset($invoice['other_fee']) ? (float)$invoice['other_fee'] : 0.0;
        if ($otherFee > 0) {
            $this->pdf->SetXY($this->margin, $y);
            $this->pdf->Cell(100, 5, 'Phí khác', 1, 0, 'L');
            $this->pdf->Cell(40, 5, '', 1, 0, 'C');
            $this->pdf->Cell(30, 5, $this->formatCurrency($otherFee), 1, 1, 'R');
            $y += 6;
        }

        // Discount
        $discount = isset($invoice['discount']) ? (float)$invoice['discount'] : 0.0;
        if ($discount > 0) {
            $this->pdf->SetXY($this->margin, $y);
            $this->pdf->Cell(100, 5, 'Giảm giá', 1, 0, 'L');
            $this->pdf->Cell(40, 5, '', 1, 0, 'C');
            $this->pdf->SetTextColor(59, 109, 17); // Green
            $this->pdf->Cell(30, 5, '-' . $this->formatCurrency($discount), 1, 1, 'R');
            $y += 6;
        }

        // Late fee
        $lateFee = isset($invoice['late_fee']) ? (float)$invoice['late_fee'] : 0.0;
        if ($lateFee > 0) {
            $this->pdf->SetXY($this->margin, $y);
            $this->pdf->SetTextColor(163, 45, 45); // Red
            $this->pdf->Cell(100, 5, 'Phí trễ hạn', 1, 0, 'L');
            $this->pdf->Cell(40, 5, '', 1, 0, 'C');
            $this->pdf->Cell(30, 5, '+' . $this->formatCurrency($lateFee), 1, 1, 'R');
            $y += 6;
        }

        // Total
        $this->pdf->SetXY($this->margin, $y);
        $this->pdf->SetFont('Arial', 'B', 11);
        $this->pdf->SetFillColor(...self::COLOR_PRIMARY);
        $this->pdf->SetTextColor(255, 255, 255);
        $this->pdf->Cell(100, 7, 'TỔNG CỘNG', 1, 0, 'L', true);
        $this->pdf->Cell(40, 7, '', 1, 0, 'C', true);
        $this->pdf->Cell(30, 7, $this->formatCurrency($invoice['total_amount']), 1, 1, 'R', true);
    }

    /**
     * Vẽ thông tin thanh toán
     */
    private function drawPaymentInfo(array $invoice): void
    {
        $y = $this->pdf->GetY() + 5;

        $this->pdf->SetFont('Arial', 'B', 11);
        $this->pdf->SetTextColor(...self::COLOR_PRIMARY);
        $this->pdf->SetXY($this->margin, $y);
        $this->pdf->Cell(0, 5, 'HƯỚNG DẪN THANH TOÁN', 0, 1);

        $y += 8;

        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->SetTextColor(...self::COLOR_TEXT);
        $this->pdf->SetXY($this->margin, $y);

        $paymentText = "1. CHUYỂN KHOẢN NGÂN HÀNG\n"
                     . "   Tài khoản: 1234567890 (Ngân hàng VietcomBank)\n"
                     . "   Nội dung: Hóa đơn #{$invoice['id']} - {$invoice['student_code']}\n\n"
                     . "2. VÍ MOMO: 0988123456\n"
                     . "   Nội dung: HĐ#{$invoice['id']}\n\n"
                     . "3. THANH TOÁN TIỀN MẶT\n"
                     . "   Đến phòng ban quản lý (Tầng 1, Tòa A)\n"
                     . "   Giờ làm việc: 8h-18h, Thứ 2-7";

        $this->pdf->MultiCell(0, 5, $paymentText, 0, 'L');
    }

    /**
     * Vẽ footer với chữ ký, ghi chú
     */
    private function drawFooter(array $invoice): void
    {
        $y = $this->pageHeight - 30;

        $this->pdf->SetXY($this->margin, $y);
        $this->pdf->SetFont('Arial', '', 9);
        $this->pdf->SetTextColor(100, 100, 100);
        $this->pdf->MultiCell(0, 4, 
            "Ghi chú: Vui lòng thanh toán đủ số tiền trước hạn nộp. "
            . "Nếu quá hạn, sẽ bị tính phí trễ hạn 50.000 VND/ngày. "
            . "Mọi thắc mắc vui lòng liên hệ: khoaquanly@ktx.edu.vn",
            0, 'L'
        );

        $y = $this->pageHeight - 15;

        // Signature line
        $this->pdf->SetXY($this->margin, $y);
        $this->pdf->SetFont('Arial', '', 9);
        $this->pdf->SetTextColor(...self::COLOR_TEXT);
        $this->pdf->Cell(0, 5, 'Chữ ký bộ phận tài vụ: ...................................', 0, 1);

        // Footer
        $y = $this->pageHeight - 8;
        $this->pdf->SetXY($this->margin, $y);
        $this->pdf->SetFont('Helvetica', '', 8);
        $this->pdf->SetTextColor(150, 150, 150);
        $this->pdf->Cell(0, 5, 
            'KTX Management System | Trang ' . $this->pdf->PageNo() . ' | ' . date('d/m/Y H:i'),
            0, 0, 'C'
        );
    }

    /**
     * ───────────────────────────────────────────────────────────
     *  HELPERS
     * ───────────────────────────────────────────────────────────
     */

    /**
     * Lấy dữ liệu hóa đơn từ database
     */
    private function getInvoiceData(int $invoiceId): ?array
    {
        return $this->db->selectOne(
            "SELECT i.*, s.full_name, s.student_code, r.room_number, b.name as building_name
             FROM invoices i
             JOIN contracts c ON c.id = i.contract_id
             JOIN students s ON s.id = c.student_id
             JOIN rooms r ON r.id = c.room_id
             JOIN buildings b ON b.id = r.building_id
             WHERE i.id = ?",
            [$invoiceId]
        );
    }

    /**
     * Format currency to Vietnamese format
     */
    private function formatCurrency(float|int|string $amount): string
    {
        return number_format((float)$amount, 0, ',', '.') . ' VND';
    }
}
