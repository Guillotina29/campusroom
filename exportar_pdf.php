<?php
require_once 'inc/config.php';
require_once 'inc/funciones.php';
require_once 'fpdf186/fpdf.php';

// Extender FPDF para agregar métodos personalizados
class PDF extends FPDF {
    function Header() {
        // Logo o título
        $this->SetFont('Arial', 'B', 16);
        $this->SetTextColor(0, 123, 255); // Color azul
        $this->Cell(0, 10, utf8_decode('CampusRoom - Historial de Reservas'), 0, 1, 'C');
        $this->Ln(5);

        // Fecha de generación
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(100, 100, 100);
        $this->Cell(0, 5, utf8_decode('Generado el: ' . date('d/m/Y H:i:s')), 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128, 128, 128);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Crear instancia del PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

// Leer reservas
$reservas = leer_reservas();

// Encabezados de tabla
$header = array('Nombre', 'Sala', 'Fecha', 'Hora', 'Duración');

// Colores para la tabla
$headerColor = array(0, 123, 255); // Azul
$rowColor1 = array(245, 245, 245); // Gris claro
$rowColor2 = array(255, 255, 255); // Blanco

// Ancho de columnas
$w = array(40, 30, 30, 25, 25);

// Header de tabla
$pdf->SetFillColor($headerColor[0], $headerColor[1], $headerColor[2]);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial', 'B', 10);

for ($i = 0; $i < count($header); $i++) {
    $pdf->Cell($w[$i], 10, utf8_decode($header[$i]), 1, 0, 'C', true);
}
$pdf->Ln();

// Datos de la tabla
$pdf->SetFont('Arial', '', 9);
$pdf->SetTextColor(0, 0, 0);

$fill = false;
foreach ($reservas as $reserva) {
    $pdf->SetFillColor($fill ? $rowColor1[0] : $rowColor2[0],
                      $fill ? $rowColor1[1] : $rowColor2[1],
                      $fill ? $rowColor1[2] : $rowColor2[2]);

    $pdf->Cell($w[0], 8, utf8_decode($reserva['nombre']), 1, 0, 'L', $fill);
    $pdf->Cell($w[1], 8, utf8_decode(SALAS[$reserva['sala']] ?? $reserva['sala']), 1, 0, 'C', $fill);
    $pdf->Cell($w[2], 8, utf8_decode($reserva['fecha']), 1, 0, 'C', $fill);
    $pdf->Cell($w[3], 8, utf8_decode($reserva['hora']), 1, 0, 'C', $fill);
    $pdf->Cell($w[4], 8, utf8_decode($reserva['duracion'] . ' min'), 1, 0, 'C', $fill);
    $pdf->Ln();

    $fill = !$fill;
}

// Total de reservas
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 123, 255);
$pdf->Cell(0, 10, utf8_decode('Total de reservas: ' . count($reservas)), 0, 1, 'L');

// Configurar headers para descarga
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="reservas_' . date('Y-m-d_H-i-s') . '.pdf"');
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');

// Generar y enviar PDF
$pdf->Output('D');
exit();
?>
