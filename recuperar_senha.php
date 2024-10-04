<?php
    include('conexao.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['cpf']) && isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['confirmar_senha'])){
            $cpf = $_POST['cpf'];
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            $confirmar_senha = $_POST['confirmar_senha'];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Formato de e-mail inválido!";    
            }elseif ($senha !== $confirmar_senha) {
                echo "As senhas não coincidem!";
            } else {
                //$senha_hashed = password_hash($senha, PASSWORD_DEFAULT); //hash não aplicado
                $sql_verificar_email = "SELECT * FROM cozinheiro WHERE email = :email";
                $sql_verificar_email = $conn->prepare($sql_verificar_email);
                $sql_verificar_email->bindParam(':email', $email);
                $sql_verificar_email->execute();
                
                if ($sql_verificar_email->rowCount() == 0) {
                    echo "Não existe conta registrada neste e-mail!";
                }else{
                    $sql_verificar_cpf = "SELECT * FROM cozinheiro WHERE email = :email AND cpf = :cpf";
                    $stmt_verificar_cpf = $conn->prepare($sql_verificar_cpf);
                    $stmt_verificar_cpf->bindParam(':email', $email);
                    $stmt_verificar_cpf->bindParam(':cpf', $cpf);
                    $stmt_verificar_cpf->execute();

                    if ($stmt_verificar_cpf->rowCount() == 0) {
                        echo "O CPF não corresponde ao e-mail informado!";
                    }else{
                        $sql = "UPDATE cozinheiro SET senha = :senha WHERE email = :email AND cpf = :cpf";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':cpf', $cpf);
                        $stmt->bindParam(':email', $email);
                        $stmt->bindParam(':senha', $senha);

                        if ($stmt->execute()) {
                            echo "Senha redefinida com sucesso!";
                            header("Location: index.php");
                        } else {
                            echo "Erro ao redefinir a senha. Tente novamente.";
                        }
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
    <title>Recuperar Senha</title>
    <link rel="stylesheet" href="css\style_recupera_senha.css"> 
</head>
<body>
    <div class="cad-container">
        <h1 class="titulo">Redefina sua senha</h1>
        <form action="" method="POST">
            <p class="p_cpf">
                <label class="lbl_cad">CPF</label>
                <input class="input_cad" type="text" name="cpf" required>
            </p>
            <p class="p_email">
                <label class="lbl_cad">E-mail</label>
                <input class="input_cad" type="text" name="email" required>
            </p>
            <p class="p_senha">
                <label class="lbl_cad">Nova senha</label>
                <input class="input_cad" type="password" name="senha" required>
            </p>
            <p class="p_conf_senha">
                <label class="lbl_cad">Confirme sua senha</label>
                <input class="input_cad" type="password" name="confirmar_senha" required>
            </p>
            <p>
                <button type="submit" class="btn_redefinir">Redefinir</button>
            </p>
        </form>
    </div>
    
</body>
</html>
