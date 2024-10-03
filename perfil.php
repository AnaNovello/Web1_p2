<?php
    include('id_sessao.php');
    include('conexao.php');

    if (isset($_POST['logout'])) {
        session_destroy(); // Destruir todas as variáveis de sessão
        header("Location: index.php"); // Redirecionar para a página de login
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="css/css_perfil.css">
</head>
</head>
<body>
    <?php 
       // Obter o ID do usuário logado
        $id_cozinheiro = $_SESSION['id'];

        // Query para buscar os dados do cozinheiro logado
        $sql_user = "SELECT nome, data_nasc, especializacao, experiencia, receitas, contato, foto, biografia FROM cozinheiro WHERE id = :id";
        $stmt_user = $conn->prepare($sql_user);
        $stmt_user->bindParam(':id', $id_cozinheiro);
        $stmt_user->execute();

        $sql_receitas = "SELECT nome, descricao, foto FROM receita WHERE id_cozinheiro = :id_cozinheiro";
        $stmt_receitas = $conn->prepare($sql_receitas);
        $stmt_receitas->bindParam(':id_cozinheiro', $id_cozinheiro);
        $stmt_receitas->execute();

        // Obter todas as receitas
         $receitas = $stmt_receitas->fetchAll(PDO::FETCH_ASSOC);

        // Obter os dados do cozinheiro
        $cozinheiro = $stmt_user->fetch(PDO::FETCH_ASSOC);

        if ($cozinheiro) {
            // Função para calcular a idade a partir da data de nascimento
            function calcularIdade($data_nasc) {
                $nascimento = new DateTime($data_nasc);
                $hoje = new DateTime();
                $idade = $hoje->diff($nascimento);
                return $idade->y; // Retorna a idade em anos
            }
    
            // Calculando a idade
            $idade = calcularIdade($cozinheiro['data_nasc']);
        } else {
            echo "Erro: Cozinheiro não encontrado.";
            exit();
        }
    ?>

        <p class="welcome-message">Bem-vindo, <?php echo $cozinheiro['nome']; ?>!</p>
        <div class="container">
            <div class="container_perfil">
                <?php if (!empty($cozinheiro['foto'])): ?>
                    <img src="<?php echo htmlspecialchars($cozinheiro['foto']); ?>" alt="Foto de perfil de <?php echo $cozinheiro['nome']; ?>" class="profile-photo">
                <?php else: ?>
                    <div class="profile-photo" style="background-color: #e1e8ed;"></div> <!-- Placeholder se não houver foto -->
                <?php endif; ?>
                

                <h1 class="name"><?php echo $cozinheiro['nome']; ?></h1>
                <p class="info"><span class="bold">Idade:</span> <?php echo $idade; ?> anos</p>

                <p class="info-container">
                    <span class="info"><span class="bold">Área(experiência):</span> <?php echo $cozinheiro['especializacao'];?></span>
                    <span class="info"><span class="bold"></span>(<?php echo $cozinheiro['experiencia'];?> anos)</span>
                </p>

                <p class="info"><span class="bold">Receitas:</span> <?php echo $cozinheiro['receitas']; ?></p>
                <p class="info"><span class="bold">Contato:</span> <?php echo $cozinheiro['contato']; ?></p>
                <div class="perfil_edit">
                    <a href="edit_data.php" class="btn_edit">Editar Perfil</a>
                </div>
            </div>

            <div class="container_bio">
                <h2>Sobre Mim</h2>
                <p><?php echo nl2br(htmlspecialchars($cozinheiro['biografia'])); ?></p>
            </div>
        </div>

        
        <div class="container_receitas">
            <h2>Minhas Receitas</h2>
            <?php if (count($receitas) > 0): ?>
                <ul>
                    <?php foreach ($receitas as $receita): ?>
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

        <!-- Botão de Logout -->
        <form method="POST">
            <button type="submit" name="logout" class="logout-button">Logout</button>
        </form>

</body>
</html>