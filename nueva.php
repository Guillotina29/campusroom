<?php
$page_title = 'Nueva Reservación - CampusRoom';
$menu = "reserva";
require_once 'inc/layout.php';
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

<div class="max-w-2xl mx-auto">
    <div class="card fade-in">
        <div class="card-header">
            <h1 class="text-2xl font-semibold text-dark">Crear nueva reservación</h1>
        </div>

        <div class="card-body">
            <?php if (!empty($errores)): ?>
                <div class="alert alert-danger">
                    <ul class="list-disc list-inside">
                        <?php foreach ($errores as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" autocomplete="off" class="space-y-6">
                <div class="form-group">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingresa tu nombre completo" required>
                </div>

                <div class="form-group">
                    <label for="sala" class="form-label">Sala</label>
                    <select name="sala" id="sala" class="form-select" required>
                        <option value="">Selecciona una sala</option>
                        <?php foreach (SALAS as $codigo => $nombreSala): ?>
                            <option value="<?php echo $codigo; ?>"><?php echo htmlspecialchars($nombreSala); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="fecha" class="form-label">Fecha (DD/MM/AAAA)</label>
                    <input type="text" name="fecha" id="fecha" class="form-control" placeholder="dd/mm/yyyy" required pattern="\d{2}/\d{2}/\d{4}">
                </div>

                <div class="form-group">
                    <label for="hora" class="form-label">Hora (HH:MM 24h)</label>
                    <input type="text" name="hora" id="hora" class="form-control" placeholder="hh:mm" required pattern="\d{2}:\d{2}">
                </div>

                <div class="form-group">
                    <label for="duracion" class="form-label">Duración (minutos)</label>
                    <select name="duracion" id="duracion" class="form-select" required>
                        <option value="">Selecciona duración</option>
                        <?php foreach (DURACIONES as $d): ?>
                            <option value="<?php echo $d; ?>"><?php echo $d; ?> minutos</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="btn btn-success btn-lg">
                        <iconify-icon icon="mdi:content-save"></iconify-icon>
                        Crear reservación
                    </button>
                    <a href="index.php" class="btn btn-secondary btn-lg">
                        <iconify-icon icon="mdi:arrow-left"></iconify-icon>
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once 'inc/footer.php'; ?>
