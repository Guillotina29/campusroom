<?php
require_once 'inc/config.php';
require_once 'inc/funciones.php';

// Función para limpiar datos CSV
function clean_csv_data($data) {
    // Remover caracteres de nueva línea y retorno de carro
    $data = str_replace(array("\n", "\r"), '', $data);
    // Escapar comillas dobles
    $data = str_replace('"', '""', $data);
    return $data;
}

// Leer reservas
$reservas = leer_reservas();

// Configurar headers para descarga CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="reservas_' . date('Y-m-d_H-i-s') . '.csv"');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Crear archivo CSV en memoria
$output = fopen('php://output', 'w');

// Escribir BOM para UTF-8 (para compatibilidad con Excel)
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

// Escribir encabezados
fputcsv($output, array('Nombre', 'Sala', 'Fecha', 'Hora', 'Duración (minutos)'));

// Escribir datos
foreach ($reservas as $reserva) {
    $row = array(
        clean_csv_data($reserva['nombre']),
        clean_csv_data(SALAS[$reserva['sala']] ?? $reserva['sala']),
        clean_csv_data($reserva['fecha']),
        clean_csv_data($reserva['hora']),
        clean_csv_data($reserva['duracion'])
    );
    fputcsv($output, $row);
}

fclose($output);
exit();
?>
