<h1>Bienvenido al Inicio</h1>
<style>
    .grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
    }

    .grid div {
        margin: auto;
        width: 100%;
    }

    #lista {
        width: 20rem;
    }
</style>
<?php

use dwesgram\modelo\EntradaBd;
use dwesgram\modelo\MeGustaBd;

if (!empty($datosParaVista['datos'])) {
    echo "<hr>";
    foreach ($datosParaVista['datos'] as $entrada) {
        $texto = $entrada->getTexto();
        $imagen = $entrada->getImagen();
        $id = $entrada->getId();
        $autor = $entrada->getAutor();
        $meGusta = $entrada->verMg();
        $mgs = count($entrada->verMg());


        echo <<<END
            <div class="grid">
            <div>
            <img id="lista" src="$imagen"/>
            $texto

                <a href="index.php?controlador=entrada&accion=detalle&id={$id}">Detalles</a>
            END;



        if ($sesion->haySesion()) {
            $idUsuario = $sesion->getId();
            if ($idUsuario == $autor) {
                echo <<<END
                <a><img src="./assets/recursos/heart.svg"/></a><p>({$mgs})</p>
                END;
            } else {


                if ($mgs == 0) {

                    echo <<<END
                    <a href="index.php?controlador=entrada&accion=darMeGusta&route=lista&entrada={$id}&usuario={$idUsuario}"><img src="./assets/recursos/heart.svg"/></a><p>({$mgs})</p>
                    END;
                } else {
                    echo <<<END
                        <a href="index.php?controlador=entrada&accion=darMeGusta&route=lista&entrada={$id}&usuario={$idUsuario}"><img src="./assets/recursos/heart-fill.svg"/></a><p>({$mgs})</p>
                        
                        END;
                }
            }
            if ($autor == $idUsuario) {
                echo <<<END
                    <a href="index.php?controlador=entrada&accion=eliminar&id={$id}">Eliminar</a>
                    </div>
                    </div>
                    <hr>
                    END;
            }
        } else {

            if ($mgs == 0) {
                echo "<a><img class='ps-2' src='./assets/recursos/heart.svg'/>({$mgs})</a>";
            } else {
                echo "<a><img class='ps-2' src='./assets/recursos/heart-fill.svg'/>({$mgs})</a>";
            }
        }
    }

    echo "</ul>";
} else {
    echo <<<END
        <div class="alert alert-primary" role="alert">
            No hay ninguna imágen posteada
        </div>
    END;
}
?>