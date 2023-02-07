<?php

namespace dwesgram\controlador;

use dwesgram\modelo\Usuario;
use dwesgram\modelo\UsuarioBd;


class UsuarioControlador extends Controlador
{
    public function login(): array|string|null
    {
        if ($this->auntenticado()) {
            header('Location:index.php');
            return null;
        }
        if (!$_POST) {
            $this->vista = 'usuario/login';
            return null;
        }

        $nombre = htmlentities(trim($_POST['nombre']));
        $clave = htmlentities(trim($_POST['clave']));

        $usuario = UsuarioBd::getUsuarioPorNombre($nombre);
        if ($usuario !== null && (password_verify($clave, $usuario->getClave()) == true)) {
            $_SESSION['usuario'] = [
                'id' => $usuario->getId(),
                'nombre' => $usuario->getNombre(),
                'avatar' => $usuario->getAvatar()
            ];
            header('Location:index.php');
            return null;
        } else {
            $this->vista = 'usuario/login';
            return [
                'nombre' => $nombre,
                'error' => "No se ha podido iniciar sesión correctamente"
            ];
        }
    }

    public function registro(): Usuario|string|null
    {

        if ($this->auntenticado()) {
            header('Location:index.php');
            return null;
        }

        //Si no tenemos POST cargamos el formulaio vacío
        if (!$_POST) {
            $this->vista = 'usuario/registro';
            return null;
        }

        $usuario = Usuario::crearUsuarioDesdePost($_POST, $_FILES);

        if (!$usuario->esValido()) {
            $this->vista = 'usuario/registro';
            return $usuario;
        }

        /**
         * Si el usuario es Valido
         * lo insertamos en la base de datos
         */
        $id = UsuarioBd::insertar($usuario);
        if ($id !== null) {
            $this->vista = 'usuario/mensaje';
            return 'Te has registrado correctamente';
        } else {
            $this->vista = 'usuario/mensaje';
            return 'ERROR: Ha ocurrido un problema con el registro';
        }
    }

    public function logout(): void
    {
        if (!$this->auntenticado()) {
            header('Location:index.php');
            return;
        }

        session_destroy();
        header('Location:index.php');
    }
}
