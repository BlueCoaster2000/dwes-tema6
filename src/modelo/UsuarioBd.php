<?php

namespace dwesgram\modelo;

use dwesgram\modelo\Modelo;
use dwesgram\modelo\BaseDatos;

class UsuarioBd extends Modelo
{
    use BaseDatos;
    public static function getUsuarioPorNombre(string $nombre): Usuario|null
    {
        try {
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("select id, nombre, clave, email, avatar from usuario where nombre=?");
            $sentencia->bind_param('s', $nombre);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $fila = $resultado->fetch_assoc();
            if ($fila == null) {
                return null;
            } else {
                return new Usuario(
                    id: $fila['id'],
                    nombre: $fila['nombre'],
                    clave: $fila['clave'],
                    email: $fila['email'],
                    avatar: $fila['avatar']

                );
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }
    public static function insertar(Usuario $usuario): int|null
    {
        try {
            $nombre = $usuario->getNombre();
            $clave = $usuario->getClave();
            $claveHash = password_hash($clave, PASSWORD_BCRYPT);
            $email = $usuario->getEmail();
            $avatar = $usuario->getAvatar();

            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("insert into usuario (nombre,clave,email,avatar) values (?,?,?,?)");
            $sentencia->bind_param('ssss', $nombre, $claveHash, $email, $avatar);
            $sentencia->execute();
            if ($sentencia == true) {
                return $conexion->insert_id;
            } else {
                return $usuario->getId();
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public static function getUsuarioPorId(int $id): string|null
    {
        try {
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("select nombre from usuario where id=?");
            $sentencia->bind_param('i', $id);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $fila = $resultado->fetch_assoc();
            if ($fila == null) {
                return null;
            } else {
                return $fila['nombre'];
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function getErrores(): array
    {
        return [];
    }
}
