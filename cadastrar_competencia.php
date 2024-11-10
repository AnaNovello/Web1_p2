<?php
include 'conexao.php';

try {
    $conn->beginTransaction();

    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $proficiencia = $_POST['proficiencia'];

    $stmt = $conn->prepare("INSERT INTO competencia (nome, descricao, proficiencia) VALUES (?, ?, ?)");
    $stmt->execute([$nome, $descricao, $proficiencia]);

    $conn->commit();
    echo json_encode(["success" => "Competência cadastrada com sucesso!"]);
} catch (Exception $e) {
    $conn->rollBack();
    echo json_encode(["error" => "Erro ao cadastrar competência: " . $e->getMessage()]);
}
?>
