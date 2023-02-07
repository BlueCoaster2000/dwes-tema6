<?php

namespace dwesgram\modelo;

use DateTime;
use dwesgram\modelo\Modelo;

class Entrada extends Modelo
{
    public array $errores = [];

    public function __construct(
        private string|null $texto,
        private int|null $id = null,
        private string|null $imagen = null,
        private string|null $autor = null,
        private int|null $creado = null
    ) {
        $this->errores = [
            'texto' => $texto === null || empty($texto) ? 'El texto no puede estar vacío' : null,
            'imagen' => null
        ];
    }
    public static function crearEntradaDesdePost(array $POST, array $FILE)
    {
        $idAutor = htmlentities(trim($POST['id']));
        $texto = $POST && isset($POST['texto']) ? htmlentities(trim($POST['texto'])) : "";
        $imagen = "./imagenes/default.jpg";
        if ($POST && isset($FILE['imagen']) && $FILE['imagen']['error'] == 0 && $FILE['imagen']['size'] > 0 ||  $FILE['imagen']['name'] > 0) {
            $imagen = null;
            $imagenTmp = $FILE['imagen']['tmp_name'];
            $tipoMIME = getimagesize($imagenTmp);
            $tipo = $tipoMIME['mime'];
            if ($tipo == "image/png" || $tipo == "image/jpeg" || $tipo == "image/jpg") {

                $ext = substr($tipo, 6);
                $fechaAct = date_create();
                $ruta = './imagenes/' . basename(date_timestamp_get($fechaAct) . "." . $ext);
                $movido = move_uploaded_file($FILE['imagen']['tmp_name'], $ruta);
                if ($movido == true) {
                    $imagen = $ruta;
                } else {
                    $imagen = null;
                }
            }
        }

        if ($imagen !==  null) {
            return new Entrada(
                autor: $idAutor,
                texto: $texto,
                imagen: $imagen
            );
        } else {
            $imagen = null;
            return new Entrada(
                autor: $idAutor,
                texto: $texto,
                imagen: $imagen
            );
        }
    }
    public function getId(): int|null
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTexto(): string
    {
        return $this->texto ? $this->texto : '';
    }

    public function getAutor(): string
    {
        return $this->autor ? $this->autor : '';
    }

    public function getImagen(): string|null
    {
        return $this->imagen;
    }

    public function esValida(): bool
    {
        if ($this->texto == null || $this->imagen == null) {
            return false;
        } else {
            return true;
        }
    }

    public function getErrores(): array
    {
        $errores = [
            'texto' => null,
            'imagen' => null
        ];
        if ($this->texto == null || empty($this->texto)) {
            $errores['texto'] = "El texto no puede estar vacío";
        }
        if ($this->imagen == null || empty($this->imagen)) {
            $errores['imagen'] = "Error: Tipo de fichero no admitido";
        }

        return $errores;
    }
}
