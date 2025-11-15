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

    // Use enhanced validation functions
    if (validar_fecha_hora_segundos($fecha, $hora) &&
        validar_fecha_hora_futura($fecha, $hora) &&
        validar_horario_laboral_segundos($hora, $duracion) &&
        no_solapa_segundos($fecha, $hora, $duracion, $sala) &&
        validar_reserva($nombre, $sala, $fecha, $hora, $duracion, $reservas, $errores)) {

        $nueva_reserva = [
            'nombre' => $nombre,
            'sala' => $sala,
            'fecha' => $fecha,
            'hora' => $hora,
            'duracion' => $duracion,
            'created_at' => generar_timestamp(),
            'updated_at' => generar_timestamp()
        ];

        $reservas[] = $nueva_reserva;
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
                    <label for="fecha" class="form-label">Fecha (DD/MM/YYYY)</label>
                    <div class="relative">
                        <input type="text" name="fecha" id="fecha" class="form-control date-input" placeholder="dd/mm/yyyy" required pattern="\d{2}/\d{2}/\d{4}">
                        <button type="button" class="calendar-toggle absolute right-3 top-1/2 transform -translate-y-1/2 text-neutral-400 hover:text-primary transition-colors" id="calendar-toggle">
                            <iconify-icon icon="mdi:calendar"></iconify-icon>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="hora" class="form-label">Hora (HH:MM:SS)</label>
                    <input type="text" name="hora" id="hora" class="form-control time-input" placeholder="hh:mm:ss" required pattern="\d{2}:\d{2}:\d{2}">
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

<!-- Interactive Calendar Container -->
<div id="calendar-container" class="calendar-container hidden" data-calendar data-input="fecha"></div>

<!-- Include JavaScript files -->
<script src="assets/formatting.js"></script>
<script src="assets/validation.js"></script>
<script src="assets/calendar.js"></script>

<script>
// Calendar toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const calendarToggle = document.getElementById('calendar-toggle');
    const calendarContainer = document.getElementById('calendar-container');

    if (calendarToggle && calendarContainer) {
        calendarToggle.addEventListener('click', function() {
            calendarContainer.classList.toggle('hidden');
            calendarToggle.querySelector('iconify-icon').setAttribute('icon',
                calendarContainer.classList.contains('hidden') ? 'mdi:calendar' : 'mdi:calendar-remove'
            );
        });

        // Close calendar when clicking outside
        document.addEventListener('click', function(e) {
            if (!calendarContainer.contains(e.target) && !calendarToggle.contains(e.target)) {
                calendarContainer.classList.add('hidden');
                calendarToggle.querySelector('iconify-icon').setAttribute('icon', 'mdi:calendar');
            }
        });
    }

    // Re-bind formatters after dynamic content
    rebindFormatters();
    rebindValidation();
});
</script>

<?php require_once 'inc/footer.php'; ?>
