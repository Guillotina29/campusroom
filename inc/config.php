<?php
date_default_timezone_set('America/Santo_Domingo');

define('APP_NAME', 'Sistema de Reservas');
define('BASE_URL', 'http://localhost/campusroom');

define('HORARIO_INICIO', '08:00');
define('HORARIO_FIN', '18:00');

// Salas asociativas para nombre y código
define('SALAS', [
    'A' => 'Sala de exposición',
    'B' => 'Sala de reuniones',
    'C' => 'Sala de debate',
]);

define('DURACIONES', [30, 60, 90, 120]);
define('RESERVAS_FILE', __DIR__ . '/../data/reservas.json');

if (!file_exists(RESERVAS_FILE)) {
    file_put_contents(RESERVAS_FILE, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
?>