<?php
include('conexao.php');
include('id_sessao.php');

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

$id_cozinheiro = $_SESSION['id'];
$message = '';

$sql_competencias = "SELECT id, nome, descricao, proficiencia FROM competencia WHERE id_cozinheiro = :id_cozinheiro";
$stmt_competencias = $conn->prepare($sql_competencias);
$stmt_competencias->bindParam(':id_cozinheiro', $id_cozinheiro);
$stmt_competencias->execute();
$competencias = $stmt_competencias->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['competencias_excluir'])) {
        foreach ($_POST['competencias_excluir'] as $id_competencia) {
            $sql = "DELETE FROM competencia WHERE id = :id_competencia AND id_cozinheiro = :id_cozinheiro";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_competencia', $id_competencia);
            $stmt->bindParam(':id_cozinheiro', $id_cozinheiro);

            if (!$stmt->execute()) {
                $message = "Erro ao excluir competência(s). Tente novamente.";
            }
        }

        if (empty($message)) {
            header("Location: delete_competencia.php");
            $message = "Competência(s) excluída(s) com sucesso.";
        }

    } else {
        $message = "Nenhuma competência selecionada.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Competências</title>
    <link rel="stylesheet" href="css/style_del_comp.css"> 
</head>
<body>

    <div class="container_competencias">
        <div class="posicao_add_competencia">
            <h2>Excluir Competências</h2>
        </div>

        <form method="post" action="">
            <?php if (count($competencias) > 0): ?>
                <ul>
                    <?php foreach ($competencias as $competencia): ?>
                        <div class="container">
                            <div class="competencia_item">
                                <div class="competencia_content">
                                    <h3 class="competencia_titulo"><?php echo htmlspecialchars($competencia['nome']); ?></h3>
                                    <p class="competencia_descricao"><?php echo htmlspecialchars($competencia['descricao']); ?></p>
                                    <p class="competencia_proficiencia">Proficiência: <?php echo htmlspecialchars($competencia['proficiencia']); ?></p>
                                </div>
                                <div class="checkbox">
                                    <input type="checkbox" name="competencias_excluir[]" value="<?php echo $competencia['id']; ?>">
                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Você ainda não tem competências cadastradas.</p>
            <?php endif; ?>

            <div class="posicao_add_competencia">
                <div class="btn_competencia">
                    <button type="button" class="btn_voltar" onclick="window.location.href='perfil.php'";>Voltar</button>
                    <button type="submit" class="btn_excluir_competencias">Excluir Selecionadas</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
