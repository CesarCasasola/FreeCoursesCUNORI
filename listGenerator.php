<?php

  $idCurso = 5;

  $dbserver = '127.0.0.1';
  $dbuser = 'root';
  $password = 'dbn0w';
  $dbname = 'cursos_libres';

  $database = new mysqli($dbserver, $dbuser, $password, $dbname);

  if($database->connect_errno) {
    die("No se pudo conectar a la base de datos");
  }else{

    $maestros = $database->query("SELECT D.NOMBRE, D.APELLIDO FROM IMPARTIDO_POR I INNER JOIN DOCENTE D ON I.DPI_DOCENTE = D.DPI_DOCENTE WHERE I.IDCURSO=$idCurso");
    $cursInfo = $database->query("SELECT * FROM CURSO WHERE IDCURSO=$idCurso");
    $estudiantes = $database->query("SELECT E.NOMBRE, E.SEGUNDONOMBRE, E.APELLIDO, E.SEGUNDOAPELLIDO, E.DPI_ESTUDIANTE, E.TELEFONO, E.CORREO, E.FECHANAC, E.SEXO, B.CONFIRMADA FROM CURSO_BOLETA C INNER JOIN ")
  }

 ?>


<p><b>Curso:</b></p>
