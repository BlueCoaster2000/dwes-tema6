<?php

namespace dwesgram\controlador;

use dwesgram\controlador\Controlador;
use dwesgram\modelo\Entrada;
use dwesgram\modelo\EntradaBd;
use dwesgram\modelo\utilidades\Sesion;

class EntradaControlador extends Controlador
{

    public function lista(): array
    {

        $this->vista = 'lista';
        return EntradaBd::getEntradas();
    }

    public function detalle(): Entrada|null
    {
        $this->vista = 'entrada/detalle';
        $id = htmlspecialchars($_GET['id']);
        return EntradaBd::getEntrada($id);
    }

    public function nuevo(): Entrada|null
    {
        if (!$this->auntenticado()) {
            header('Location:index.php');
            return null;
        }
        if (!$_POST) {
            $this->vista = 'entrada/nuevo';
            return null;
        }

        $entrada = Entrada::crearEntradaDesdePost($_POST, $_FILES);
        if ($entrada->esValida()) {

            $this->vista = 'entrada/detalle';
            $entrada->setId(EntradaBd::insertar($entrada));
            return $entrada;
        } else {
            $this->vista = 'entrada/nuevo';
            return $entrada;
        }
    }

    public function eliminar(): bool
    {
        if (!$this->auntenticado()) {
            header('Location:index.php');
            return null;
        }
        $this->vista = "entrada/eliminar";
        $id = $_GET && isset($_GET['id']) ? htmlspecialchars($_GET['id']) : null;
        if ($id !== null) {
            $entradaAEliminar = EntradaBd::getEntrada($id);
            $idAutorAEliminar = $entradaAEliminar->getAutor();
            $sesion = new Sesion;
            if ($sesion->getId() == $idAutorAEliminar) {
                return EntradaBd::eliminar($id);
            } else {

                header('Location:index.php');
            }
        } else {
            return false;
        }
        return false;
    }
}
