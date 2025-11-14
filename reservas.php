<?php
$menu = "tabla";
require_once 'inc/header.php';
require_once 'inc/funciones.php';

$reservas = leer_reservas();

$salas_colores = [
    'A' => '#faf7d5',
    'B' => '#d8f8ff',
    'C' => '#f3d7e7',
];
?>
<div class="col-12 col-md-10 col-lg-8 mx-auto">
    <h2 class="mb-4 text-center" style="font-weight: 600; color: #193654;">Historial de Reservas</h2>
    <div class="table-responsive card-glass">
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Sala</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Duración (min)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservas as $reserva): ?>
                <tr style="background: <?= isset($salas_colores[$reserva['sala']]) ? $salas_colores[$reserva['sala']] : '#fff' ?>;">
                    <td><?= htmlspecialchars($reserva['nombre']) ?></td>
                    <td><span class="sala-label sala-<?= $reserva['sala'] ?>">
                        <?= htmlspecialchars(SALAS[$reserva['sala']]) ?>
                    </span></td>
                    <td><?= htmlspecialchars($reserva['fecha']) ?></td>
                    <td><?= htmlspecialchars($reserva['hora']) ?></td>
                    <td><?= htmlspecialchars($reserva['duracion']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="text-center mt-4">
        <a href="exportar_csv.php" class="btn-glass">Exportar CSV</a>
        <a href="exportar_pdf.php" class="btn-glass">Exportar PDF</a>
    </div>
</div>
<?php include 'inc/footer.php'; ?>
