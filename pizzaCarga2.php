<?php

include_once "./clases/pizza.php";

$sabor = $_POST['sabor'];
$precio = $_POST['precio'];
$tipo = $_POST['tipo'];
$cantidad = $_POST['cantidad'];
$opcion = $_POST['opcion'];
$imagen = $_FILES['archivo'];


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
