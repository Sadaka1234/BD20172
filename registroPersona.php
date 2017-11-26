<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Baladas frío y calor</title>
    <link href="diseno.css" rel="stylesheet"/>
      <body>
        <div class ="menu">
          <ul id="menu">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="login.php">LogIn</a></li>
            <li><a href="registrarse.php">Registrate aqui</a></li>
            <li><a href="clienteR.php">Nuevo Cliente</a></li>
            <li><a href="vendedor.php">Nuevo Vendedor</a></li>
            <li><a href="proyectador.php">Nuevo Proyectador</a></li>
                  </ul>
        </div>

        <div class="contenido">
          <?php
            $servername = "localhost";
            $username = "postgres";
            $password = "marticito";
            $dbname = "dbtest";

            $conn = pg_connect("host=localhost dbname=dbtest user=postgres password=Sadakanamalaika1");
            if ($conn -> connect_error){
                die ("Fallo la conexión". $conn->connect_error);
            }
            $rol = (INT)$_POST['username'];
            $contraseña = $_POST['password'];

            if($username == NULL or $password == NULL or !preg_match("/^[a-zA-Z ]*$/",$username) {
                if($username == NULL or $contraseña == NULL){
                 echo "RELLENA TODOS LOS CAMPOS<br>";
                 }

                if(!preg_match("/^[a-zA-Z ]*$/",$username)) {
                    echo "Solo Letras y espacios para el nombre<br>";
                }
                echo "Sadaka".$nombre."estuvo".$rol."aqui".$contraseña."oki";
                }
               ?>
                <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
		            Nombre de usuario:<br>
		            <input type="text" name="username"><br>
		            Contraseña:<br>
                <input type="password" name ="password"><br>
                <input type="submit" value="Registrar">
                </form>
        <?php
}
            else{
                $sql = "INSERT INTO usuarios VALUES ('$rol','$rol', 0,'$nombre','$contraseña');";
                $result = $conn->query($sql) or die("ERROR PI: Mami que sera lo que quiere el negro.  SQL ERROR: " . $conn->error);
                $conn->close();
                echo "Persona Ingresada Correctamente";
                echo "<ul id='menu'><li><a href='index.php'>Volver</a></li></ul>";
            }
          ?>
        </div>
      </body>
</html>
