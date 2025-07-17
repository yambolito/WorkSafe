<?php

function dataPrueba(){
    $server = 'localhost';
    $dbname= 'worksafe';
    $username = 'clients';
    $password = 'ph6_lF3jGt/tFRGX'; 
    $dsn = "mysql:host=$server;dbname=$dbname";
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    try {
        $link = new PDO($dsn, $username, $password, $options);
        return $link;
    } catch(PDOException $e) {
        echo "Error de conexi贸n: " . $e->getMessage();
        exit; 
    }
}


?>