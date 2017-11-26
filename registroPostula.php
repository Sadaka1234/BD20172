<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Portal Talleres USM</title>
    <link href="diseno.css" rel="stylesheet"/>
      <body>
        <div class ="menu">
          <ul id="menu">
            <li><a href="index.php">Logout</a></li>
            <li><a href="loged.php">Volver</a></li>
          </ul>
        </div>

        <div class="contenido">
          <?php
            $servername = "localhost";
            $username = "root";
            $password = "localhost";
            $dbname = "dbtest";

            $conn = new mysqli($servername,$username,$password,$dbname);

            if ($conn -> connect_error){
                die ("Fallo la conexion". $conn->connect_error);
            }
            ob_start();
            session_start();

            $TALL = $_SESSION['IDTALL'];
            $NOMBRE = $_SESSION['NOMBRETALL'];
            $SEMESTRE = $_SESSION['SEMESTRETALL'] ;
            $rol = $_SESSION['rol'];

            $res=mysqli_query($conn, "SELECT * FROM usuarios WHERE id_usuario =".$_SESSION['rol']);
            $userRow=mysqli_fetch_array($res);
            $nombreU = $userRow['nombre'];

            $sql = "INSERT INTO taller_libre VALUES('$rol', '$TALL', '$SEMESTRE','$TALL',0,0,'Aun no evaluado','$nombreU', '$NOMBRE')";
            $result = $conn->query($sql) or die("Ese taller ya está inscrito, sabandija");
            echo "Agregado con exito";
          ?>
        </div>
      </body>
</html>
<?php ob_end_flush(); ?>
