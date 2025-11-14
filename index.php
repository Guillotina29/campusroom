<?php
$menu = "principal";
require_once 'inc/header.php';
?>
<section class="main-hero">
    <div class="main-card text-center">
        <h1 class="main-title">Sistema de Reservas de Salas</h1>
        <p class="main-desc">
            Administra fácilmente tus espacios y reuniones.<br>
            Reserva, consulta o gestiona tus salas en segundos.
        </p>
        <div class="main-actions">
            <a href="nueva.php" class="btn-glass">
                <span class="iconify" data-icon="mdi:plus-box"></span> Nueva reservación
            </a>
            <a href="reservas.php" class="btn-glass">
                <span class="iconify" data-icon="mdi:table-eye"></span> Ver reservaciones
            </a>
        </div>
    </div>
</section>
<?php include 'inc/footer.php'; ?>