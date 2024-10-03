<?php
    include('conexao.php');

    if (isset($_POST['email']) || isset($_POST['senha'])){
        if (strlen($_POST['email']) == 0 || strlen($_POST['senha']) == 0){
            echo "Os campos E-mail e Senha são obrigatórios!";
        }else{
            // Escapar os dados recebidos para evitar SQL injection (com bindParam em PDO)
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            // Preparar a query para evitar SQL injection
            $sql_code = "SELECT * FROM cozinheiro WHERE email = :email AND senha = :senha";
            $stmt = $conn->prepare($sql_code);

            // Atribuir os valores aos parâmetros (:email e :senha)
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senha);

            // Executar a query
            $stmt->execute();

            // Verificar quantos resultados foram retornados
            $quantidade = $stmt->rowCount();

            if ($quantidade == 1) {
                
                // Fetch para obter os dados do usuário
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                // Iniciar sessão se ainda não foi iniciada
                if (!isset($_SESSION)) {
                    session_start();
                }

                // Definir os dados do usuário na sessão
                $_SESSION['id'] = $usuario['id'];
                $_SESSION['nome'] = $usuario['nome'];

                // Redirecionar para o painel
                header("Location: perfil.php");

            } else {
                echo "Falha ao logar! E-mail ou senha incorretos";
            }
        }

    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css\css_login.css"> 
</head>
<body>
    <div class="login-container">
        <h1 class="titulo">Acesse sua conta</h1>
        <form action="" method="POST">
            <p class="p_email">
                <label class="lbl_login">E-mail</label>
                <input class="input_login" type="text" name="email" required>
            </p>
            <p class="p_senha">
                <label class="lbl_login">Senha</label>
                <input class="input_login" type="password" name="senha" required>
            </p>
            <p>
                <button type="submit" class="login-button">Login</button>
            </p>
            <div class="container_cad">
                <p class="cadastro">
                    <a type="" href="cadastro.php" class="btn_cadastro">Cadastre-se</a>
                </p>

                <p class="redefine_senha">
                    <a href="recuperar_senha.php" class="recuperar-link">Esqueceu sua senha?</a>
                </p>
            </div>
        </form>
    </div>
    
</body>
</html>
