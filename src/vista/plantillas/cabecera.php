<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DWESgram</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>
<style>
  button {
    text-align: left;
  }

  .avatar {
    border-radius: 50%;
    width: 2rem;
    height: 2rem;
    border: solid 1px black;
  }


  .avatar img {
    display: block;
    width: 2rem;
    height: 2rem;
    object-fit: contain;
  }
</style>

<body>

  <nav class="navbar navbar-expand-lg bg-body-tertiary mb-4">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">DWESgram</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>

          <?php if ($sesion->haySesion() == true) {
            $id = $sesion->getId();
            $imagen = $sesion->getAvatar();
            $avatar = "<img src='" . $imagen . "'>"
          ?>
            <li class="nav-item">
              <a class="nav-link" href="index.php?controlador=entrada&accion=nuevo&id=<?= $id ?>">Crear entrada</a>
            </li>
        </ul>
        <a class="nav-link" href="index.php?controlador=usuario&accion=logout">Cerrar Sesión <?= "( <strong>" . $sesion->getNombre() . "</strong> )" . "<div class='avatar'>" . $avatar . "</div>" ?></a>
      <? } else { ?>
        <button type="button" class="btn btn-outline-secondary btn-sm"> <a class="nav-link" href="index.php?controlador=usuario&accion=login">Iniciar Sesión</a></button>
        <button type="button" class="btn btn-outline-secondary btn-sm"> <a class="nav-link" href="index.php?controlador=usuario&accion=registro">Crear una cuenta</a></button>
      <? } ?>
      </div>
    </div>
  </nav>