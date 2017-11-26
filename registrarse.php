<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Baladas de frío y calor</title>
    <link href="diseno.css" rel="stylesheet"/>
      <body>
        <div class ="menu">
          <ul id="menu">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="login.php">LogIn</a></li>
          </ul>
        </div>

        <div class="contenido">
          <form action="registroPersona.php" method="POST">
            Nombre de Usuario:<br>
            <input type="text" name="username"><br>
            Contraseña:<br>
            <input type="text" name="password"><br>
            <input type="submit" value="Ingresar">
          </form>


            <table>
                <tr>
                    <td>ID Usuario</td>
                    <td>Nombre Usuario</td>
                </tr>
            <?php
                session_start();
                $servername = "localhost";
                $username = "postgres";
                $password = "marticito";
                $dbname = "dbtest";

                $conn = pg_connect("host=localhost dbname=dbtest user=postgres password=marticito");
                if ($conn -> connect_error){
                  die ("Fallo la conexión". $conn->connect_error);
                }
                $result = pg_query($conn, "SELECT * FROM usuario") or die("Falló la consulta" .$conn->error);
                if (pg_num_rows($result) > 0) {
                // output data of each row
                while($rows =  pg_fetch_array($result)){
                    echo "<tr><td>".$rows[0]."</td>";
                    echo "<td>".$rows[1]."</td>";
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
