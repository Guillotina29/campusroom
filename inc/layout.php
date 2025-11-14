<?php
require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/flash.php');
if (!isset($menu)) $menu = 'principal';
$page_title = $page_title ?? 'CampusRoom';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?> - CampusRoom</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.7/dist/iconify-icon.min.js"></script>
</head>
<body class="font-manrope bg-neutral text-dark min-h-screen flex flex-col">
    <header class="bg-white shadow-soft border-b border-gray-200">
        <div class="container mx-auto px-6 py-4">
            <nav class="flex justify-center space-x-4">
                <?php if ($menu !== 'principal'): ?>
                    <a href="<?php echo BASE_URL; ?>/index.php" class="btn btn-secondary">
                        <iconify-icon icon="mdi:home"></iconify-icon>
                        Volver al menú principal
                    </a>
                <?php endif; ?>
                <?php if ($menu === 'reserva' || $menu === 'tabla'): ?>
                    <a href="<?php echo BASE_URL; ?>/nueva.php" class="btn btn-primary">
                        <iconify-icon icon="mdi:plus"></iconify-icon>
                        Nueva reservación
                    </a>
                    <a href="<?php echo BASE_URL; ?>/reservas.php" class="btn btn-primary">
                        <iconify-icon icon="mdi:table"></iconify-icon>
                        Ver reservas
                    </a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="flex-grow container mx-auto px-6 py-8">
        <?php show_flash(); ?>
        <div class="content-wrapper">
            <?php // Aquí se inserta el contenido específico de cada página ?>
