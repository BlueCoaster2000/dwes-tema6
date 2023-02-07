<?php
$valores = $datosParaVista['datos'];
$nombre = $valores !== null && isset($valores['nombre']) ? $valores['nombre'] : '';
$error = $valores !== null && isset($valores['error']) ? $valores['error'] : '';
$alert =  $_POST ? ' <div class="alert alert-danger" role="alert">' . $error . "</div>" : '';
?>
<div class="container">
    <h1>Inicia sesión</h1>

    <form action="index.php?controlador=usuario&accion=login" method="post">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de usuario</label><br>
            <input type="text" id="nombre" name="nombre" value="<?= $nombre ?>">
        </div>
        <?= $alert ?>
        <div class="mb-3">
            <label for="clave" class="form-label">Contraseña</label><br>
            <input type="password" id="clave" name="clave">
        </div>
        <button type="submit" class="btn btn-primary">Entrar</button>
    </form>
</div>