<?php

require_once "./clases/AccesoDatos.php";


class Pizza
{

    // public $email;
    public $sabor;
    public $tipo;
    public $cantidad;
    // public $fecha;
    // public $numero_pedido;
    public $imagen;



    // public function __construct(string $sabor, float $precio, string $tipo, int $cantidad, int $idPizza)
    // {
    //     if ($idPizza == 0) {
    //         $this->idPizza = rand(1, 100);
    //     } else {
    //         $this->idPizza = $idPizza;
    //     }
    //     $this->sabor = $sabor;
    //     $this->precio = $precio;
    //     $this->tipo = $tipo;
    //     $this->cantidad = $cantidad;
    // }

    // public static function crearPizza(string $email, string $sabor, string $tipo, int $cantidad, string $fecha, int $numero_pedido)
    // {
    //     $pizza = new Pizza();
    //     $pizza->email = $email;
    //     $pizza->sabor = $sabor;
    //     $pizza->tipo = $tipo;
    //     $pizza->cantidad = $cantidad;
    //     $pizza->fecha = $fecha;
    //     $pizza->numero_pedido = $numero_pedido;
    //     return $pizza;
    // }


    public static function crearPizzaModificar(string $email, string $sabor, string $tipo, int $cantidad, int $numero_pedido)
    {
        $pizza = new Pizza();
        $pizza->email = $email;
        $pizza->sabor = $sabor;
        $pizza->tipo = $tipo;
        $pizza->cantidad = $cantidad;
        $pizza->numero_pedido = $numero_pedido;
        // $pizza->id_pedido = $id_pedido;

        return $pizza;
    }

    public static function crearPizzaAlta(string $email, string $sabor, string $tipo, int $cantidad, string $imagen = NULL)
    {
        $pizza = new Pizza();
        $pizza->email = $email;
        $pizza->sabor = $sabor;
        $pizza->tipo = $tipo;
        $pizza->cantidad = $cantidad;
        $pizza->numero_pedido = rand(1, 899);
        $pizza->fecha = date("Y-m-d");
        // $pizza->id_pedido = $id_pedido;
        $pizza->imagen = $imagen;

        return $pizza;
    }


    public function __construct()
    {
    }



    public static function guardarJSON($objeto)
    {
        $json_string = json_encode($objeto);
        $file = './archivos/Pizza.json';
        file_put_contents($file, $json_string);
    }

    // public static function idAuto($pizzaArr){
    //     $idIncremental = 0;
    //     foreach ($pizzaArr as $pizza) {
    //         $idIncremental = $pizza['idPizza'];
    //     }

    //     return $idIncremental;
    // }

    public static function verificarJSON($pizza)
    {
        $retorno = false;
        $arrAux = array();
        $datos_productos = file_get_contents('./archivos/Pizza.json');
        $arrayPizza = json_decode($datos_productos, true);
        foreach ($arrayPizza as $pizzaArr) {
            if (strcmp($pizzaArr['sabor'], $pizza->sabor) == 0 && strcmp($pizzaArr['tipo'], $pizza->tipo) == 0) {
                echo 'ya existe , se agrega stock y se modifica precio';
                $pizzaArr['cantidad'] += $pizza->cantidad;
                $pizzaArr['precio'] = $pizza->precio;
                array_push($arrAux, $pizzaArr);
                $retorno = true;
            } else {
                array_push($arrAux, $pizzaArr);
            }
        }

        $json_string = json_encode($arrAux);
        $file = './archivos/Pizza.json';
        file_put_contents($file, $json_string);

        return $retorno;
    }

    public static function VerificoPizza($pizza)
    {
        $cadena = '';
        $retorno = false;
        $datos_productos = file_get_contents('./archivos/Pizza.json');
        $arrayPizza = json_decode($datos_productos, true);
        foreach ($arrayPizza as $pizzaArr) {
            if (strcmp($pizzaArr['sabor'], $pizza->sabor) == 0 && strcmp($pizzaArr['tipo'], $pizza->tipo) == 0) {
                $cadena = '';
                $cadena .= 'existe el sabor y el tipo';
                $retorno = true;
            }
            if (strcmp($pizzaArr['tipo'], $pizza->tipo) == 0 && strcmp($pizzaArr['sabor'], $pizza->sabor) != 0) {
                $cadena = '';
                $cadena .= 'no existe el sabor pero existe el tipo';
                $retorno = false;
            }
            if (strcmp($pizzaArr['tipo'], $pizza->tipo) != 0 && strcmp($pizzaArr['sabor'], $pizza->sabor) == 0) {
                $cadena = '';
                $cadena .= ' existe el sabor pero no existe el tipo';
                $retorno = false;
            }
            if (strcmp($pizzaArr['tipo'], $pizza->tipo) != 0 && strcmp($pizzaArr['sabor'], $pizza->sabor) != 0) {
                $cadena = '';
                $cadena .= 'no existe el sabor y no existe el tipo';
                $retorno = false;
            }
        }

        echo $cadena;
        return $retorno;
    }

