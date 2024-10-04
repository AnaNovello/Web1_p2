<?php
    include('conexao.php');
    include('id_sessao.php');

    if (!isset($_SESSION['id'])){
        header("Location: login.php");
        exit();
    }

    $message = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['confirmar'])) {
            $id_cozinheiro = $_SESSION['id'];
            $sql_delete = "DELETE FROM cozinheiro WHERE id = :id";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bindParam(':id', $id_cozinheiro);
            
            if ($stmt_delete->execute()) {
                session_destroy();
                header("Location: login.php");
                exit();
            } else {
                $message = "Erro ao excluir conta. Tente novamente.";
            }
        } else {
            header("Location: perfil.php");
            exit();
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Conta</title>
    <link rel="stylesheet" href="css\style_exclusao.css"> 
</head>
<body>

<div class="container_delete">
    <h1 class="titulo-delete">Leia com atenção!</h1>
    <p class="mensagem-delete">
        Após a exclusão de sua conta, todos os dados relacionados a ela serão apagados.
    </p>
    <p class="mensagem-delete">
        Você ainda pode utilizar este mesmo endereço de e-mail para se cadastrar novamente, no entanto, será uma nova conta. <strong>Seus dados não poderão ser recuperados!</strong>
    </p>
    <p class="mensagem-delete">
        Deseja prosseguir com a exclusão da conta?
    </p>
    
    <form method="POST" action="">
        <div class="botao-container">
            <button type="submit" name="cancelar" class="btn-nao">Não, voltar para meu perfil</button>
            <button type="submit" name="confirmar" class="btn-sim">Sim, quero deletar minha conta</button>
        </div>
    </form>
</div>
</body>
</html>