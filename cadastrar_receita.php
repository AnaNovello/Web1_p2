<?php
include 'conexao.php';

try {
    // Inicia a transação
    $conn->beginTransaction();

    // Recebe os dados da receita
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];

    // Insere a nova receita
    $stmt = $conn->prepare("INSERT INTO receita (nome, descricao) VALUES (?, ?)");
    $stmt->execute([$nome, $descricao]);

    // Confirma a transação
    $conn->commit();
    echo json_encode(["success" => "Receita cadastrada com sucesso!"]);
} catch (Exception $e) {
    $conn->rollBack();
    echo json_encode(["error" => "Erro ao cadastrar receita: " . $e->getMessage()]);
}
?>
