
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
        echo "Ingresa tu acción";
        echo '<select name="accion"><br>';
        echo '<option value=0>Cambiar Lider </option>';
        echo '<option value=1>Cambiar nombre</option>';
        echo '</select><br>';
        echo '<input name="submit" type="submit" value="Acción"> </form>';
         #echo $casas;
           }
         else{
         echo "<p>No se encontraron eventos, dile al autor que trabaje</p>";
         }
      }
else {
      $info = "SELECT * FROM evento WHERE id_evento = '".$_POST["id_evento"]."' ";
      $datos_evento = pg_query($conn,$info);
      ?>
      <table>
          <tr>
        <td>ID</td>
        <td>Nombre Evento</td>
        <td>Fecha</td>
        <td>Contenido</td>
        </tr>
      <?php
      while($row = pg_fetch_array($datos_evento)){
        echo "<tr><td>".$row['id_evento']."</td>";
        echo "<td>".$row['nombre_evento']."</td>";
        echo "<td>".$row['fecha']."</td>";
        echo "<td>".$row['contenido']."</td>";
      }
       ?>
      </table>
      <?php
      $id_casa = "SELECT id_casa FROM evento_casa WHERE id_evento = '".$_POST["id_evento"]."'";
      $id_c = pg_query($conn,$id_casa);
      ?>
      <table>
        <tr>
      <td>Nombres de Casas Participantes</td>
      </tr>

      <?php
      if(pg_num_rows($id_c)!=0){
        while($row = pg_fetch_array($id_c)){
          $casa = "SELECT nombre_casa FROM casa WHERE id_casa = '".$row['id_casa']."'";
          $nombre_casa = pg_query($conn,$casa);
          $nombre_c = pg_fetch_array($nombre_casa);
          echo "<tr><td>".$nombre_c['nombre_casa']."</td>";
        }
      }
      ?>
      </table>
      <?php
      $id_personaje = "SELECT id_personaje FROM evento_personaje WHERE id_evento = '".$_POST["id_evento"]."'";
      $id_p = pg_query($con,$id_personaje);
      ?>
      <table>
      <tr>
      <td>Nombres de Personajes Participantes</td>
      </tr>

      <?php
      if(pg_num_rows($id_p)!=0){
      while($row = pg_fetch_array($id_p)){
        $personaje = "SELECT nombre_personaje FROM personaje WHERE id_personaje = '".$row['id_personaje']."'";
        $nombre_personaje = pg_query($con,$personaje);
        $nombre_p = pg_fetch_array($nombre_personaje);
        echo "<tr><td>".$nombre_p['nombre_personaje']."</td>";
      }
  }

}
































	$out = '<form action="editarcasasDB.php" method="POST">
    Seleccione la casa a cambiar:<br>
    <select name="id_casa">';
    $casa = pg_query($conn,'select * from casa');
    while ($row = pg_fetch_row($casa)) {
    $out .= '<option value="'.$row[0].'">'.$row[1].'</option>';}
    $out .= '</select><br>';
    $out .= 'Nuevo Nombre de la Casa<br>
    <input type="text" name="nuevo_nombre_casa"><br/>
    Ingrese el nuevo capital de la casa:<br>
    <input type="number" name ="nuevo_dinero_casa"><br>
    Escoga el nuevo Lider de la casa:<br>
    <select name="nuevo_lider_casa">';
    $lider = pg_query($conn,'select * from personaje where id_casa IS NULL');
    while ($row = pg_fetch_row($lider)) {
    $out .= '<option value="'.$row[0].'">'.$row[4].'</option>';}
    $out .= '</select><br>';
    $out .= '<h3>Fecha Inicio contrato del lider:</h3>
    <input type ="date" name="f_ini"><br/>
    <h3>Fecha Termino contrato del lider:</h3>
    <input type="date" name="f_fin"><br/>';
    $out .= '<input type="submit" value="Editar"> </form>';
    echo $out;
?>


      </div>
    </body>
</html>


<?php ob_end_flush(); ?>
