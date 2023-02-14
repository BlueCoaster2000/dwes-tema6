<?php

namespace dwesgram\modelo;

use dwesgram\modelo\MeGusta;
use dwesgram\modelo\BaseDatos;

class MeGustaBd
{

    use BaseDatos;


    public static function getMeGustas(int $idEntrada): array|null
    {
        try {
            $array = [];
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("select id,usuario,entrada from megusta where entrada=?");
            $sentencia->bind_param('i', $idEntrada);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            while (($fila = $resultado->fetch_assoc()) != null) {
                $meGusta = new MeGusta(
                    id: $fila['id'],
                    usuario: $fila['usuario'],
                    entrada: $fila['entrada']

                );
                $array[] = $meGusta;
            }
            return $array;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }
    public static function getMeGustaByEntrada(int $idEntrada): MeGusta|null
    {
        try {

            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("select id,usuario,entrada from megusta where entrada=?");
            $sentencia->bind_param('i', $idEntrada);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $fila = $resultado->fetch_assoc();
            if ($fila == null) {
                return null;
            } else {
                $meGusta = new MeGusta(
                    id: $fila['id'],
                    usuario: $fila['usuario'],
                    entrada: $fila['entrada']
                );
                return $meGusta;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }
    public static function darMeGusta($idUsuario, $idEntrada): bool|null
    {
        try {
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("insert into megusta (usuario,entrada) values (?,?)");
            $sentencia->bind_param('ii', $idUsuario, $idEntrada);
            $sentencia->execute();
            if ($sentencia == true) {
                return $conexion->insert_id;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }
    public static function quitarMeGusta($idUsuario, $idEntrada)
    {
        try {
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("delete from megusta where usuario = ? and entrada = ?");
            $sentencia->bind_param('ii', $idUsuario, $idEntrada);
            $sentencia->execute();
            if ($sentencia == true) {
                return $conexion->insert_id;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }
    public static function haDadoMg($idUsuario, $idEntrada)
    {
        try {
            $arraymG = [];
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("select * from megusta where usuario = ? and entrada = ?");
            $sentencia->bind_param('ii', $idUsuario, $idEntrada);
            $sentencia->execute();
            if ($sentencia == true) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
