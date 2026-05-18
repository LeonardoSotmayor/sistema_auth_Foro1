<?php
    echo '<h1>hola mundo</h1>'.'<p>desarrollo web</p>';
    echo '<h2>hola mundo</h2>'.'<p>desarrollo web '.'con php</p>';
    echo 'Si esto es interesantes no te voy a mentir debo a aprender a programar en php' . 'y lo que realmente' . '<br>' . ' me gusta es phyton y es lo que
    quiero aprender pero bueno esto es lo que hay';

    $nombre = 'Leonardo';
    $apellido = 'Sotomayor';
    $edad = '23';
    $ciudad = 'Quito';
    echo '<br>';
    
    echo '<h3>hola mi nombres es ' . $nombre . ' ' . $apellido . ' ahora mismo tengo ' . $edad . ' años y paso en ' . $ciudad . '</h3>';
    
    $num1 = 20;
    $num2 = 10;

    if ($num1 > $num2) 
        echo 'numero 1 es mayor que numero 2';
    else 
        echo 'numero 2 es mayor que numero 1';
   
?>