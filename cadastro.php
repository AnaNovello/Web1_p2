<?php
    include('conexao.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['nome']) && isset($_POST['cpf']) && isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['confirmar_senha'])){
            $nome = $_POST['nome'];
            $cpf = $_POST['cpf'];
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            $confirmar_senha = $_POST['confirmar_senha'];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Formato de e-mail inválido!";    
            }elseif ($senha !== $confirmar_senha) {
                echo "As senhas não coincidem!";
            } else {
                //$senha_hashed = password_hash($senha, PASSWORD_DEFAULT); --aplicar o hash futuramente quando o sistema estiver melhor consolidado
                $sql_verificar = "SELECT * FROM cozinheiro WHERE email = :email";
                $stmt_verificar = $conn->prepare($sql_verificar);
                $stmt_verificar->bindParam(':email', $email);
                $stmt_verificar->execute();
                if ($stmt_verificar->rowCount() > 0) {
                    echo "Este e-mail já está cadastrado!";
                } else{
                    $sql = "INSERT INTO cozinheiro (nome, cpf, email, senha) 
                            VALUES (:nome, :cpf, :email, :senha)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':nome', $nome);
                    $stmt->bindParam(':cpf', $cpf);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':senha', $senha);

                    if ($stmt->execute()) {
                        echo "Cadastro realizado com sucesso!";
                        header("Location: index.php");
                    } else {
                        echo "Erro ao cadastrar. Tente novamente.";
                    }
                }
            }
        }else{
            echo "todos os campos são obrigatórios!";
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="css\css_cadastro.css"> 
</head>
<body>
    <div class="cad-container">
        <h1 class="titulo">Cadastro</h1>
        <form action="" method="POST">
            <p class="p_nome">
                <label class="lbl_cad">Nome</label>
                <input class="input_cad" type="text" name="nome" required>
            </p>
            <p class="p_cpf">
                <label class="lbl_cad">Cpf</label>
                <input class="input_cad" type="text" name="cpf" required>
            </p>
            <p class="p_email">
                <label class="lbl_cad">E-mail</label>
                <input class="input_cad" type="text" name="email" required>
            </p>
            <p class="p_senha">
                <label class="lbl_cad">Senha</label>
                <input class="input_cad" type="password" name="senha" required>
            </p>
            <p class="p_conf_senha">
                <label class="lbl_cad">Confirme sua senha</label>
                <input class="input_cad" type="password" name="confirmar_senha" required>
            </p>
            <p>
                <button type="submit" class="cad-button">Cadastrar</button>
            </p>
        </form>
    </div>
    
</body>
</html>
