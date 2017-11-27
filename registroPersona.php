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
            <li><a href="registrarse.php">Registrate aqui</a></li>
            </ul>
        </div>

        <div class="contenido">
          <?php
            $servername = "localhost";
            $username = "postgres";
            $password = "marticito";
            $dbname = "dbtest";

            $conn = pg_connect("host=localhost dbname=dbtest user=postgres password=marticito");

            $nombre = $_POST['username'];
            $contraseña = $_POST['password'];

            $result = pg_query("SELECT * FROM usuario WHERE username = '".$nombre."'");
            $count = pg_num_rows($result);


            if($count != 0 or $nombre == NULL or $contraseña == NULL or !preg_match("/^[a-zA-Z ]*$/",$nombre)) {
              if($nombre == NULL or $contraseña == NULL){
               echo "RELLENA TODOS LOS CAMPOS<br>";
               }
              if(!preg_match("/^[a-zA-Z ]*$/",$nombre)) {
                  echo "Solo Letras y espacios para el nombre<br>";
              }
              if ($count != 0){
                  echo "Ese nombre de usuario ya existe<br>";

              }

              }
            else{
                $result = pg_query("insert into usuario (username, password) VALUES ('".$nombre."','".$contraseña."')") or die("ERROR PI: Mami que sera lo que quiere el negro.  SQL ERROR: " . $conn->error);
                echo "Persona Registrada Correctamente";
                echo "<ul id='menu'><li><a href='index.php'>Volver</a></li></ul>";
            }
          ?>
        </div>
      </body>
</html>


<?php
/*<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
  Nombre de usuario:<br>
  <input type="text" name="username"><br>
  Contraseña:<br>
  <input type="password" name ="password"><br>
  <input type="submit" value="Registrar">
  </form>
*/
 ?>
