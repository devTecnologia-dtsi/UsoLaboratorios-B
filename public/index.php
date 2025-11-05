<?php

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Puedes devolver una respuesta vacía o un código de estado 405
    header('HTTP/1.1 405 Method Not Allowed');
    exit;
}

require_once __DIR__ . '/../src/routes/web.php';
//require __DIR__ . '../../src/routes/web.php';



// require __DIR__ . '../../public/.htaccess';
// require_once 'ro/Router.php';
 
// $router = new Router();
// $router->handle($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);


// En src/routes/routes.php

//require __DIR__ . '../../connections/connect.php'; GET, VALIDAR SOBRE, BUENA PRACTICA
//EN UNA RUTA QUE SE LLAME CORREO, DOMINIO/CORREO?Y VALOR CORREO
//EL PATCH
//CUAL ES EL METODO A UTILIZAR DEPENDIENDO EL METODO
// http://localhost/usuarios/correo?=lorena.benavides.l@uniminuto.edu.co

// http://localhost/Backend_UsoLaboratorios/public/index.php?path=validarCorreo&correo=lorena.benavides.l@uniminuto.edu.co

// http://localhost/Backend_UsoLaboratorios/public/index.php/validarCorreo?correo=lorena.benavides.l@uniminuto.edu.co
?>