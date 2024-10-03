<?php
    $usuario = 'postgres';
    $senha = 'bisteka380s';
    $host_bd = 'pgsql:host=localhost;dbname=p1_v2';

    try{
        $conn = new PDO($host_bd, $usuario, $senha);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $erro){
        echo 'ERROR: '.$erro->getMessage();
    }
?>