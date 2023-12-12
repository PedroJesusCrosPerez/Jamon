<?php

// $host = "datos";
// $database = "usuariosbd";
// $username = "root";
// $password = "root";

// $cnn = null;
// try {
//     $cnn = new PDO("mysql:host=datos;dbname=usuariosbd;", "root", "root");
//     echo "Connected to the database<hr>";
// } catch (PDOException $e) {
//     echo "Error connecting to the database: " . $e->getMessage();
// }

require_once "entities/Usuario.php";

class DB
{
    private static $connection;
    private static $host = "datos";
    private static $dbname = "usuariosbd";
    private static $user = "root";
    private static $password = "root";

    private function __construct()
    {
        // Constructor privado para evitar instancias no deseadas
    }

    public static function getConnection()
    {
        if (!self::$connection) {
            try {
                self::$connection = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$dbname, self::$user, self::$password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error al conectar a la base de datos: " . $e->getMessage());
            }
        }

        return self::$connection;
    }

    public static function closeConnection()
    {
        self::$connection = null;
    }
}


class DBUsuario {

    public static function findAll()
    {
        try {
            $db = DB::getConnection();
    
            $arrUsuario = [];
            $sql = "SELECT * FROM usuarios;";
            $result = $db->query($sql);
    
            // Process
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
            {
                $arrUsuario[] = 
                new Usuario(
                    $row["nombre"], 
                    $row["email"], 
                    $row["jamon"]
                );
            }
    
            return $arrUsuario;
        } catch (PDOException $e) {
            throw new Exception("Error retrieving data from the fruit table " . $e->getMessage(), 500);
        }
    }

}


$usuarios = DBUsuario::findAll();

// TODO esto lo utilizo para depurar
// foreach ($usuarios as $value) {
//     echo "Name: " . $value->getNombre() . ", Email: " . $value->getEmail() . ", Jamon: " . $value->getJamon() . "<hr><br>";
// }

$nombre = $_POST["nombre"];
$usuarioJamon = null;
$existeUsuario = false;
$tieneJamon = false; // 0 es false y 1 es true. Lo hago así para poder guardarlo en la base de datos

foreach ($usuarios as $usuario) 
{
    if ($usuario->getNombre() == $_POST["nombre"]) 
    {
        if ( $usuario->getJamon() == "0" ) 
        {
            $tieneJamon = false;
        } 
        else 
        {
            $tieneJamon = true;
        }
        $usuarioJamon = $usuario;
        $existeUsuario = true;
    } 
    else 
    {
        $existeUsuario = false;
    }
}


// ##########################################################################################
// ##########################################################################################
// PARA EL FUNCIONAMIENTO habría q descomentar este código
// A mi me lo envía perfectamente
$existeUsuario = true;
// $usuarioJamon = new Usuario("pedro", "pedrojcros@gmail.com", "1");
$usuarioJamon = new Usuario("pedro", "jve@ieslasfuentezuelas.com", "1");
$tieneJamon = true;
// ##########################################################################################
// ##########################################################################################


use GuzzleHttp\Client;
if ( $existeUsuario == true && ($tieneJamon == false || $tieneJamon == true) ) {
    require_once "vendor/autoload.php";
    
    $client = new Client();
    // $data = [
    //     'email' => $usuarioJamon->getEmail(),
    //     'jamon' => "true"
    // ];
    
    $response = $client->request('POST', 'http://cestero', 
    // [
    //     'form_params' => $data,
    // ]
    );

    $pdf = $response->getBody();
    
    // ECHO $response->getBody();
    // Guardar el PDF en el directorio local
    file_put_contents('pdfs/mipdf.pdf', $pdf);
    
    // Configurar las cabeceras para la descarga del archivo
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="mipdf.pdf"');
    
    
    // ############################################################
    // ################## ENVIAR CORREO ###########################
    // ############################################################
    require_once "entities/ServicioCorreos.php";
    
    // echo $pdf;
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $correo = new ServicioCorreos($usuarioJamon->getEmail(), "Comentar sobre si tienes jamón o no", "ESTE ES EL CUERPO", $pdf);
        $correo->enviar();
    } else {
        echo "El método por el que se llama a la api no es 'GET'";
    }
} else {
    echo "ERRRO INDEX.PHP DE CORREO:160";
}
// echo $tieneJamon;

?>