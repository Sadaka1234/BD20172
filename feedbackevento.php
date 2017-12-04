
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
           	$out = '<form action="feedbackeventoDB.php" method="POST">
               Seleccione el evento que quiere evaluar:<br>
               <select name="id_evento">';
               $evento = pg_query($conn,'select * from evento');
               while ($row = pg_fetch_row($evento)) {
               $out .= '<option value="'.$row[0].'">'.$row[3].'</option>';}
               $out .= '</select><br>';
               $out .= 'Ingrese votacion: (1: Positivo, 0: Negativo) <br>
               <select name="voto_evento">
               <option value="TRUE">1</option>
               <option value="FALSE">0</option>
               </select><br>
               Ingrese comentario para el evento:<br>
               <input type="text" name ="comentario_evento"><br>';
               $out .= '<input type="submit" value="Votar"> </form>';

               echo $out;
           ?>



	<?php
	echo $_POST["id_evento"];
	echo $_POST["voto_evento"];
  echo $_POST["comentario_evento"];
	?>
        </div>
      </body>
</html>


<?php ob_end_flush(); ?>
