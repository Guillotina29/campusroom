<?php
$page_title = 'Historial de Reservas - CampusRoom';
$menu = "tabla";
require_once 'inc/layout.php';
require_once 'inc/funciones.php';

$reservas = leer_reservas();
?>

<div class="max-w-6xl mx-auto">
    <div class="card fade-in">
        <div class="card-header">
            <h1 class="text-2xl font-semibold text-dark">Historial de Reservas</h1>
        </div>

        <div class="card-body">
            <?php if (empty($reservas)): ?>
                <div class="text-center py-12">
                    <iconify-icon icon="mdi:calendar-blank-outline" class="text-6xl text-neutral-400 mb-4"></iconify-icon>
                    <h3 class="text-xl font-medium text-neutral-600 mb-2">No hay reservas registradas</h3>
                    <p class="text-neutral-500 mb-6">Sé el primero en crear una reservación</p>
                    <a href="nueva.php" class="btn btn-primary">
                        <iconify-icon icon="mdi:plus"></iconify-icon>
                        Crear primera reservación
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Sala</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Duración</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reservas as $index => $reserva): ?>
                            <tr class="slide-up" style="animation-delay: <?php echo $index * 0.1; ?>s">
                                <td class="font-medium"><?php echo htmlspecialchars($reserva['nombre']); ?></td>
                                <td>
                                    <span class="badge badge-primary">
                                        <?php echo htmlspecialchars(SALAS[$reserva['sala']] ?? $reserva['sala']); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($reserva['fecha']); ?></td>
                                <td><?php echo htmlspecialchars($reserva['hora']); ?></td>
                                <td><?php echo htmlspecialchars($reserva['duracion']); ?> min</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8">
                    <a href="exportar_csv.php" class="btn btn-success">
                        <iconify-icon icon="mdi:file-excel"></iconify-icon>
                        Exportar Excel
                    </a>
                    <a href="exportar_pdf.php" class="btn btn-danger">
                        <iconify-icon icon="mdi:file-pdf"></iconify-icon>
                        Exportar PDF
                    </a>
                    <a href="nueva.php" class="btn btn-primary">
                        <iconify-icon icon="mdi:plus"></iconify-icon>
                        Nueva reservación
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'inc/footer.php'; ?>
