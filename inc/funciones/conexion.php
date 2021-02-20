<?php

    $conn = new mysqli("localhost", "root", "R3m0t0", "uptask");
    //var_dump($conn); con estp validamos la conexion los parametros
    // echo "<pre>";
    //     var_dump($conn);
    // echo "</pre>";

    if($conn->connect_error){
        echo $conn->connect_error;
    }
    // esto es por si no se muestras los caractares
    $conn->set_charset('utf8');