<?php
    include 'conexao.php';

    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM receita WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode(["success" => "Receita excluída com sucesso!"]);
?>
