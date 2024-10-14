<div class="contenedor olvide">
    <?php 
        include_once __DIR__ . '/../templates/nombre-sitio.php'
    ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Recupera tu acceso UpTask</p>
        <form action="/" method="POST" class="formulario">
            <div class="campo">
                <label for="email">Email</label>
                <input 
                type="email"
                id="email"
                placeholder="Tu email"
                name="email"
                />
            </div>

            <input type="submit" class="boton" value="Iniciar sesión">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta? Inicia sesión.</a>
            <a href="/crear">No tienes una cuenta, creala aqui.</a>
        </div>
    </div><!--.contenedor-sm -->
</div>