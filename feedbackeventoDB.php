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
$guardarfeedback =
"INSERT INTO feedback (id_usuario, comentario) VALUES(".$userRow['id_usuario'].",'".$_POST["comentario_evento"]."');";

$guardar_feedback_evento = "INSERT INTO f_evento
(id_evento, voto_evento,id_feedback)
VALUES(".$_POST["id_evento"].",".$_POST["voto_evento"].",currval('feedback_id_feedback_seq'))";
$save = pg_query($conn,$guardarfeedback);
$save2 = pg_query($conn,$guardar_feedback_evento);
if (!$save) {
	echo "Debes detenegte!! guardar en feedback no funciona";

}
if (!$save2) {
	echo "Debes detenegte!! guardar en feedbackevento no funciona";

}

else {
	echo "Has votado por un evento correctamente!.";
	}
 ?>
