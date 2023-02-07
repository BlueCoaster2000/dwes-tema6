<?php

namespace dwesgram\controlador;

use dwesgram\modelo\utilidades\Sesion;

abstract class Controlador
{
    protected string|null $vista;

    public function getVista(): string
    {
        return $this->vista;
    }

    public function auntenticado(): bool
    {
        $sesion = new Sesion();
        if (!$sesion->haySesion()) {
            $this->vista = 'errores/403';
            return false;
        }
        return true;
    }
}