    public static function EliminarStockArr($producto)
    {
        $retorno = false;
        $arrAux = array();
        $datos_productos = file_get_contents('./archivos/Pizza.json');
        $arrayProductos = json_decode($datos_productos, true);
        foreach ($arrayProductos as $prod) {
            if (strcmp($prod['sabor'], $producto['sabor']) == 0 && strcmp($prod['tipo'], $producto['tipo']) == 0) {
                // echo 'se quita stock';
                $prod['cantidad'] = $producto['cantidad'];
                array_push($arrAux, $prod);
                $retorno = true;
            } else {
                array_push($arrAux, $prod);
            }
        }

        $json_string = json_encode($arrAux);
        $file = './archivos/Pizza.json';
        file_put_contents($file, $json_string);

        return $retorno;
    }

    public static function ObtenerProductosJson()
    {
        $datos_productos = file_get_contents('./archivos/Pizza.json');
        $arrayProductos = json_decode($datos_productos, true);
        return $arrayProductos;
    }

    public static function traerPizza()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM pizza");
        if ($consulta->execute()) {
            return $consulta->fetchAll(PDO::FETCH_CLASS, "Pizza");
        } else {
            echo 'err';
        }
    }

    public function VentaPizza()
    {
        $arrProductos = Pizza::ObtenerProductosJson();
        $retorno = false;
        $flag = 0;
        $cadena = '';
        foreach ($arrProductos as $productos) {
            // MODIFICA SOLAMENTE STOCK
            if ($productos['sabor'] == $this->sabor && $productos['tipo'] == $this->tipo) {
                $flag = 1;
                if (($productos['cantidad'] -= $this->cantidad) > 0) {
                    $cadena .= 'se descuenta stock';
                    self::EliminarStockArr($productos);
                    $retorno = true;
                    $this->InsertarProducto();
                } else {
                    echo 'no hay stock';
                }
            }
        }

        if ($flag == 0) {
            echo 'no existe el tipo de pizza que pide';
        }

        echo $cadena;
        return $retorno;
    }

    public function ModificarPizza()
    {
        $arrProductos = Pizza::TraerTodosLosProductos();
        $cadena = '';
        foreach ($arrProductos as $productos) {
            // MODIFICA SOLAMENTE STOCK
            if ($productos->numero_pedido == $this->numero_pedido) {
                $this->ModificarCompleto();
                $cadena .= 'modificada la pizza';
                break;
            }
        }
        echo $cadena;
    }

    public function GuardarImagen($imagen)
    {
        $dir_subida = 'ImagenesDeLaVenta/';
        if (!file_exists($dir_subida)) {
            mkdir('ImagenesDeLaVenta', 0777, true);
        }

        $nombre = explode('@', $this->email);
        $path = $imagen['name'];
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $nombrePizza = $dir_subida.$this->tipo . '-' . $this->sabor . '-' . $nombre[0] . '-' . "2021-10-19" . '.' . $extension;
       
        if (move_uploaded_file($imagen["tmp_name"], $nombrePizza)) {
            // $this->foto = $destino;
        } else {
            echo "Error";
        }
    }

    public function GuardarImagenCarga($imagen)
    {
        $dir_subida = 'ImagenesDePizzas/';
        if (!file_exists($dir_subida)) {
            mkdir('ImagenesDePizzas', 0777, true);
        }
        $path = $imagen['name'];
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $destino = $dir_subida . $this->tipo . "-" . $this->sabor . "." . $extension;

        if (move_uploaded_file($imagen["tmp_name"], $destino)) {
            // $this->foto = $destino;
        } else {
            echo "Error";
        }
    }

    public function InsertarProducto()
    {           //`id`, `codigo`, `nombre`, `tipo`, `stock`, `precio`, `fecha_de_creacion`, `fecha_de_modificacion`
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO pizza(email,sabor,tipo,cantidad,fecha,numero_pedido,imagen) 
               VALUES (:email,:sabor,:tipo,:cantidad,:fecha,:numero_pedido,:imagen)");
        $consulta->bindValue(':email', $this->email, PDO::PARAM_STR);
        $consulta->bindValue(':sabor', $this->sabor, PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);
        $consulta->bindValue(':fecha', $this->fecha, PDO::PARAM_STR);
        $consulta->bindValue(':numero_pedido', $this->numero_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':imagen', $this->imagen, PDO::PARAM_STR);
        // $consulta->bindValue(':id_pedido', $this->id_pedido, PDO::PARAM_INT);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }


    public function ModificarStock()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("
        update pizza
        set cantidad='$this->cantidad'
        WHERE id_pedido='$this->id_pedido'");
        return $consulta->execute();
    }

    public static function TraerTodosLosProductos()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM pizza");
        if ($consulta->execute()) {
            return $consulta->fetchAll(PDO::FETCH_CLASS, "Pizza");
        } else {
            echo 'err';
        }
    }

    public static function MostrarDatos($arrProductos)
    {

        $cadena = "<ul>";
        // Productos::guardarJSON($arrProductos);
        foreach ($arrProductos as $x) {
            $cadena .= "<li>" .
                "Mail:" . $x->email . " " .
                "Sabor:" . $x->sabor . " " .
                "Tipo:" . $x->tipo . " " .
                "Cantidad:" . $x->cantidad . " " .
                "Fecha:" . $x->fecha . " " .
                "Numero Pedido:" . $x->numero_pedido . " " .
                "ID Pedido:" . $x->id_pedido . "</li>";
        }
        $cadena .= "</ul>";
        echo $cadena;
    }

    public static function TraerCantidadPizzas()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT SUM(cantidad) AS CantidadVendidos FROM pizza");

        if ($consulta->execute()) {
            return $consulta->fetchAll(PDO::FETCH_OBJ);
        } else {
            echo 'err';
        }
    }

    public static function TraerVentasEntreFechas($fechaUno, $fechaDos)
    {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM pizza WHERE fecha BETWEEN :fechaUno AND :fechaDos ORDER BY sabor");
        $consulta->bindValue(':fechaUno', $fechaUno, PDO::PARAM_STR);
        $consulta->bindValue(':fechaDos', $fechaDos, PDO::PARAM_STR);

        if ($consulta->execute()) {
            return $consulta->fetchAll(PDO::FETCH_OBJ);
        } else {
            echo 'err';
        }
    }

    public static function TraerPorSabor($sabor)
    {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM pizza WHERE sabor = :sabor");
        $consulta->bindValue(':sabor', $sabor, PDO::PARAM_STR);

        if ($consulta->execute()) {
            return $consulta->fetchAll(PDO::FETCH_OBJ);
        } else {
            echo 'err';
        }
    }

    public function ModificarCompleto()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("
        update pizza
        set cantidad='$this->cantidad',
        email = '$this->email',
        sabor = '$this->sabor',
        tipo = '$this->tipo'

        WHERE numero_pedido='$this->numero_pedido'");
        return $consulta->execute();
    }

    public static function EliminarPedido($numero)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM pizza WHERE numero_pedido = :numero");

        $consulta->bindValue(':numero', $numero, PDO::PARAM_INT);

        if ($consulta->execute()) {
            echo 'pizza eliminada';
            return TRUE;
        } else {
            echo 'err';
        }
    }

    public static function TraerUnPedido($numero)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM pizza WHERE numero_pedido = :numero");

        $consulta->bindValue(':numero', $numero, PDO::PARAM_INT);

        if ($consulta->execute()) {
            return $consulta->fetchAll(PDO::FETCH_CLASS, "Pizza");
        } else {
            echo 'err';
        }
    }

    public static function borrarImagenVenta($pizza)
    {

        $destino = 'BACKUVENTAS/';
        if (!file_exists($destino)) {
            mkdir('BACKUVENTAS/', 0777, true);
        }

        $final = $destino.$pizza[0]->imagen;
        $origen = 'ImagenesDeLaVenta/'.$pizza[0]->imagen;
        if (copy($origen, $final)) {
 
            echo "Se ha copiado correctamente la imagen";
            unlink('ImagenesDeLaVenta/'.$pizza[0]->imagen);
            }
     
            else {
     
            echo "No se copiado la imagen correctamente";
     
            }

    }
}
