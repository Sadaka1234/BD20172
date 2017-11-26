
<?php
    $servername = "localhost";
    $username = "postgres";
    $password = "marticito";
    $dbname = "dbtest";

    $conn = pg_connect("host=localhost dbname=dbtest user=postgres password=marticito");
    if ($conn -> connect_error){
      die ("Fallo la conexión". $conn->connect_error);
    }
    ob_start();
    session_start();
    if ( isset($_SESSION['user'])!="" ) {
     header("Location: home.php");
     exit;
    }

    $error = false;

    if( isset($_POST['btn-login']) ) {

     // prevent sql injections/ clear user invalid inputs
     $rol = trim($_POST['rol']);
     $rol = strip_tags($rol);
     $rol = htmlspecialchars($rol);

     $pass = trim($_POST['pass']);
     $pass = strip_tags($pass);
     $pass = htmlspecialchars($pass);
     // prevent sql injections / clear user invalid inputs

     if(empty($rol)){
      $error = true;
      $rolError = "Ingresa un nombre de usuario";
     }
     if(empty($pass)){
      $error = true;
      $passError = "Ingresa una contraseña valida";
     }
if (!$error){
  $res=pg_query($conn,"SELECT username, password FROM usuario WHERE username='$rol' and password ='$pass'");
  $count = pg_num_rows($res);
  if($count != 0) {
   $_SESSION['username'] = $rol;
   header("Location: loged.php");
  } else {
   $errMSG = "Combinacion de datos incorrectos, intentalo de nuevo";
  }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Baladas de frío y calor</title>
<link href="diseno.css" rel="stylesheet"/>
</head>
<body>
  <div class ="menu">
    <ul id="menu">
      <li><a href="index.php">Volver</a></li>
      <li><a href="registrarse.php">Registrate aqui</a></li>
    </ul>
  </div>
<div class="container">
<div id="login-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    </div>
      <?php
   if ( isset($errMSG) ) {
$row
    ?>
    <div class="form-group">
             <div cla$rowss="alert alert-danger">
    <span class="glyphicon glyphico  n-info-sign"></span> <?php echo $errMSG; ?>
                </div>
             </div>
                <?php
   }
   ?>

   <div class="contenido">
    <div class="input-group">
       <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
    <input type="text" name="rol" class="form-control" placeholder="username" value="<?php echo $rol; ?>" maxlength="50" />
       </div>
       <span class="text-danger"><?php echo $rolError; ?></span>
   </div>

            <div class="contenido">
             <div class="contenido">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
             <input type="password" name="pass" class="form-control" placeholder="contraseña" maxlength="50" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>

            <div class="contenido">
             <button type="submit" class="btn btn-block btn-primary" name="btn-login">Ingresar</button>
            </div>


        </div>

    </form>
    </div>

</div>

</body>
</html>
<?php ob_end_flush(); ?>



<?php
/*

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Portal Talleres USM</title>
    <link href="diseno.css" rel="stylesheet"/>
      <body>
        <div class ="menu">
          <ul id="menu">
            <li><a href="index.php">Volver</a></li>
            <li><a href="login.php">LogIn</a></li>
            <li><a href="registrarse.php">Registrate aqui</a></li>
            <li><a href="clienteR.php">Nuevo Cliente</a></li>
            <li><a href="vendedor.php">Nuevo Vendedor</a></li>
            <li><a href="proyectador.php">Nuevo Proyectador</a></li>
          </ul>
        </div>
        <div class="contenido">
        <form action="loged.php" method="POST">
            Rol:<br>
            <input type="text" name="rol"><br>
            Password:<br>
            <input type="text" name="pass"><br>
            <input type="submit" value="Ingresar">
          </form>
        </div>
        </body>
  </html>
  <?php ob_end_flush(); ?>*/
