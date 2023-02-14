<?php

use dwesgram\modelo\MeGustaBd;
use dwesgram\modelo\UsuarioBd;

if (!empty($datosParaVista['datos']) && $datosParaVista['datos'] != null) {
    $entrada = $datosParaVista['datos'];
    $text = $entrada->getTexto();
    $id = $entrada->getId();
    $imagen = $entrada->getImagen();
    $idCreador =  $entrada->getAutor();
    $nombreUsuario = UsuarioBd::getUsuarioPorId($idCreador);
    $meGusta = $entrada->verMg();
    $mgs = count($entrada->verMg());

    echo "<h1> $nombreUsuario escribió</h1>";
    if ($sesion->haySesion() == true) {
        $sesionActual = $sesion->getId();
        $haDadoMeGusta = MeGustaBd::haDadoMg($sesionActual, $id);
        if ($sesion->getId() != $idCreador) {

            if ($mgs != 0) {
                echo <<<END
                    <a href="index.php?controlador=entrada&accion=darMeGusta&route=detalle&entrada={$id}&usuario={$idCreador}"><img src="./assets/recursos/heart-fill.svg"/></a><p>({$mgs})</p>
                    END;
            } else {
                echo <<<END
                    <a href="index.php?controlador=entrada&accion=darMeGusta&route=detalle&entrada={$id}&usuario={$idCreador}"><img src="./assets/recursos/heart.svg"/></a><p>({$mgs})</p>
                    END;
            }
        } else {

            echo "<button type='button' class='btn btn-danger'><a style='text-decoration:none; color:white;' href='index.php?controlador=entrada&accion=eliminar&id={$id}'>Eliminar</a></button>";
            echo <<<END
            <a><img src="./assets/recursos/heart.svg"/></a><p>({$mgs})</p>
            END;
        }
        echo "</p>";
    }
    echo <<<END
    <img id="detalle" src="$imagen"/>
    <div class="alert alert-primary" role="alert">
    $text
    </div>
    <p>
    END;
} else {
    echo "<p>No existe esta Entrada</p>";
}
