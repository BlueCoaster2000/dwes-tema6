<?php

namespace dwesgram\modelo;

use dwesgram\modelo\Entrada;
use dwesgram\modelo\BaseDatos;
use LDAP\Result;

class EntradaBd
{
    use BaseDatos;

    public static function getEntradas(): array
    {
        try {
            $resultado = [];
            $conexion = BaseDatos::getConexion();
            $queryResultado = $conexion->query("select id,texto,autor,imagen,creado from entrada order by id desc");
            if ($queryResultado !== false) {
                while (($fila = $queryResultado->fetch_assoc()) != null) {
                    $entrada = new Entrada(
                        id: $fila['id'],
                        texto: $fila['texto'],
                        imagen: $fila['imagen'],
                        autor: $fila['autor'],
                        creado: $fila['creado']
                    );
                    $resultado[] = $entrada;
                }
                return $resultado;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }




    public static function getEntrada(int $id): Entrada|null
    {
        try {
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("select id,texto,imagen,autor,creado from entrada where id=?");
            $sentencia->bind_param('i', $id);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $fila = $resultado->fetch_assoc();
            if ($fila == null) {
                return null;
            } else {
                return new Entrada(
                    id: $fila['id'],
                    texto: $fila['texto'],
                    imagen: $fila['imagen'],
                    autor: $fila['autor'],
                    creado: $fila['creado']
                );
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public static function insertar(Entrada $entrada): int|null
    {
        try {
            $idautor = $entrada->getAutor();
            $texto = $entrada->getTexto();
            $imagen = $entrada->getImagen();
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("insert into entrada (autor,texto,imagen) values (?,?,?)");
            $sentencia->bind_param('iss', $idautor, $texto, $imagen);
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

    public static function eliminar(int $id): bool
    {
        try {
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("delete from entrada where id = ?");
            $sentencia->bind_param('i', $id);
            return $sentencia->execute();
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function getAutorByEntradas(int $idAutor): array|null
    {
        try {
            $result = [];
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("select id,texto,imagen,autor,creado from entrada where autor=?");
            $sentencia->bind_param('i', $idAutor);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $fila = $resultado->fetch_assoc();
            if ($fila == null) {
                return [];
            } else {
                $entrada = new Entrada(
                    id: $fila['id'],
                    texto: $fila['texto'],
                    imagen: $fila['imagen'],
                    autor: $fila['autor']
                );
                $result[] = $entrada;
                return $result;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }
}
