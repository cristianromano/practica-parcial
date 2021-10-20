<?php

include_once "./clases/pizza.php";

$sabor = $_GET['sabor'];
$precio = $_GET['precio'];
$tipo = $_GET['tipo'];
$cantidad = $_GET['cantidad'];
$opcion = $_GET['opcion'];

if (isset($sabor) && isset($precio) &&isset($tipo) && isset($cantidad)) {

    switch ($opcion) {
        case 'cargarPizza':
            $pizzaArr = array();
            $pizzaArr = json_decode(file_get_contents('./archivos/Pizza.json', true));

            $pizza = new Pizza($sabor, $precio, $tipo, $cantidad, 0);
            $pizza->GuardarImagenCarga($imagen);
            array_push($pizzaArr, $pizza);
            Pizza::guardarJSON($pizzaArr);
            break;

        case 'VerificarPizza':
            $pizza = new Pizza($sabor, $precio, $tipo, $cantidad, 0);
            Pizza::verificarJSON($pizza);
            break;

        default:
            # code...
            break;
    }
}
