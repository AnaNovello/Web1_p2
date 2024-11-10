<?php
    include 'conexao.php';

    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];

    $stmt = $conn->prepare("UPDATE receita SET nome = ?, descricao = ? WHERE id = ?");
    $stmt->execute([$nome, $descricao, $id]);

    echo json_encode(["success" => "Receita atualizada com sucesso!"]);
?>
