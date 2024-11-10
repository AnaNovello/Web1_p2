<?php
include 'conexao.php';

try {
    // Inicia a transação
    $conn->beginTransaction();

    // Recebe os dados da competência
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $proficiencia = $_POST['proficiencia'];

    // Insere a nova competência
    $stmt = $conn->prepare("INSERT INTO competencia (nome, descricao, proficiencia) VALUES (?, ?, ?)");
    $stmt->execute([$nome, $descricao, $proficiencia]);

    // Confirma a transação
    $conn->commit();
    echo json_encode(["success" => "Competência cadastrada com sucesso!"]);
} catch (Exception $e) {
    $conn->rollBack();
    echo json_encode(["error" => "Erro ao cadastrar competência: " . $e->getMessage()]);
}
?>
