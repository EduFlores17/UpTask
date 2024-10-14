<div class="contenedor reestablecer">
    <?php 
        include_once __DIR__ . '/../templates/nombre-sitio.php'
    ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Coloca tu nuevo password</p>
        <form action="/" method="POST" class="formulario">
            
            <div class="campo">
                <label for="password">Password</label>
                <input 
                type="password"
                id="password"
                placeholder="Tu password"
                name="password"
                />
            </div>

            <input type="submit" class="boton" value="Guardar password">
        </form>

        <div class="acciones">
            <a href="/crear">No tienes una cuenta, creala aqui</a>
            <a href="/olvide">Olvidaste tu contraseña?</a>
        </div>
    </div><!--.contenedor-sm -->
</div>