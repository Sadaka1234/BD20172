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
            <li><a href="loged.php">Volver atrás</a></li>
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
  if ($_POST["nueva_casa_personaje"]) {
    $ini = 'NULL';
    $fin = 'NULL';
  }
 $editarpersonaje = "UPDATE personaje
 SET nombre_personaje = '".$_POST["nuevo_nombre_personaje"]."',
 id_raza = ".$_POST["nueva_raza_personaje"].",
 id_profesion  = ".$_POST["nueva_profesion_personaje"].",
 id_casa  = ".$_POST["nueva_casa_personaje"].",
 dinero_personaje  = ".$_POST["nuevo_dinero_personaje"]."
 WHERE id_personaje = ".$_POST["id_personaje"];


$save = pg_query($conn,$editarpersonaje);
if (!$save) {
	echo "Debes detenegte!!";

}
else {
	echo "Has cambiado tu personaje correctamente!.";
	}
 ?>
