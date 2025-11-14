<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

function set_flash($mens, $type = 'success') {
    $_SESSION['flash'] = ['mensaje' => $mens, 'tipo' => $type];
}

function get_flash() {
    if (isset($_SESSION['flash']) && is_array($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

function show_flash() {
    $flash = get_flash();
    if ($flash && isset($flash['mensaje'])) {
        $type = isset($flash['tipo']) ? $flash['tipo'] : 'info';
        echo "<div class='flash-message flash-{$type}'>{$flash['mensaje']}</div>";
    }
}
?>