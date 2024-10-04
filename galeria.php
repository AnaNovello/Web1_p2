
<?php
//esse arquivo foi criado para conseguir criar um diretório para os usuários 
//que foram inseridos diretamente no banco de dados. Não vai ser usado no projeto final.
    include('conexao.php');
    include('id_sessao.php');

    $galeria_dir = 'Img\\perfil'.$_SESSION['id'].'\\';
    if(!is_dir($galeria_dir)){
        if(mkdir($galeria_dir, 0755, true)){
            echo "Diretório criado com sucesso!";
        }else{
            echo "Falha ao criar diretório.";
        }
    }else{
        echo "o diretório já existe!";
    }
    //header("Location: index.php");
?>