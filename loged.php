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
            <input type="submit" value="Buscar Eventos">
           </form>

		        <form action="verpostulacion.php" method="POST">
            <input type="submit" value="Buscar Personajes">
            </form>

            
            <?php
            if ($userRow['PERMISO']=='t'){
              ?>
	      <form action="agregareventos.php" method="POST">
            <input type="submit" value="Agregar Eventos">
            </form>
	 
		<form action="agregarcasas.php" method="POST">
            <input type="submit" value="Agregar Casas">
            </form>

	    <form action="agregarpersonajes.php" method="POST">
            <input type="submit" value="Agregar Personajes">
            </form>
	
	    <form action="agregarrazas.php" method="POST">
            <input type="submit" value="Agregar Razas">
            </form>		
    
            <form action="editareventos.php" method="POST">
            <input type="submit" value="Editar Eventos">
            </form>
	 
		<form action="editarcasas.php" method="POST">
            <input type="submit" value="Editar Casas">
            </form>

	    <form action="editarpersonajes.php" method="POST">
            <input type="submit" value="Editar Personajes">
            </form>
	
	    <form action="editarrazas.php" method="POST">
            <input type="submit" value="Editar Razas">
            </form>
	

	      
            
            <?php
          }
            ?>



        </div>
      </body>
</html>


<?php ob_end_flush(); ?>
