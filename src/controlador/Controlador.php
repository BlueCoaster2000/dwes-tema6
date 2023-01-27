<?php
namespace dwesgram\controlador;

abstract class Controlador
{
    protected string|null $vista;

    public function getVista():string
    {
        return $this->vista;
    }

}


