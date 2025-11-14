<?php include_once(__DIR__ . "/../inc/header.php"); ?>

<main class="main-content">
    <div class="page-container">
        <h1 class="page-title">Contacto</h1>
        <p class="page-date">Última actualización: <?= date("d/m/Y"); ?></p>

        <section class="page-section">
            <form method="POST" action="#" class="contact-form">

                <label>
                    Nombre:
                    <input type="text" name="nombre" required>
                </label>

                <label>
                    Correo:
                    <input type="email" name="correo" required>
                </label>

                <label>
                    Mensaje:
                    <textarea name="mensaje" rows="5" required></textarea>
                </label>

                <button type="submit" class="btn-glass">Enviar mensaje</button>
            </form>
        </section>
    </div>
</main>

<?php include_once(__DIR__ . "/../inc/footer.php"); ?>
