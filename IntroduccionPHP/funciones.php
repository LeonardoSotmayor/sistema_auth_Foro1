<?php

/*Ejemplo de funcion no recibe parametros*/
 function saludar()
 {
    echo 'buenas tardes'.'<br>';
 }



 /*Funcion con parametros*/
 function saludar2($nombre)
 {
    echo 'buenas tardes ' . $nombre . '<br>';
 }

 function sumar ($num1, $num2)
{
    $c=$num1 + $num2;
    return $c;
}

/*Funcion para saber si un numero es par o impar*/
function parImpar($num)
{
    if ($num % 2 == 0) {
        return "par";
    } else {
        return "impar";
    }
}   
$num = 4;
$num3 = 63;
$num2 = 5;

$esParImpar3 = parImpar($num3);
 echo 'El número ' . $num3 . ' es ' . $esParImpar3.'<br>';

$esParImpar = parImpar($num);
 echo 'El número ' . $num . ' es ' . $esParImpar.'<br>';

$esParImpar2 = parImpar($num2);
 echo 'El número ' . $num2 . ' es ' . $esParImpar2.'<br>';

 saludar();
 saludar2('Leonardo');
 saludar2('Xavier');
 saludar2('Eyleen');
 saludar2('Maria');
 sumar(420, 15);
 $resultado = sumar(420, 15);
    echo 'el resultado de la suma es: ' . $resultado;
    echo '<br>';
    echo $resultado;
?>