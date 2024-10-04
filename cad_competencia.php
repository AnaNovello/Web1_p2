<?php
include('id_sessao.php');
include('conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cozinheiro = $_SESSION['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $proficiencia = $_POST['proficiencia'];

    $sql_insert = "INSERT INTO competencia (id_cozinheiro, nome, descricao, proficiencia) VALUES (:id_cozinheiro, :nome, :descricao, :proficiencia)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bindParam(':id_cozinheiro', $id_cozinheiro);
    $stmt_insert->bindParam(':nome', $nome);
    $stmt_insert->bindParam(':descricao', $descricao);
    $stmt_insert->bindParam(':proficiencia', $proficiencia);

    if ($stmt_insert->execute()) {
        header("Location: perfil.php");
        exit();
    } else {
        $erro = "Erro ao cadastrar a competência.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Competência</title>
    <link rel="stylesheet" href="css/style_competencia.css">
</head>
<body>
    <div class="container">
        <h1>Cadastrar Competência</h1>
        <?php if (isset($erro)): ?>
            <p class="error"><?php echo htmlspecialchars($erro); ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="5" maxlength="240" required></textarea>
            </div>
            <div class="form-group">
                <label for="proef">Proficiência (1 a 10):</label>
                <input type="number" id="proef" name="proficiencia" min="1" max="10" required>
            </div>
            <button type="submit" class="btn-submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>
