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

 $res=pg_query($conn, "SELECT * FROM usuario WHERE username = '".$_SESSION['username']."'");
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
          <li><?php echo "Hola ".$userRow['username'].". Que quieres?";  ?></li>
			      <form action="postulacion.php" method="POST">
            <input type="submit" value="Realizar postulación a asignatura">
           </form>

		        <form action="verpostulacion.php" method="POST">
            <input type="submit" value="Ver mis postulaciones">
            </form>

            <form action="verpostaceptadas.php" method="POST">
            <input type="submit" val ue="Ver postulaciones aceptadas de todos los usuarios">
            </form>

            <?php
            if ($userRow['PERMISO']=='t'){
              ?>
              <form action="nuevaspostulaciones.php" method="POST">
              <input type="submit" value="Postulaciones pendientes">
              </form>

              <form action="feedback.php" method="POST">
              <input type="submit" value="Feedback">
              </form>
            <?php
          }
            ?>



        </div>
      </body>
</html>


<?php ob_end_flush(); ?>
