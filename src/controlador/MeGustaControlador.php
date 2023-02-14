<?php

namespace dwesgram\controlador;

use dwesgram\controlador\Controlador;
use dwesgram\modelo\EntradaBd;
use dwesgram\modelo\MeGustaBd;
use dwesgram\modelo\utilidades\Sesion;

class MeGustaControlador extends Controlador
{
    public static function nuevo(int $identrada, int $usuario): bool
    {
        /*if (!$this->auntenticado()) {
            header('Location:index.php');
            return null;
        }*/

        //  var_dump($identrada);
        // var_dump($usuario);
        if ($identrada !== null &&  $usuario !== null) {
            $megusta = MeGustaBd::darMeGusta($usuario, $identrada);
            $entrada = EntradaBd::getEntrada($identrada);
            //var_dump($megusta);
            if ($megusta == true) {
                // echo "Se ha podido dar me gusta";
                return true;
            } else {
                //echo "No se ha podido";
                return false;
            }
        }
    }
}
