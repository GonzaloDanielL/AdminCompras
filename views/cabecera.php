<?php 
include("../../conexion.php");
date_default_timezone_set('America/Lima');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SistemaLuna</title>
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../css/estilo.css">
</head>
<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid contenedor-nav">
        <a class="navbar-brand titulo-nav" href="#">Sistema</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor03">
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <a class="nav-link subtitulo-nav" href="../registrar/registrar.php" id="registro-link">Registro</a>
            </li>
            <li class="nav-item">
              <a class="nav-link subtitulo-nav" href="../grafico/graficos.php" id="grafico-link">Graficos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link subtitulo-nav" href="../reporte/reportes.php" id="reporte-link">Reportes</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <div class="contenedor-principal">
