<?php

$resultado = $datosParaVista['datos'];

if ($resultado) {
    echo "<div class='alert alert-primary' role='alert'>Tarea Eliminada Correctamente</div>";
} else {
    echo "<div class='alert alert-primary' role='alert'>La tarea no se ha podido eliminar</div>";
}

echo <<<END
    <a href="index.php">Vuelve al Inicio</a>
END;
