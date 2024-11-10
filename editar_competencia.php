<?php
    include 'conexao.php';

    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $proficiencia = $_POST['proficiencia'];

    $stmt = $conn->prepare("UPDATE competencia SET nome = ?, descricao = ?, proficiencia = ? WHERE id = ?");
    $stmt->execute([$nome, $descricao, $proficiencia, $id]);

    echo json_encode(["success" => "Competência atualizada com sucesso!"]);
?>
