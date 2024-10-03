<?php
    if(!isset($_SESSION)){
        session_start(); // Iniciar a sessão
    }

    if (!isset($_SESSION['id'])) {
        // Se não estiver logado, redirecionar para a página de login
        header("Location: index.php");
        exit();
    }
?>