<?php
include('conexao.php');
include('id_sessao.php');

$nome = $email = $data_nascimento = $especializacao = $experiencia = $contato = $biografia = '';

$sql_especializacao = "SELECT DISTINCT nome FROM especializacao ORDER BY nome ASC";
$stmt_especializacao = $conn->prepare($sql_especializacao);
$stmt_especializacao->execute();
$especializacoes = $stmt_especializacao->fetchAll(PDO::FETCH_ASSOC);

if (isset($_SESSION['id'])) {
    $id_cozinheiro = $_SESSION['id'];

    $sql = "SELECT * FROM cozinheiro WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id_cozinheiro);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        //var_dump($dados);
        $nome = $dados['nome'] ?? '';
        $email = $dados['email'] ?? '';
        $data_nascimento = $dados['data_nasc'] ?? '';
        $especializacao = $dados['especializacao'] ?? '';
        //var_dump($especializacao);
        $experiencia = $dados['experiencia'] ?? '';
        $contato = $dados['contato'] ?? '';
        $foto_atual = $dados['foto'] ?? '';
        $biografia = $dados['biografia'] ?? ''; 
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $data_nascimento = !empty($_POST['data_nasc']) ? $_POST['data_nasc'] : null;
    $especializacao = $_POST['especializacao'] ?? '';
    $experiencia = $_POST['experiencia'] ?? '0';
    $contato = $_POST['contato'] ?? '';
    $foto = $foto_atual;
    $biografia = $_POST['biografia'] ?? '';

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'Img\\perfil'.$_SESSION['id'].'\\';
        $foto = basename($_FILES['foto']['name']);
        $foto_path = $upload_dir.$foto;

        $f_type = pathinfo($foto_path, PATHINFO_EXTENSION);
        $permitido = ['jpg', 'jpeg', 'png', 'gif'];

        if(in_array(strtolower($f_type), $permitido)){
            if(move_uploaded_file($_FILES['foto']['tmp_name'], $foto_path)){
                $foto = $foto_path;
            }else{
                echo "Erro ao mover foto para o diretório.";
            }
        }else{
            echo "Formato de arquivo não permitido!";
        }
    }

    $sql_update = "UPDATE cozinheiro SET nome = :nome, email = :email, data_nasc = :data_nascimento, especializacao = :especializacao, experiencia = :experiencia, contato = :contato, foto = :foto, biografia = :biografia WHERE id = :id";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bindParam(':nome', $nome);
    $stmt_update->bindParam(':email', $email);

    //sem esse tratamento, o sistema gera uma falha de type
    if ($data_nascimento) {
        $stmt_update->bindValue(':data_nascimento', $data_nascimento);
    } else {
        $stmt_update->bindValue(':data_nascimento', null, PDO::PARAM_NULL);
    }

    $stmt_update->bindParam(':especializacao', $especializacao);

    //mesma falha aqui
    if ($experiencia) {
        $stmt_update->bindValue(':experiencia', $experiencia);
    } else {
        $stmt_update->bindValue(':experiencia', 0);
    }
    
    $stmt_update->bindParam(':contato', $contato);
    $stmt_update->bindParam(':id', $id_cozinheiro);
    $stmt_update->bindParam(':foto', $foto);
    $stmt_update->bindParam(':biografia', $biografia);

    if ($stmt_update->execute()) {
        echo "Dados atualizados com sucesso!";
        header("Location: perfil.php");
    } else {
        echo "Erro ao atualizar os dados. Tente novamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="css/style_edit_data.css">
</head>
<body>
    <div class="cad-container">
        <h1 class="titulo">Editar Perfil</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="campo_upload">
                <label class="lbl_cad">Upload de Foto</label>
                <input type="file" name="foto" accept="image/*">
            </div>
            <div class="campo_nome">
                <label class="lbl_cad">Nome</label>
                <input class="input_cad" type="text" name="nome" value="<?php echo htmlspecialchars($nome); ?>">
            </div>
            <div class="campo_email">
                <label class="lbl_cad">E-mail</label>
                <input class="input_cad" type="text" name="email" value="<?php echo htmlspecialchars($email); ?>">
            </div>
            <div class="campo_data">
                <label class="lbl_cad">Data de Nascimento</label>
                <input class="input_cad" type="date" name="data_nasc" value="<?php echo htmlspecialchars($data_nascimento); ?>">
            </div>
            <div class="campo_especializacao_experiencia">
                <div class="campo_especializacao">
                    <label class="lbl_cad">Especialização</label>
                    <select class="input_cad" name="especializacao">
                        <option value="">Selecione...</option>
                        <?php
                            foreach ($especializacoes as $row):
                                $selected = ($especializacao == $row['nome']) ? 'selected' : '';
                        ?>
                            <option value="<?php echo htmlspecialchars($row['nome']); ?>" <?php echo $selected; ?>>
                                <?php echo htmlspecialchars($row['nome']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="campo_experiencia">
                    <label class="lbl_cad">Experiência (em anos)</label>
                    <input class="input_cad" type="number" name="experiencia" value="<?php echo htmlspecialchars($experiencia); ?>">
                </div>
            </div>
            <div class="campo_contato">
                <label id="contato" class="lbl_cad">Contato</label>
                <input class="input_cad" type="text" name="contato" value="<?php echo htmlspecialchars($contato); ?>">
            </div>

            <div class="campo_biografia">
                <label class="lbl_cad">Sobre Mim</label>
                <textarea id="input_bio" class="input_cad" name="biografia" rows="5" maxlength="1000"><?php echo htmlspecialchars($biografia); ?></textarea>
            </div>


            <div>
                <button type="submit" class="btn_salvar">Salvar</button>
            </div>
            <!-- <div>
                <a href="galeria.php" class="">diretorio</a>
            </div> -->
            <div class="div_delete">
                <a href="exclusao_conta.php" class="btn_delete">Deletar Conta</a>
            </div>
        </form>
    </div>
</body>
</html>
