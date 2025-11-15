<?php
$page_title = 'CampusRoom - Sistema de Reservas';
$menu = "principal";
require_once 'inc/layout.php';
?>

<section class="hero-section">
    <div class="max-w-4xl mx-auto">
        <div class="card fade-in">
            <div class="card-body text-center py-12">
                <h1 class="text-4xl md:text-5xl font-bold text-dark mb-6">
                    Sistema de Reservas de Salas
                </h1>
                <p class="text-xl text-neutral-600 mb-8 max-w-2xl mx-auto">
                    Administra fácilmente tus espacios y reuniones.<br>
                    Reserva, consulta o gestiona tus salas en segundos con nuestro sistema premium.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="nueva.php" class="btn btn-primary btn-lg">
                        <iconify-icon icon="mdi:plus-box"></iconify-icon>
                        Nueva reservación
                    </a>
                    <a href="reservas.php" class="btn btn-accent btn-lg">
                        <iconify-icon icon="mdi:table-eye"></iconify-icon>
                        Ver reservaciones
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'inc/footer.php'; ?>
