<?php

$servername = "localhost";
$username = "root";
$password = "localhost";
$dbname = "dbtest";

$conn = pg_connect("host = localhost dbname = dbtest user = postgres");
if ($conn -> connect_error){
  die ("Fallo la conexión". $conn->connect_error);
}



if ( isset($_SESSION['user'])!="" ) {
 header("Location: index.php");
 exit;
}

        function listarPersonas( $conexion)
        {
            $sql = "SELECT nombre_evento FROM evento";
            $ok = true;
            // Ejecutar la consulta:
             $rs = pg_query( $conexion, $sql);
            if( $rs )
            {
                // Obtener el número de filas:
                 if( pg_num_rows($rs) > 0 )
                {
                    echo "<p/>LISTADO DE EVENTOS<br/>";
                    echo "===================<p />";
                    // Recorrer el resource y mostrar los datos:
                     while( $obj = pg_fetch_object($rs) )
                         echo $obj->id_evento." - ".$obj->nombre_evento."<br />";
                }
                else
                    echo "<p>No se encontraron eventos</p>";
            }
            else
                $ok = false;
            return $ok;
        }
    ?>


