<?php
include 'conexao.php';

try {
    $stmt = $conn->prepare("SELECT * FROM competencia WHERE id_cozinheiro IS NULL");
    $stmt->execute();
    $competencias = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($competencias);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
