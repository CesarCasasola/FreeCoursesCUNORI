<!DOCTYPE html>
<html>
<head>
    <title></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>


		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Optional theme -->
		<link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">



</head>
<body>


  <?php
    $date = new DateTime('2017-05-01');
    $newdate = $date->format('d/m/Y');
    $date2 = new DateTime('02-06-2017');
    $newdate2 = $date2->format('Y/m/d');
    echo $newdate.'<br>';
    echo $newdate2;
   ?>


  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.dataTables.min.js"></script>
  <script src="js/dataTables.bootstrap.min.js"></script>
  <script src="js/jquery-ui.min.js"></script>

</body>
</html>
