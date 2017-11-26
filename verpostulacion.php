<?php

    $servername = "localhost";
    $username = "root";
    $password = "localhost";
    $dbname = "dbtest";

    $conn = new mysqli($servername,$username,$password,$dbname);
    if ($conn -> connect_error){
      die ("Fallo la conexión". $conn->connect_error);
    }

    ob_start();
    session_start();

    if ( isset($_SESSION['user'])!="" ) {
     header("Location: index.php");
     exit;
    }

    $res=mysqli_query($conn, "SELECT * FROM usuarios WHERE id_usuario =".$_SESSION['rol']);
    $userRow=mysqli_fetch_array($res);
?>


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
            <table>
                <tr>
                  <li>Taller aceptado: estado = 1; Taller rechazado: estado = 2; Pendiente: estado = 0</li>
                    <td>Nombre</td>
                    <td>Semestre</td>
                    <td>Estado</td>
                    <td>Profesor</td>
                </tr>
            <?php

                $sql = "SELECT id_taller from taller_libre where id_epro = ".$_SESSION['rol'];
                $result = $conn->query($sql) or die("Falló la consulta" .$conn->error);
                if ($result->num_rows > 0) {
                // output data of each row
                while($rows= mysqli_fetch_array($result)){
                    $zql = "SELECT name, semestre, estado, profesor from taller_libre where id_taller = ".$rows[0] ;
                   $cosa = $conn->query($zql) or die("Falló la consulta" .$conn->error);
                    $rez = mysqli_fetch_array($cosa);
                    echo "<tr><td>".$rez[0]."</td>";
                    echo "<td>".$rez[1]."</td>";
                    echo "<td>".$rez[2]."</td>";
                    echo "<td>".$rez[3]."</td>";
                    }
                }

                else {
                  echo "0 results";
                }
                $conn->close();
            ?>
        </table>
        </div>
      </body>
</html>


<?php ob_end_flush(); ?>
