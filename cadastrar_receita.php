<?php
include 'conexao.php';

try {
    $conn->beginTransaction();

    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];

    $stmt = $conn->prepare("INSERT INTO receita (nome, descricao) VALUES (?, ?)");
    $stmt->execute([$nome, $descricao]);

    $conn->commit();
    echo json_encode(["success" => "Receita cadastrada com sucesso!"]);
} catch (Exception $e) {
    $conn->rollBack();
    echo json_encode(["error" => "Erro ao cadastrar receita: " . $e->getMessage()]);
}
?>
