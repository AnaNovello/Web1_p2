<?php
include('conexao.php');
include('id_sessao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_cozinheiro = $_SESSION['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $proficiencia = $_POST['proficiencia'];

    $sql = "INSERT INTO competencia (id_cozinheiro, nome, descricao, proficiencia) VALUES (:id_cozinheiro, :nome, :descricao, :proficiencia)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_cozinheiro', $id_cozinheiro);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':proficiencia', $proficiencia);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Competência adicionada com sucesso."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Erro ao adicionar competência."]);
    }
}
?>
