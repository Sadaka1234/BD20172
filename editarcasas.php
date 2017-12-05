
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

if (!isset($_POST['submit'])){
        echo '<form action="editarcasas.php" method="POST">';
        echo "Seleccione Casa a editar:<br>";
        $sql = "Select * from casa";
        $sql = pg_query($conn, $sql);
        echo "<select name='id_casa'><br>";
        while ($row = pg_fetch_array($sql)){
            echo "<option value='".$row[0]."'>".$row[1]."</option>";
        }
        echo "</select><br>";
        echo "Ingresa tu acción<br>";
        echo '<select name="accion"><br>';
        echo '<option value=0>Cambiar Lider </option>';
        echo '<option value=1>Cambiar Nombre</option>';
        echo '<option value=2>Cambiar Dinero</option>';
        echo '</select><br>';
        echo '<input name="submit" type="submit" value="Acción"> </form>';
           }
else{
        $_SESSION["accion"] = $_POST["accion"];
        $_SESSION["id_casa"] = $_POST["id_casa"];
        if($_POST["accion"] == 0){      #Cambiar lider


          $nolideres = "Select * from personaje where id_casa = ".$_POST["id_casa"]."and fecha_ini IS NULL";
          $nolideres = pg_query($conn, $nolideres);
          echo '<form action = "editarcasasDB.php" method="POST">';
          echo "Seleccione nuevo lider:<br>";
          echo '<select name="nuevo_lider"><br>';
          while($lrow = pg_fetch_array($nolideres)){
            echo "<option value='".$lrow[0]."'>".$lrow[4]."</option>";
          }
          echo "</select><br>";
          echo "Fecha Inicio contrato del lider:<br>";
          echo "<input type ='date' name='ini'><br/>";
          echo "Fecha Termino contraro del lider:<br>";
          echo "<input type='date' name='fin'><br/>";
          echo '<input type="submit" value="Cambiar Lider"> </form>';
        }
        else if($_POST["accion"] == 1){
          echo "Nuevo nombre para la casa:<br>";
          echo '<form action = "editarcasasDB.php" method="POST">';
          echo "<input type ='text' name='nombre'><br/>";
          echo '<input type="submit" value="Cambiar Nombre"> </form>';
        }
        else if($_POST["accion"] == 2){
          echo "Nueva cantidad de dinero:<br>";
          echo '<form action = "editarcasasDB.php" method="POST">';
          echo "<input type ='number' name='nombre'><br/>";
          echo '<input type="submit" value="Cambiar Dinero"> </form>';
        }
        else{
          echo "Khe?";
        }
     }

?>


      </div>
    </body>
</html>


<?php ob_end_flush(); ?>
