<?php

$idCurso = 9;/*TODO: CAPTURAR EL ID DEL CURSO*/


setlocale(LC_TIME, "Spanish");
date_default_timezone_set ('America/Guatemala');

$dbserver = '127.0.0.1';
$dbuser = 'root';
$password = '';
$dbname = 'cursos_libres';

$database = new mysqli($dbserver, $dbuser, $password, $dbname);

if($database->connect_errno) {
  die("No se pudo conectar a la base de datos");
}else{
  //recurperando el numero del programa de cursos Libres
  $programa = 0;
  $query="SELECT IDPROGRAMA, FECHAINICIO, FECHAFIN FROM PROGRAMA WHERE ESTADO=1";
  $queryPrograma= $database->query($query);

  while($regPro  = $queryPrograma->fetch_array( MYSQLI_BOTH)){
    $programa = $regPro['IDPROGRAMA'];
    $fechaInicio = date_create($regPro['FECHAINICIO']);
    $fechaFin = date_create($regPro['FECHAFIN']);
  }


  $head = '<!DOCTPYE><html><head><link rel="stylesheet" href="css/bootstrap.min.css"></head><body style="font-size: large; font-family: Times;">';
  $qDocentes = $database->query("SELECT D.DPI_DOCENTE, D.NOMBRE, D.APELLIDO, D.PROFESION, C.NOMBRE AS NOMBRE_CURSO, C.DIA, C.HORAINICIO, C.HORAFIN FROM IMPARTIDO_POR I INNER JOIN DOCENTE D ON I.DPI_DOCENTE=D.DPI_DOCENTE INNER JOIN CURSO C ON I.IDCURSO=C.IDCURSO WHERE I.IDCURSO=$idCurso");
  while ($regDoc = $qDocentes->fetch_array( MYSQLI_BOTH )) {
    $letter = '<div class="container"><br><p align="right"><b>Chiquimula, '.date('d').' de '.strftime("%B").' de '.date('Y').'.</b></p><br><br><br><br><br>';

    $letter = $letter.'<p align="left"><b>Licda. Deysi Maribi Manchame Gonzalez.<br>
                                          Coordinadora de Cursos Libres.<br>
                                          Centro Universitario de Oriente Cunori.</b><br>
                      </p><br><br><br><br><br><br>';

    $letter = $letter.'<div style="text-indent: 20px;"><p align="justify">Yo, <b>'.$regDoc['NOMBRE'].' '.$regDoc['APELLIDO'].'</b>, identificado con <b>Código Único de Identificación (CUI): '.$regDoc['DPI_DOCENTE'].'</b>,
                    de profesión <b>'.$regDoc['PROFESION'].'</b>, por este medio expreso mi voluntad de participar en el <b>'.$programa.'° PROGRAMA DE CURSOS LIBRES</b> en calidad de docente del curso: <b>'.$regDoc['NOMBRE_CURSO'].'</b>.
                    Dicho programa se desarrollará en el Centro Universitario de Oriente del <b>'.strftime("%d de %B de %Y", date_timestamp_get($fechaInicio)).' al '.strftime("%d de %B de %Y", date_timestamp_get($fechaFin)).'</b>.<br><br>

                      </p></div><br><br>';

    $letter = $letter.'<div style="text-indent: 20px;"><p align="justify">Por lo cual, me comprometo a impartir las clases del curso citado anteriormente, los días <b>'.$regDoc['DIA'].'</b> en horario de <b>'.substr($regDoc['HORAINICIO'], 0, 5).'
                        a '.substr($regDoc['HORAFIN'], 0, 5).' horas.</b>
                      </p></div><br><br><br>';

    $letter = $letter.'<div style="text-indent: 20px;"><p align="justify">Sin otro particular, reitero mi responsabilidad como profesional y me despido.</p></div><br><br><br>';

    $letter = $letter.'<p align="center">'.$regDoc['NOMBRE'].' '.$regDoc['APELLIDO'].'.<br>
                        </p><br><br><br>';

    $letter = $head.$letter;
    echo $letter;
  }

}

 ?>
