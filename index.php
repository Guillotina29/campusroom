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

                <!-- Información relevante -->
                <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                    <div class="info-card">
                        <iconify-icon icon="mdi:office-building" class="text-3xl text-primary mb-3"></iconify-icon>
                        <h3 class="font-semibold text-dark mb-2">Salas Disponibles</h3>
                        <ul class="text-sm text-neutral-600 text-left">
                            <li>• Sala de Conferencias</li>
                            <li>• Sala de Reuniones</li>
                            <li>• Sala de Entrenamiento</li>
                            <li>• Sala de Trabajo</li>
                        </ul>
                    </div>
                    <div class="info-card">
                        <iconify-icon icon="mdi:clock-outline" class="text-3xl text-primary mb-3"></iconify-icon>
                        <h3 class="font-semibold text-dark mb-2">Horario Disponible</h3>
                        <ul class="text-sm text-neutral-600 text-left">
                            <li>• Lunes a Viernes</li>
                            <li>• 8:00 AM - 6:00 PM</li>
                            <li>• Reservas mínimas: 30 min</li>
                            <li>• Máximo: 4 horas</li>
                        </ul>
                    </div>
                    <div class="info-card">
                        <iconify-icon icon="mdi:information-outline" class="text-3xl text-primary mb-3"></iconify-icon>
                        <h3 class="font-semibold text-dark mb-2">Información General</h3>
                        <ul class="text-sm text-neutral-600 text-left">
                            <li>• Reserva anticipada requerida</li>
                            <li>• Cancelación 24h antes</li>
                            <li>• Máximo 20 personas por sala</li>
                            <li>• Equipos incluidos</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'inc/footer.php'; ?>
