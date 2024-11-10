<?php
    include 'conexao.php';

    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM competencia WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode(["success" => "Competência excluída com sucesso!"]);
?>
