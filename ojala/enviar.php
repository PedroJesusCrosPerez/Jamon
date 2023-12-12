<?php

use GuzzleHttp\Client;
require_once "vendor/autoload.php";

$client = new Client();
// Datos que deseas enviar
$data = [
    'nombre' => $_POST["nombre"]
];

// Body
$response = $client->request('POST', 'http://correo', 
[
    'form_params' => $data
]);

$body = $response->getBody();

if (!empty($body)) {
    if ($body == "0") {
        $respuesta = "El usuario no ha ganado nada";
    } else {
        $respuesta = "El usuario ha ganado un jamón!!! <hr> Se le ha enviado un correo";
    }
}
// echo "<hr><hr>BODY ==> ".$body."<hr><hr>";

$respuesta = $body."" == 1 ? "El usuario ha ganado un jamón!!!" : "El usuario no ha ganado nada";

require_once "formulario.php";
// echo $respuesta;

?>