<?php
include 'conexao.php';

try {
    $stmt = $conn->prepare("SELECT * FROM receita WHERE id_cozinheiro IS NULL");
    $stmt->execute();
    $receitas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($receitas);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
