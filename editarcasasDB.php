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
            <li><a href="editarcasas.php">Volver atrás</a></li>
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
$id_casa = $_SESSION["id_casa"];
 if($_SESSION["accion"] == 0){      #Cambiar lider
   $ini = $_POST["ini"];
   $fin = $_POST["fin"];

        if ($ini < $fin){

            $viejolider = "Select * from personaje where id_casa = ".$id_casa."and fecha_ini IS NOT NULL";
            $viejolider = pg_query($conn, $viejolider);
            $viejolider = pg_fetch_array($viejolider);
            $nuevolider = $_POST["nuevo_lider"];
            $nuevolider = "select * from personaje where id_personaje = ".$nuevolider;
            $nuevolider = pg_query($conn, $nuevolider);
            $nuevolider = pg_fetch_array($nuevolider);
            $deslider = "update personaje set fecha_ini = NULL, fecha_fin = NULL where id_personaje = ".$viejolider[0];
            $deslider = pg_query($conn, $deslider);
            if (!$deslider){
              echo "No se anulo, sorry";
            }
            $nuevolider = "update personaje set fecha_ini = '".$ini."', fecha_fin = '".$fin."' where id_personaje = ".$nuevolider[0];
            $nuevolider = pg_query($conn,$nuevolider);
            if (!$nuevolider){
              echo "no se creo nuevo lider, sorry";
            }
            else {
              echo "Cambio hecho con exito";
            }
          }
      else {
        echo "Revisa las fechas";
      }
  }
 else if($_SESSION["accion"] == 1){
    $newnombre = $_POST["nombre"];
    $sql = "update casa set nombre_casa = '".$newnombre."' where id_casa = ".$id_casa;
    $sql = pg_query($conn, $sql);
    if (!$sql){
      echo "Error asignando el nombre";
    }
    else{
      echo "Nombre Cambiado con exito!";
    }
 }
 else if($_SESSION["accion"] == 2){
   $newnombre = $_POST["nombre"];
   $sql = "update casa set dinero_casa = ".$newnombre." where id_casa = ".$id_casa;
   $sql = pg_query($conn, $sql);
   if (!$sql){
     echo "Error asignando el dinero";
   }
   else{
     echo "Dinero Cambiado con exito!";
   }
 }
 else{
   echo "Khe?";
}



 ?>
