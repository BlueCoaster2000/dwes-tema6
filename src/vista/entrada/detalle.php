<?php

use dwesgram\modelo\UsuarioBd;

if (!empty($datosParaVista['datos']) && $datosParaVista['datos'] != null) {
    $entrada = $datosParaVista['datos'];
    $text = $entrada->getTexto();
    $id = $entrada->getId();
    $imagen = $entrada->getImagen();
    $idCreador =  $entrada->getAutor();
    $nombreUsuario = UsuarioBd::getUsuarioPorId($idCreador);


    echo "<h1> $nombreUsuario escribió</h1>";
    if ($sesion->haySesion() == true && $sesion->getId() == $idCreador) {
        echo "<button type='button' class='btn btn-danger'><a style='text-decoration:none; color:white;' href='index.php?controlador=entrada&accion=eliminar&id={$id}'>Eliminar</a></button>";
    }
    echo <<<END
        <img id="detalle" src="$imagen"/>
        <div class="alert alert-primary" role="alert">
            $text
        </div>
        <p>
    END;
    echo "</p>";
} else {
    echo "<p>No existe esta Entrada</p>";
}
