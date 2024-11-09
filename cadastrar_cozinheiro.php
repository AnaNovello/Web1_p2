<?php
include 'conexao.php';

try {
    $conn->beginTransaction();

    // Dados do cozinheiro
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

    // Insere o cozinheiro
    $stmt = $conn->prepare("INSERT INTO cozinheiro (nome, cpf, email, senha) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nome, $cpf, $email, $senha]);
    $cozinheiro_id = $conn->lastInsertId();

    // Salva as competências
    $competencias = json_decode($_POST['competencias'], true);
    $stmt_competencia = $conn->prepare("INSERT INTO competencia (nome, descricao, proficiencia, id_cozinheiro) VALUES (?, ?, ?, ?)");
    if (is_array($competencias)) {
        foreach ($competencias as $competencia) {
            $stmt_competencia->execute([$competencia['nome'], $competencia['descricao'], $competencia['proficiencia'], $cozinheiro_id]);
        }
    }

    // Salva as receitas
    $receitas = json_decode($_POST['receitas'], true);
    $stmt_receita = $conn->prepare("INSERT INTO receita (nome, descricao, id_cozinheiro) VALUES (?, ?, ?)");
    if (is_array($receitas)) {
        foreach ($receitas as $receita) {
            $stmt_receita->execute([$receita['nome'], $receita['descricao'], $cozinheiro_id]);
        }
    }

    $conn->commit();
    echo "Cozinheiro e dados associados cadastrados com sucesso!";
} catch (Exception $e) {
    $conn->rollBack();
    echo "Erro ao cadastrar: " . $e->getMessage();
}
?>
