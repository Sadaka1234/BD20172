
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



$roweventos = pg_query($conn,"SELECT
    evento.id_evento,
    evento.nombre_evento,
    casa.nombre_casa,
    personaje.nombre_personaje
   FROM evento,
    casa,
    evento_casa,
    personaje,
    evento_personaje
  WHERE evento.id_evento = evento_casa.id_evento AND evento_casa.id_casa = casa.id_casa
  AND evento.id_evento = evento_personaje.id_evento AND evento_personaje.id_personaje = personaje.id_personaje ");

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

    if( pg_num_rows($roweventos) > 0)
    {
       echo "<p/>LISTADO DE EVENTOS<br/>";
       echo "===================<p />";
       while($rows =  pg_fetch_array($roweventos)){
       echo "<p/>Nombre del evento: ".$rows[1]. " Casa(s) asociada(s): ".$rows[2]. " Personaje(s) asociado(s): ".$rows[3]. " <br/>";
       #echo $casas;
                 }
    }
       else{
       echo "<p>No se encontraron eventos, dile al autor que trabaje</p>";
       }

        ?>




        </div>
      </body>
</html>


<?php ob_end_flush(); ?>
