
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
	$out = '<form action="editarrazasDB.php" method="POST">
    Seleccione la raza a cambiar:<br>
    <select name="id_raza">';
    $raza = pg_query($conn,'select * from raza');
    while ($row = pg_fetch_row($raza)) {
    $out .= '<option value="'.$row[0].'">'.$row[1].'</option>';}
    $out .= '</select><br>';
    $out .= '
      <h3>Nuevo Nombre de la raza</h3>
          <input type="text" name="nuevo_nombre_raza"><br/>
    	<h3>Nuevas caracteristicas</h3>
    		<input type="text" name="nuevas_caracteristicas"><br/>';
    $out .= '<input type="submit" value="Editar"> </form>';
    echo $out;

?>


	<?php
	echo $_POST["id_raza"];
  echo $_POST["nuevo_nombre_raza"];
	echo $_POST["nuevas_caracteristicas  "];
	?>
        </div>
      </body>
</html>


<?php ob_end_flush(); ?>
