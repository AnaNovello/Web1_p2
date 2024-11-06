<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro e Listagem - Página Única</title>
    <link rel="stylesheet" href="css/style_p2_index.css">
    <!-- <link rel="stylesheet" href="css/style_modal.css"> -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>
<body>

    <!-- Formulário de Cadastro da Entidade Principal -->
    <div id="cadastro-principal" class="section">
        <h1>Cadastro de Cozinheiro</h1>
        <form id="form-cadastro-cozinheiro">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <div class="form-group">
                <label for="confirmar_senha">Confirme sua senha:</label>
                <input type="password" id="confirmar_senha" name="confirmar_senha" required>
            </div>

            <!-- Seleção de Competências e Receitas com botão para adicionar novo -->
            <div class="form-group">
                <label for="competencia">Competência:</label>
                <select id="select-competencia" name="competencia">
                    <!-- Opções de competências serão carregadas aqui -->
                </select>
                <button type="button" id="btn-nova-competencia">Nova Competência</button>

                <!-- Listagem de Competências -->
            <div id="listagem-competencias" class="section">
                <button id="btn-recarregar-competencias">Recarregar Lista</button>
                <div id="competencias-list">
                    <!-- Competências serão carregadas aqui -->
                </div>
            </div>

            </div>

            <div class="form-group">
                <label for="receita">Receita:</label>
                <select id="select-receita" name="receita">
                    <!-- Opções de receitas serão carregadas aqui -->
                </select>
                <button type="button" id="btn-nova-receita">Nova Receita</button>

                <!-- Listagem de Receitas -->
            <div id="listagem-receitas" class="section">
                <button id="btn-recarregar-receitas">Recarregar Lista</button>
                <div id="receitas-list">
                    <!-- Receitas serão carregadas aqui -->
                </div>
            </div>
            </div>

            <button type="submit" class="btn">Cadastrar</button>
        </form>
    </div>

    <!-- Formulário Modal para Competência -->
    <div id="modal-competencia" title="Adicionar Competência" style="display:none;">
        <form id="form-nova-competencia">
            <label for="nome-competencia">Nome:</label>
            <input type="text" id="nome-competencia" name="nome" required>
            <label for="descricao-competencia">Descrição:</label>
            <textarea id="descricao-competencia" name="descricao"></textarea>
            <label for="proficiencia-competencia">Proficiência:</label>
            <input type="number" id="proficiencia-competencia" name="proficiencia" min="1" max="10" required>
            <button type="submit">Salvar</button>
        </form>
    </div>

    <!-- Formulário Modal para Receita -->
    <div id="modal-receita" title="Adicionar Receita" style="display:none;">
        <form id="form-nova-receita" enctype="multipart/form-data">
            <label for="nome-receita">Nome:</label>
            <input type="text" id="nome-receita" name="nome" required>
            <label for="descricao-receita">Descrição:</label>
            <textarea id="descricao-receita" name="descricao"></textarea>
            <label for="foto-receita">Foto:</label>
            <input type="file" id="foto-receita" name="foto" accept="image/*" required>
            <button type="submit">Salvar</button>
        </form>
    </div>

    <!-- Scripts jQuery e jQuery UI -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function () {
            // Inicializa os diálogos
            $("#modal-competencia").dialog({ autoOpen: false });
            $("#modal-receita").dialog({ autoOpen: false });

            // Abre o modal de nova competência
            $("#btn-nova-competencia").click(function () {
                $("#modal-competencia").dialog("open");
            });

            // Abre o modal de nova receita
            $("#btn-nova-receita").click(function () {
                $("#modal-receita").dialog("open");
            });

            // Submissão do formulário de nova competência
            $("#form-nova-competencia").submit(function (event) {
                event.preventDefault();
                // Enviar dados via AJAX e recarregar o select de competência
                $.post("adicionar-competencia.php", $(this).serialize(), function (data) {
                    alert("Competência adicionada com sucesso!");
                    $("#modal-competencia").dialog("close");
                    atualizarCompetencias();
                });
            });

            // Submissão do formulário de nova receita
            $("#form-nova-receita").submit(function (event) {
                event.preventDefault();
                // Enviar dados via AJAX e recarregar o select de receita
                let formData = new FormData(this);
                $.ajax({
                    url: "adicionar-receita.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        alert("Receita adicionada com sucesso!");
                        $("#modal-receita").dialog("close");
                        atualizarReceitas();
                    }
                });
            });

            // Funções para atualizar listas de seleções
            function atualizarCompetencias() {
                $.getJSON("listar-competencia.php", function (data) {
                    $("#select-competencia").empty();
                    $.each(data, function (key, val) {
                        $("#select-competencia").append(new Option(val.nome, val.id));
                    });
                });
            }

            function atualizarReceitas() {
                $.getJSON("listar-receita.php", function (data) {
                    $("#select-receita").empty();
                    $.each(data, function (key, val) {
                        $("#select-receita").append(new Option(val.nome, val.id));
                    });
                });
            }

            // Botões para recarregar listas de competências e receitas
            $("#btn-recarregar-competencias").click(atualizarCompetencias);
            $("#btn-recarregar-receitas").click(atualizarReceitas);

            // Inicializa listas
            atualizarCompetencias();
            atualizarReceitas();
        });
    </script>
</body>
</html>
