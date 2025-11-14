<?php
$menu = "reserva";
require_once 'inc/header.php';
require_once 'inc/funciones.php';

$nombre = $sala = $fecha = $hora = $duracion = '';
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = clean_input($_POST['nombre'] ?? '');
    $sala = clean_input($_POST['sala'] ?? '');
    $fecha = clean_input($_POST['fecha'] ?? '');
    $hora = clean_input($_POST['hora'] ?? '');
    $duracion = intval($_POST['duracion'] ?? 0);
    $reservas = leer_reservas();
    if (validar_reserva($nombre, $sala, $fecha, $hora, $duracion, $reservas, $errores)) {
        $reservas[] = [
            'nombre' => $nombre,
            'sala' => $sala,
            'fecha' => $fecha,
            'hora' => $hora,
            'duracion' => $duracion
        ];
        guardar_reservas($reservas);
        set_flash('Reserva creada exitosamente.', 'success');
        redirigir('/reservas.php');
    }
}
?>
<div class="col-12 col-md-8 col-lg-6 mx-auto card-glass">
    <h2 class="mb-4 text-center" style="font-weight: 600; color: #193654;">Crear nueva reservación</h2>
    <?php if (!empty($errores)): ?>
        <div class="flash-message flash-danger"><ul><li><?= implode('</li><li>', $errores); ?></li></ul></div>
    <?php endif; ?>
    <form method="POST" autocomplete="off">
        <label for="nombre" class="form-label">Nombre:</label>
        <input type="text" name="nombre" class="form-control input-glass" required>
        
        <label for="sala" class="form-label">Sala:</label>
        <select name="sala" class="form-select input-glass" required>
            <?php foreach (SALAS as $codigo => $nombreSala): ?>
                <option value="<?= $codigo ?>"><?= $nombreSala ?></option>
            <?php endforeach; ?>
        </select>
        
        <label for="fecha" class="form-label">Fecha (DD/MM/AAAA):</label>
        <input type="text" name="fecha" class="form-control input-glass" placeholder="dd/mm/yyyy" required pattern="\d{2}/\d{2}/\d{4}">
        
        <label for="hora" class="form-label">Hora (HH:MM 24h):</label>
        <input type="text" name="hora" class="form-control input-glass" placeholder="hh:mm" required pattern="\d{2}:\d{2}">
        
        <label for="duracion" class="form-label">Duración (minutos):</label>
        <select name="duracion" class="form-select input-glass" required>
            <?php foreach (DURACIONES as $d): ?>
                <option value="<?= $d ?>"><?= $d ?> minutos</option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn-glass">Crear reservación</button>
    </form>
</div>
<?php include 'inc/footer.php'; ?>