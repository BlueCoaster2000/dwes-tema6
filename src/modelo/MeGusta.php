<?php

namespace dwesgram\modelo;

use dwesgram\modelo\Modelo;

class MeGusta extends Modelo
{
    public function __construct(
        public int|null $id = null,
        public int|null $usuario = null,
        public int|null $entrada = null,

    ) {
    }



    public function getErrores(): array
    {
        return [];
    }
}
