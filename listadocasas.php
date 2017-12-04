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
            <li><a href="loged.php">Volver</a></li>
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

    $rowcasa = pg_query($conn,"Select nombre_casa, dinero_casa, cantidad, personaje.nombre_personaje  from casa, personaje, (Select casa.id_casa, count(id_personaje) as cantidad from personaje, casa where casa.id_casa = personaje.id_casa group by casa.id_casa) tabla1 where casa.id_casa = tabla1.id_casa and personaje.id_casa = casa.id_casa and personaje.fecha_ini IS NOT NULL ORDER BY dinero_casa DESC, cantidad DESC");

    if( pg_num_rows($rowcasa) > 0)
    {
       echo "<table>
             <tr>
               <td>Nombre Casa</td>
               <td>Dinero </td>
               <td>Cantidad Integrantes</td>
               <td>Lider </td>
             </tr>";

       while($rows =  pg_fetch_array($rowcasa)){

        echo "<tr><td>".$rows[0]."</td>";
        echo "<td>".$rows[1]."</td>";
        echo "<td>".$rows[2]."</td>";
        echo "<td>".$rows[3]."</td>";

       }
    }
       else{
       echo "<p>No se encontraron casas</p>";
       }

        ?>


        </div>
      </body>
</html>


<?php ob_end_flush(); ?>
