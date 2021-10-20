<?php


include_once "./clases/pizza.php";

// debe recibir el número de pedido, el email del usuario, el sabor,tipo y cantidad, si existe se modifica , de lo contrario informar.

// $pizza = Pizza::crearPizzaModificar($mail,$sabor,$tipo,$cantidad,$pedido);

// $pizza->ModificarPizza();

$method = $_SERVER['REQUEST_METHOD'];
if ('PUT' === $method) {
    parse_str(file_get_contents('php://input'), $_PUT);
    $pedido = $_PUT['pedido'];
    $mail = $_PUT['email'];
    $sabor = $_PUT['sabor'];
    $tipo = $_PUT['tipo'];
    $cantidad = $_PUT['cantidad'];

    $pizza = Pizza::crearPizzaModificar($mail, $sabor, $tipo, $cantidad, $pedido);
    $pizza->ModificarCompleto();
}
