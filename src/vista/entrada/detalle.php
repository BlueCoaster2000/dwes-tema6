<?php
if (!empty($datosParaVista['datos']) && $datosParaVista['datos'] != null) {
    $entrada = $datosParaVista['datos'];
    $text = $entrada->getTexto();
    $imagen = $entrada->getImagen();


    echo <<<END
    <h1>Que bacanería</h1>
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
