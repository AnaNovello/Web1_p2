<?php
    //preencher as variáveis $usuario, $senha e $host_bd
    $usuario = '';
    $senha = '';
    $host_bd = 'pgsql:host= ;dbname= ';

    try{
        $conn = new PDO($host_bd, $usuario, $senha);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $erro){
        echo 'ERROR: '.$erro->getMessage();
    }
?>