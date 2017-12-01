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
            <li><a href="agregarcasas.php">Volver atrás</a></li>
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
$ncasa = $_POST["nombre_casa"];
$id_lider = $_POST["id_lider"];
$ini = $_POST["ini"];
$fin = $_POST["fin"];
$dinero = $_POST["cantidad_plata"];

$sql = "select * from personaje where id_personaje = ".$id_lider." and fecha_ini IS NULL";
$query = pg_query($conn, $sql);
if (!$sql){
  echo "Ese personaje ya es lider de alguna casita, elige otro personaje";

}
else{
   if ($ini > $fin){
     echo "Todo termino antes de empezar... Revisa las fechas";
     }
   else{
     $guardar = "INSERT INTO casa (dinero_casa , nombre ) VALUES (".$dinero.", '".$ncasa."')";
     $sql = pg_query($conn, $guardar);
     if (!$sql){
       echo "error en el insert de casas";
     }
     else{
       echo "Casa Creada";
     }
     $guardar = "UPDATE personaje set fecha_ini = '".$ini."', fecha_fin = '".$fin."', id_casa = currval('casa_id_casa_seq') where id_personaje = ".$id_lider;
     $sql = pg_query($conn, $guardar);
     if (!$sql) {
         echo "ERror en el update";
     }
     else{
        echo "Personaje Hecho Lider";
     }
   }
   }




 ?>
