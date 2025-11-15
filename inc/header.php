<?php
require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/flash.php');
if (!isset($menu)) $menu = 'principal';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="<?= BASE_URL ?>/assets/animations.js" defer></script>
    <script src="<?= BASE_URL ?>/assets/hamburger.js" defer></script>
</head>

<body>
    <header class="glass-header">
   
        <nav class="mb-4 text-center">
            <?php if ($menu !== 'principal'): ?>
                <button class="btn btn-secondary" onclick="location.href='<?= BASE_URL ?>/index.php'">
                    <iconify-icon icon="mdi:home"></iconify-icon>
                    Volver al menú principal
                </button>
            <?php endif; ?>
            <?php if ($menu === 'reserva' || $menu === 'tabla'): ?>
                <button class="btn btn-primary" onclick="location.href='<?= BASE_URL ?>/nueva.php'">
                    <iconify-icon icon="mdi:plus-box"></iconify-icon>
                    Nueva reservación
                </button>
                <button class="btn btn-accent" onclick="location.href='<?= BASE_URL ?>/reservas.php'">
                    <iconify-icon icon="mdi:table-eye"></iconify-icon>
                    Ver reservas
                </button>
            <?php endif; ?>
        </nav>
    </header>
    <main class="main-glass d-flex flex-column align-items-center justify-content-center">
        <?php show_flash(); ?>