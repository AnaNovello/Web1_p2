<?php
include('conexao.php');
include('id_sessao.php');

$id_cozinheiro = $_SESSION['id'];

$sql = "SELECT id, nome FROM competencia WHERE id_cozinheiro = :id_cozinheiro";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_cozinheiro', $id_cozinheiro);
$stmt->execute();
$competencias = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($competencias);
?>
