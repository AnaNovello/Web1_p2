<?php
include 'conexao.php';

try {
    $conn->beginTransaction();

    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO cozinheiro (nome, cpf, email, senha) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nome, $cpf, $email, $senha]);
    $cozinheiro_id = $conn->lastInsertId();

    // Atualiza as entidades não associadas para incluir o ID do cozinheiro
    $stmt_update_competencia = $conn->prepare("UPDATE competencia SET id_cozinheiro = ? WHERE id_cozinheiro IS NULL");
    $stmt_update_competencia->execute([$cozinheiro_id]);
    $stmt_update_receita = $conn->prepare("UPDATE receita SET id_cozinheiro = ? WHERE id_cozinheiro IS NULL");
    $stmt_update_receita->execute([$cozinheiro_id]);

    $conn->commit();
    echo json_encode(["success" => "Cozinheiro e dados associados cadastrados com sucesso!"]);
} catch (Exception $e) {
    $conn->rollBack();
    echo json_encode(["error" => "Erro ao cadastrar: " . $e->getMessage()]);
}
?>
