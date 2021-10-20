<?php

include_once "./clases/pizza.php";

$method = $_SERVER['REQUEST_METHOD'];
if ('DELETE' === $method) {
    parse_str(file_get_contents('php://input'), $_DELETE);

    $numero_pedido = $_DELETE['numero_pedido'];

    $pizza = Pizza::TraerUnPedido($numero_pedido);
    
    if(Pizza::EliminarPedido($numero_pedido)){
        Pizza::borrarImagenVenta($pizza);
    }      
    
}
