
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

$rowpersonaje = pg_query($conn,"SELECT * FROM personaje");

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
   
    if( pg_num_rows($rowpersonaje) > 0)
    {
       echo "<p/>LISTADO DE PERSONAJES<br/>";
       echo "===================<p />";
	
       while($rows =  pg_fetch_array($rowpersonaje)){
       echo "<p/>".$rows[0]." ".$rows[4]."<br/>";
             
                    }
    }
       else{
       echo "<p>No se encontraron personajes</p>";
       }
           
        ?>
           



        </div>
      </body>
</html>


<?php ob_end_flush(); ?>
