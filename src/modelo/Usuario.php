<?php

namespace dwesgram\modelo;

use dwesgram\modelo\Modelo;

class Usuario extends Modelo
{
    private array $errores = [];


    public function __construct(
        private int|null $id = null,
        private string|null $nombre = null,
        private string|null $email = null,
        private string|null $clave = null,
        private string|null $avatar = null,
        private int|null $creado = null
    ) {
    }


    public static function crearUsuarioDesdePost(array $POST, array $FILES): Usuario
    {
        //Para validar la imagen y en el caso de no haberla se le da una por defecto
        $avatar = "./assets/img/default.png";
        if ($POST && isset($FILES['avatar']) && $FILES['avatar']['error'] == 0 && $FILES['avatar']['size'] > 0 ||  $FILES['avatar']['name'] > 0) {
            $avatar = null;
            $tipoMIME = $FILES['avatar']['type'];
            if ($tipoMIME == "image/png" ||  $tipoMIME == "image/jpeg") {

                $ext = substr($tipoMIME, 6);
                $fechaAct = date_create();
                $ruta = './assets/img/' . basename(date_timestamp_get($fechaAct) . "." . $ext);
                $movido = move_uploaded_file($FILES['avatar']['tmp_name'], $ruta);
                if ($movido == true) {
                    $avatar = $ruta;
                } else {
                    $avatar = null;
                }
            }
        }
        $usuario = new Usuario(
            nombre: $POST && $POST['nombre'] ? htmlentities(trim($POST['nombre'])) : null,
            email: $POST && $POST['email'] ? htmlentities(trim($POST['email'])) : null,
            clave: $POST && $POST['clave'] ? htmlentities(trim($POST['clave'])) : null,
            avatar: $avatar


        );

        $repiteClave =  $POST && $POST['repiteclave'] ? htmlentities(trim($POST['repiteclave'])) : null;
        $claveUser = $usuario->getClave();
        if ($claveUser != $repiteClave) {
            $usuario->errores['clave'] = "ERROR: Las claves no son iguales";
        }

        if (mb_strlen($usuario->getClave() < 8)) {
            $usuario->errores['clave'] = "ERROR: La contraseña debe contener al menos 8 carácteres";
        }
        if ($usuario->getAvatar() == null) {
            $usuario->errores['avatar'] = "ERROR: Tipo de fichero no admitido";
        }
        if ((mb_strlen($usuario->getNombre()) === 0) && (mb_strlen($usuario->getEmail()) === 0)) {
            $usuario->errores['nombre'] = "ERROR: El nombre de usuario no puede estar vacío";
            $usuario->errores['email'] = "ERROR: El email no puede estar vacío";
        } else {
            $comprobarNombre = UsuarioBd::getUsuarioPorNombre($usuario->getNombre());
            if ($comprobarNombre !== null) {
                $usuario->errores['nombre'] = "ERROR: Ese nombre no está dsponible";
            }
        }
        return $usuario;
    }

    /**Getters & Setters del usuario */
    public function getId(): int|null
    {
        return $this->id;
    }
    public function setId($id): void
    {
        $this->id = $id;
    }


    public function getNombre(): string|null
    {
        return $this->nombre;
    }
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }


    public function getEmail(): string|null
    {
        return $this->email;
    }
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function getAvatar(): string|null
    {
        return $this->avatar;
    }
    public function setAvatar($avatar): void
    {
        $this->avatar = $avatar;
    }

    public function getClave(): string|null
    {
        return $this->clave;
    }
    public function setClave($clave): void
    {
        $this->clave = $clave;
    }

    public function esValido(): bool
    {
        return (count($this->errores) == 0);
    }
    public function getErrores(): array
    {
        return $this->errores;
    }
}
