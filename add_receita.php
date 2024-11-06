<?php
include('conexao.php');
include('id_sessao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto'])) {
    $id_cozinheiro = $_SESSION['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    
    // Definir o diretório de upload para a imagem da receita
    $upload_dir = 'Img/perfil' . $id_cozinheiro . '/receitas/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    $foto = $_FILES['foto'];
    $foto_path = $upload_dir . basename($foto['name']);
    $upload_ok = move_uploaded_file($foto['tmp_name'], $foto_path);

    if ($upload_ok) {
        $sql = "INSERT INTO receita (id_cozinheiro, nome, descricao, foto) VALUES (:id_cozinheiro, :nome, :descricao, :foto)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_cozinheiro', $id_cozinheiro);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':foto', $foto_path);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Receita adicionada com sucesso."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erro ao adicionar receita."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Erro ao fazer upload da imagem."]);
    }
}
?>
