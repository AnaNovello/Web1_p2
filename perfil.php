<?php
    include('id_sessao.php');
    include('conexao.php');

    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="css/style_perfil.css">
</head>
</head>
<body>
    <?php 
        $id_cozinheiro = $_SESSION['id'];

        $sql_user = "SELECT nome, data_nasc, especializacao, experiencia, receitas, contato, foto, biografia FROM cozinheiro WHERE id = :id";
        $stmt_user = $conn->prepare($sql_user);
        $stmt_user->bindParam(':id', $id_cozinheiro);
        $stmt_user->execute();

        $sql_receitas = "SELECT nome, descricao, foto FROM receita WHERE id_cozinheiro = :id_cozinheiro";
        $stmt_receitas = $conn->prepare($sql_receitas);
        $stmt_receitas->bindParam(':id_cozinheiro', $id_cozinheiro);
        $stmt_receitas->execute();

        $sql_competencias = "SELECT nome, descricao, proficiencia FROM competencia WHERE id_cozinheiro = :id_cozinheiro";
        $stmt_competencias = $conn->prepare($sql_competencias);
        $stmt_competencias->bindParam(':id_cozinheiro', $id_cozinheiro);
        $stmt_competencias->execute();

        $competencias = $stmt_competencias->fetchAll(PDO::FETCH_ASSOC);
        $receitas = $stmt_receitas->fetchAll(PDO::FETCH_ASSOC);
        $cozinheiro = $stmt_user->fetch(PDO::FETCH_ASSOC);

        if ($cozinheiro) {
            function calcularIdade($data_nasc) {
                $nascimento = new DateTime($data_nasc);
                $hoje = new DateTime();
                $idade = $hoje->diff($nascimento);
                return $idade->y;
            }
            $idade = calcularIdade($cozinheiro['data_nasc']);
        } else {
            echo "Erro: Cozinheiro não encontrado.";
            exit();
        }
    ?>

    <p class="mensagem">Bem-vindo(a), <?php echo $cozinheiro['nome']; ?>!</p>
    <div class="container">
        <div class="container_perfil">
            <div class="container_edit">
                <?php if (!empty($cozinheiro['foto'])): ?>
                    <img src="<?php echo htmlspecialchars($cozinheiro['foto']); ?>" alt="Foto de perfil de <?php echo $cozinheiro['nome']; ?>" class="profile-photo">
                <?php else: ?>
                    <div class="profile-photo" style="background-color: #e1e8ed;"></div> <!-- Placeholder para foto -->
                    <?php endif; ?>
                <div class="perfil_edit">
                    <a href="edit_data.php" class="btn_edit">Editar Perfil</a>
                </div>
            </div>
            

            <h1 class="name"><?php echo $cozinheiro['nome']; ?></h1>
            <p class="info"><span class="bold">Idade:</span> <?php echo $idade; ?> anos</p>

            <p class="info-container">
                <span class="info"><span class="bold">Área(experiência):</span> <?php echo $cozinheiro['especializacao'];?></span>
                <span class="info"><span class="bold"></span>(<?php echo $cozinheiro['experiencia'];?> anos)</span>
            </p>
            <p class="info"><span class="bold">Receitas:</span> <?php echo count($receitas); ?></p>
            <p class="info"><span class="bold">Contato:</span> <?php echo $cozinheiro['contato']; ?></p>
        </div>

        <div class="container_bio">
            <h2>Sobre Mim</h2>
            <p><?php echo nl2br(htmlspecialchars($cozinheiro['biografia'])); ?></p>
        </div>
    </div>

    <div class="container_espec">
        <div class="posicao_add_receita">
            <h2>Outras Competências</h2>
            <div class="add_receita">
                <a href="cad_competencia.php" class="btn_add_receita">+</a>
                <a href="delete_competencia.php" class="btn_del_receita">-</a>
            </div>
        </div>

        <?php if (count($competencias) > 0): ?>
            <ul>
                <?php foreach ($competencias as $competencia): ?>
                    <div class="competencia_item">
                        <h3><?php echo htmlspecialchars($competencia['nome']); ?></h3>
                        <div class="competencia_content">
                            <p><strong>Descrição:</strong> <?php echo htmlspecialchars($competencia['descricao']); ?></p>
                            <p><strong>Proficiência(1-10):</strong> <?php echo htmlspecialchars($competencia['proficiencia']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Você ainda não tem outras competências cadastradas.</p>
        <?php endif; ?>
    </div>

    <div class="container_receitas">
        <div class="posicao_add_receita">
            <h2>Minhas Receitas</h2>
            <div class="add_receita">
                <a href="cad_receita.php" class="btn_add_receita">+</a>
                <a href="delete_receita.php" class="btn_del_receita">-</a>
            </div>
        </div>

        <?php if (count($receitas) > 0): ?>
            <ul>
                <?php
                    $count = 0; 
                    foreach ($receitas as $receita):?>
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
                        </div>
                    </div>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Você ainda não tem receitas cadastradas.</p>
        <?php endif; ?>
        
    </div>

    <form method="POST">
        <button type="submit" name="logout" class="logout-button">Logout</button>
    </form>

</body>
</html>