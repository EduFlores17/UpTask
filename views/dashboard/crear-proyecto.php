<?php include_once __DIR__ . '/header.dashboard.php' ?>


<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php' ?>

    <form method="POST" class="formulario" action="/crear-proyecto">

        <?php include_once __DIR__ . '/formulario-proyecto.php'  ?>
        <input type="submit" value="Crear proyecto">
    </form>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php' ?>