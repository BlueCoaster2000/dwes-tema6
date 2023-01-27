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
if (!empty($datosParaVista['datos'])) {
    echo "<hr>";
    foreach ($datosParaVista['datos'] as $entrada) {
        $texto = $entrada->getTexto();
        $imagen = $entrada->getImagen();
        $id = $entrada->getId();
        echo <<<END
            <div class="grid">
            <div>
            <img id="lista" src="$imagen"/>
            $texto

                <a href="index.php?controlador=entrada&accion=detalle&id={$id}">Detalles</a>
            END;
        //if($sesion->haySesion()){
        echo <<<END
                <a href="index.php?controlador=entrada&accion=actualizar&id={$id}">Editar</a>
                <a href="index.php?controlador=entrada&accion=eliminar&id={$id}">Eliminar</a>
                </div>
                </div>
                <hr>
            END;
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