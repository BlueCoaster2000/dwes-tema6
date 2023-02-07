<?php

namespace dwesgram\modelo\utilidades;

class Sesion
{

    private int|null $id;
    private string|null $nombre;
    private string|null $avatar;

    public function __construct()
    {
        $this->id = $_SESSION && isset($_SESSION['usuario']) && isset($_SESSION['usuario']['id']) ? $_SESSION['usuario']['id'] : null;
        $this->nombre = $_SESSION && isset($_SESSION['usuario']) && isset($_SESSION['usuario']['nombre']) ? $_SESSION['usuario']['nombre'] : null;
        $this->avatar = $_SESSION && isset($_SESSION['usuario']) && isset($_SESSION['usuario']['avatar']) ? $_SESSION['usuario']['avatar'] : null;
    }

    public function haySesion(): bool
    {
        return $this->id != null && $this->nombre != null && $this->avatar != null;
    }

    public function mismoUsuario(int $id): bool
    {
        return $this->id === $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }
    public function getAvatar(): string
    {
        return $this->avatar;
    }
}
