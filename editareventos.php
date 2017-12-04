
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
	$out = '<form action="editareventosDB.php" method="POST">
    Seleccione el evento a cambiar:<br>
    <select name="id_evento">';
    $evento = pg_query($conn,'select * from evento');
    while ($row = pg_fetch_row($evento)) {
    $out .= '<option value="'.$row[0].'">'.$row[3].'</option>';}
    $out .= '</select><br>';
    $out .= '
      <h3>Nuevo Nombre del Evento</h3>
          <input type="text" name="nuevo_nombre_evento"><br/>
    	<h3>Nueva Fecha</h3>
    	<h4>Formato Fecha: MM/DD/YYYY</h4>
    		<input type="date" name="nueva_fecha"><br/>
    	<h3>Nuevo_Contenido</h3>
    		<input type="text" name="nuevo_contenido"><br/>';
    $out .= '<input type="submit" value="Editar"> </form>';
    echo $out;

?>


	<?php
	echo $_POST["id_evento"];
  echo $_POST["nuevo_nombre_evento"];
  echo $_POST["nueva_fecha"];
	echo $_POST["nuevo_contenido"];
	?>
        </div>
      </body>
</html>


<?php ob_end_flush(); ?>
