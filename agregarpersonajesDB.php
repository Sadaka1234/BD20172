<?php
 ob_start();
 session_start();
     $servername = "localhost";
     $username = "postgres";
     $password = "marticito";
     $dbname = "dbtest";

     $conn =  pg_connect("host=localhost dbname=dbtest user=postgres password=marticito");
     if ($conn -> connect_error){
       die ("Fallo la conexión". $conn->connect_error);
     }
 // if session is not set this will redirect to login page
 if( !isset($_SESSION['username']) ) {
  header("Location: index.php");
  exit;
 }
 // select loggedin users detail

$res = pg_query($conn, "SELECT * FROM usuario WHERE username = '".$_SESSION['username']."'");
$userRow = pg_fetch_array($res);


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Baladas de frío y calor</title>
    <link href="diseno.css" rel="stylesheet"/>
      <body>
        <div class ="menu">
          <ul id="menu">
            <li><a href="index.php">Logout</a></li>
          </ul>
        </div>

        <div class="contenido">
          <li>
	    <?php
            $tipousuario = "";

            if ($userRow['PERMISO']=='t'){
                $tipousuario = "el escritor, ser todopoderoso.";
            }
            else{
                $tipousuario = "un seguidor, tu existencia en este  mundo es insignificante.";
            }
           echo "Hola ".$userRow['username'].". En el sistema eres ".$tipousuario." Que quieres?";  ?></li>

 <?php
$guardarpersonaje = "INSERT INTO personaje (id_casa, id_raza, id_profesion, nombre_personaje,dinero_personaje,fecha_ini,fecha_fin) VALUES(".$_POST["casa_personaje"].",".$_POST["raza_personaje"].",".$_POST["profesion_personaje"].",'".$_POST["nombre_personaje"]."',".$_POST["dinero_personaje"].",TO_DATE('".$_POST["f_inicio"]."','MM/DD/YYYY'),TO_DATE('".$_POST["f_termino"]."','MM/DD/YYYY'));";

$save = pg_query($conn,$guardarpersonaje);
if (!$save) {
	echo "Debes detenegte!!";

}
else {
	echo "Has agregado un personaje correctamente!.";
	}
 ?>
