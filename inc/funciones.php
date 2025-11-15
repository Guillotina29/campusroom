<?php
require_once(__DIR__ . '/config.php');

function leer_reservas() {
    $contenido = file_get_contents(RESERVAS_FILE);
    $json = json_decode($contenido, true);
    return is_array($json) ? $json : [];
}

function guardar_reservas($reservas) {
    file_put_contents(RESERVAS_FILE, json_encode($reservas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function validar_fecha_hora($fecha, $hora) {
    $dt = DateTime::createFromFormat('d/m/Y H:i', "$fecha $hora");
    return $dt && $dt->format('d/m/Y H:i') === "$fecha $hora";
}

function validar_futuro($fecha, $hora) {
    $dt = DateTime::createFromFormat('d/m/Y H:i', "$fecha $hora");
    return ($dt && $dt >= new DateTime());
}

function validar_horario_laboral($hora, $duracion) {
    $ini = DateTime::createFromFormat('H:i', HORARIO_INICIO);
    $fin = DateTime::createFromFormat('H:i', HORARIO_FIN);
    $start = DateTime::createFromFormat('H:i', $hora);
    $end = clone $start;
    $end->add(new DateInterval("PT{$duracion}M"));
    return $start >= $ini && $end <= $fin;
}

function no_solapa($fecha, $hora, $duracion, $sala) {
    $reservas = leer_reservas();
    $inicio = DateTime::createFromFormat('d/m/Y H:i', "$fecha $hora");
    $fin = clone $inicio;
    $fin->add(new DateInterval("PT{$duracion}M"));
    foreach ($reservas as $r) {
        if ($r['sala'] !== $sala) continue;
        $r_ini = DateTime::createFromFormat('d/m/Y H:i', $r['fecha'].' '.$r['hora']);
        $r_fin = clone $r_ini;
        $r_fin->add(new DateInterval("PT{$r['duracion']}M"));
        if ($r_ini && $r_fin && $inicio < $r_fin && $fin > $r_ini) return false;
    }
    return true;
}

function clean_input($val) {
    return htmlspecialchars(strip_tags(trim($val)), ENT_QUOTES, 'UTF-8');
}

function formatear_iso8601($fecha, $hora) {
    $dt = DateTime::createFromFormat('d/m/Y H:i', "$fecha $hora");
    return $dt ? $dt->format('c') : null;
}

function generar_timestamp() {
    $dt = new DateTime('now', new DateTimeZone('America/Santo_Domingo'));
    return $dt->format('c');
}

function formatear_fecha_hora($fecha, $hora) {
    $dt = DateTime::createFromFormat('d/m/Y H:i:s', "$fecha $hora", new DateTimeZone('America/Santo_Domingo'));
    return $dt ? $dt->format('d/m/Y H:i:s') : null;
}

function validar_fecha_hora_segundos($fecha, $hora) {
    $dt = DateTime::createFromFormat('d/m/Y H:i:s', "$fecha $hora");
    return $dt && $dt->format('d/m/Y H:i:s') === "$fecha $hora";
}

function validar_fecha_hora_futura($fecha, $hora) {
    $dt = DateTime::createFromFormat('d/m/Y H:i:s', "$fecha $hora", new DateTimeZone('America/Santo_Domingo'));
    return ($dt && $dt >= new DateTime('now', new DateTimeZone('America/Santo_Domingo')));
}

function validar_horario_laboral_segundos($hora, $duracion) {
    $ini = DateTime::createFromFormat('H:i:s', HORARIO_INICIO . ':00');
    $fin = DateTime::createFromFormat('H:i:s', HORARIO_FIN . ':00');
    $start = DateTime::createFromFormat('H:i:s', $hora);
    $end = clone $start;
    $end->add(new DateInterval("PT{$duracion}M"));
    return $start >= $ini && $end <= $fin;
}

function no_solapa_segundos($fecha, $hora, $duracion, $sala) {
    $reservas = leer_reservas();
    $inicio = DateTime::createFromFormat('d/m/Y H:i:s', "$fecha $hora", new DateTimeZone('America/Santo_Domingo'));
    $fin = clone $inicio;
    $fin->add(new DateInterval("PT{$duracion}M"));
    foreach ($reservas as $r) {
        if ($r['sala'] !== $sala) continue;
        $r_inicio = isset($r['created_at']) ?
            new DateTime($r['created_at']) :
            DateTime::createFromFormat('d/m/Y H:i', $r['fecha'].' '.$r['hora'], new DateTimeZone('America/Santo_Domingo'));
        $r_fin = clone $r_inicio;
        $r_fin->add(new DateInterval("PT{$r['duracion']}M"));
        if ($r_inicio && $r_fin && $inicio < $r_fin && $fin > $r_inicio) return false;
    }
    return true;
}

function formatear_timestamp_legible($timestamp) {
    $dt = new DateTime($timestamp, new DateTimeZone('America/Santo_Domingo'));
    return $dt->format('d/m/Y H:i:s');
}

function redirigir($url_relativa) {
    header('Location: ' . BASE_URL . $url_relativa);
    exit();
}

function validar_reserva($nombre, $sala, $fecha, $hora, $duracion, $reservas, &$errores) {
    if (empty($nombre)) $errores[] = "El nombre es obligatorio.";
    if (!array_key_exists($sala, SALAS)) $errores[] = "Sala no válida.";
    if (!validar_fecha_hora($fecha, $hora)) $errores[] = "Formato de fecha/hora incorrecto (Ej: 12/11/2025 y 14:00).";
    if (!validar_futuro($fecha, $hora)) $errores[] = "La fecha/hora debe estar en el futuro.";
    if (!in_array($duracion, DURACIONES)) $errores[] = "Duración no permitida.";
    if (!validar_horario_laboral($hora, $duracion)) $errores[] = "Horario fuera del rango permitido.";
    if (!no_solapa($fecha, $hora, $duracion, $sala)) $errores[] = "Solapamiento con otra reserva en la sala seleccionada.";
    return empty($errores);
}
?>