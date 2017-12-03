
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

             $out =   '<form action="agregarpersonajesDB.php" method="POST">
                      Ingrese Nombre de personaje:<br>
                      <input type="text" name="nombre_personaje"><br>
                      Ingrese Raza de personaje:<br>
                      <select name="raza_personaje">';
                      $raza = pg_query($conn,'select * from raza');
                      while ($row = pg_fetch_row($raza)) {
                      $out .= '<option value="'.$row[0].'">'.$row[1].'</option>';}
                      $out .= '</select><br>';
                      $out .='Ingrese el capital del personaje:<br>
                      <input type="number" name ="dinero_personaje"><br>
                      Casa asociada (opcional):<br>
                      <select name="casa_personaje">';
                      $out .= '<option value="NULL">Ninguna Casa</option>';
                      $casa = pg_query($conn,'select * from casa');
                      while ($row = pg_fetch_row($casa)) {
                      $out .= '<option value="'.$row[0].'">'.$row[1].'</option>';}
                      $out .= '</select><br>';
                      $out .= 'Profesion:<br>
                      <select name="profesion_personaje">';
                      $profesion = pg_query($conn,'select * from profesion');
                      while ($row = pg_fetch_row($profesion)) {
                      $out .= '<option value="'.$row[0].'">'.$row[1].'</option>';}
                      $out .= '</select><br>';
                      $out .= '<input type="submit" value="Agregar"> </form>';

                      echo $out;
              ?>

	<?php
	echo $_POST["nombre_personaje"];
	echo $_POST["casa_personaje"];
	echo $_POST["raza_personaje"];
	echo $_POST["profesion_personaje"];
	echo $_POST["dinero_personaje"];
	?>

<?php ob_end_flush(); ?>
