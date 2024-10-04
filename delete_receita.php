<?php
include('conexao.php');
include('id_sessao.php');

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

$id_cozinheiro = $_SESSION['id'];
$message = '';

$sql_receitas = "SELECT id, nome, descricao, foto FROM receita WHERE id_cozinheiro = :id_cozinheiro";
$stmt_receitas = $conn->prepare($sql_receitas);
$stmt_receitas->bindParam(':id_cozinheiro', $id_cozinheiro);
$stmt_receitas->execute();
$receitas = $stmt_receitas->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['receitas_excluir'])) {
        foreach ($_POST['receitas_excluir'] as $id_receita) {
            $sql = "DELETE FROM receita WHERE id = :id_receita AND id_cozinheiro = :id_cozinheiro";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_receita', $id_receita);
            $stmt->bindParam(':id_cozinheiro', $id_cozinheiro);

            if (!$stmt->execute()) {
                $message = "Erro ao excluir receita(s). Tente novamente.";
            }
        }

        if (empty($message)) {
            header("Location: delete_receita.php");
            $message = "Receita(s) excluída(s) com sucesso.";
        }

    } else {
        $message = "Nenhuma receita selecionada.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Receitas</title>
    <link rel="stylesheet" href="css/style_del_receita.css"> 
</head>
<body>

    <div class="container_receitas">
        <div class="posicao_add_receita">
            <h2>Excluir Receitas</h2>
        </div>

        <form method="post" action="">
            <?php if (count($receitas) > 0): ?>
                <ul>
                    <?php
                        foreach ($receitas as $receita): ?>
                        <div>
                            <div class="receita_item">
                                <h3><?php echo htmlspecialchars($receita['nome']); ?></h3>
                                <div class="receita_content">
                                    <?php if (!empty($receita['foto'])): ?>
                                        <div class="receita_img">
                                            <img src="<?php echo htmlspecialchars($receita['foto']); ?>" alt="Foto da receita <?php echo htmlspecialchars($receita['nome']); ?>" style="max-width: 200px;">
                                        </div>
                                    <?php else: ?>
                                        <p>Imagem não disponível</p>
                                    <?php endif; ?>
                                    
                                    <div class="receita_descricao">
                                        <p><?php echo htmlspecialchars($receita['descricao']); ?></p>
                                    </div>

                                    <div class="checkbox">
                                        <input type="checkbox" name="receitas_excluir[]" value="<?php echo $receita['id']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Você ainda não tem receitas cadastradas.</p>
            <?php endif; ?>

            <div class="posicao_add_receita">
                <div class="btn_receita">
                    <button type="button" class="btn_voltar" onclick="window.location.href='perfil.php'">Voltar</button>
                    <button type="submit" class="btn_excluir_receitas">Excluir Selecionadas</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
