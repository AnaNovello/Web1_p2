<?php
include('id_sessao.php');
include('conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cozinheiro = $_SESSION['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];

    $galeria_dir = 'Img\\perfil'.$id_cozinheiro.'\\receitas\\';
    
    if(!is_dir($galeria_dir)){
        if(mkdir($galeria_dir, 0755, true)){
            echo "Diretório criado com sucesso!";
        }else{
            echo "Falha ao criar diretório.";
        }
    }else{
        echo "o diretório já existe!";
    }

    $foto = $_FILES['foto'];
    $foto_path = $galeria_dir . basename($foto['name']);
    $upload_ok = 1;
    $imageFileType = strtolower(pathinfo($foto_path, PATHINFO_EXTENSION));

    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        $upload_ok = 0;
        $erro = "Apenas arquivos JPG, JPEG, PNG e GIF são permitidos.";
    }

    if ($upload_ok == 1) {
        if (move_uploaded_file($foto['tmp_name'], $foto_path)) {
            $sql_insert = "INSERT INTO receita (id_cozinheiro, nome, descricao, foto) VALUES (:id_cozinheiro, :nome, :descricao, :foto)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bindParam(':id_cozinheiro', $id_cozinheiro);
            $stmt_insert->bindParam(':nome', $nome);
            $stmt_insert->bindParam(':descricao', $descricao);
            $stmt_insert->bindParam(':foto', $foto_path);

            if ($stmt_insert->execute()) {
                header("Location: perfil.php");
                exit();
            } else {
                $erro = "Erro ao cadastrar a receita.";
            }
        } else {
            $erro = "Ocorreu um erro ao fazer o upload do seu arquivo.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Receita</title>
    <link rel="stylesheet" href="css/style_receita.css">
</head>
<body>
    <div class="container">
        <h1>Cadastrar Receita</h1>
        <?php if (isset($erro)): ?>
            <p class="error"><?php echo htmlspecialchars($erro); ?></p>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data" action="">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="5" maxlength="240"></textarea>
            </div>
            <div class="form-group">
                <label for="foto">Foto:</label>
                <input type="file" id="foto" name="foto" accept="image/*" required>
            </div>
            <button type="submit" class="btn-submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>
