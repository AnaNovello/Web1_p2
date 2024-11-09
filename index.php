<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro e Listagem - Página Única</title>
    <link rel="stylesheet" href="css/style_p2_index.css">
    <link rel="stylesheet" href="css/style_modal.css"> 
    <link rel="stylesheet" href="css/style_buttons.css"> 
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
        </form>
    </div>
    
    <!-- Seleção de Competências e Receitas com botão para adicionar novo -->
    <div class="form-group">
        <label for="competencia">Competência:</label>
        <!--<select id="select-competencia" name="competencia">
            <option value="">Selecione uma competência</option>
            <option value="">Competência 1</option>
        </select>-->
        <div class="btn_group">
            <button type="button" id="btn-nova-competencia" class="buttons">Nova Competência</button>
            <button id="btn-recarregar-competencias" class="buttons">Recarregar Lista</button>
        </div>
        
        <!-- Listagem de Competências -->
        <div id="listagem-competencias" class="section">
            <div id="competencias-list">
                <!-- Competências serão carregadas aqui -->
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="receita">Receita:</label>
        <!--<select id="select-receita" name="receita">
            <option value="">Selecione uma receita</option>
            <option value="">Receita 1</option>
            receita 1
        </select>-->
        <div class="btn_group">
            <button type="button" id="btn-nova-receita" class="buttons">Nova Receita</button>
            <button id="btn-recarregar-receitas" class="buttons">Recarregar Lista</button>
        </div>

        <!-- Listagem de Receitas -->
        <div id="listagem-receitas" class="section">
            <div id="receitas-list">
                <!-- Receitas serão carregadas aqui -->
            </div>
        </div>
    </div>

    <button  id="btn-cadastrar" type="submit" class="btn">Cadastrar</button>

    <!-- Modal para cadastro de novas competências -->
    <div id="modal-competencia" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close" id="close-competencia">&times;</span>
            <h2>Nova Competência</h2>
            <form id="form-nova-competencia">
                <div class="form-group">
                    <label for="nome-competencia">Nome da Competência:</label>
                    <input type="text" id="nome-competencia" name="nome-competencia" required>
                </div>
                <div class="form-group">
                    <label for="descricao-competencia">Descrição:</label>
                    <textarea id="descricao-competencia" name="descricao-competencia" required></textarea>
                </div>
                <div class="form-group">
                    <label for="proficiencia-competencia">Proeficiência (1-10):</label>
                    <input type="number" id="proficiencia-competencia" name="proficiencia-competencia" min="1" max="10" required>
                </div>
                <button type="button" id="btn-salvar-competencia">Salvar Competência</button>
            </form>
        </div>
    </div>

    <!-- Modal para cadastro de novas receitas -->
    <div id="modal-receita" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close" id="close-receita">&times;</span>
            <h2>Nova Receita</h2>
            <form id="form-nova-receita">
                <div class="form-group">
                    <label for="nome-receita">Nome da Receita:</label>
                    <input type="text" id="nome-receita" name="nome-receita" required>
                </div>
                <div class="form-group">
                    <label for="descricao-receita">Descrição:</label>
                    <textarea id="descricao-receita" name="descricao-receita" required></textarea>
                </div>
                <button type="button" id="btn-salvar-receita">Salvar Receita</button>
            </form>
        </div>
    </div>




    <!-- Scripts jQuery e Ajax -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Função para carregar competências
            function carregarCompetencias() {
                $.ajax({
                    url: 'carregar_competencias.php',
                    method: 'GET',
                    success: function (data) {
                        $('#competencias-list').html(data);
                        $('#select-competencia').html(data);
                    },
                    error: function () {
                        alert('Erro ao carregar competências');
                    }
                });
            }

            // Função para carregar receitas
            function carregarReceitas() {
                $.ajax({
                    url: 'carregar_receitas.php',
                    method: 'GET',
                    success: function (data) {
                        $('#receitas-list').html(data);
                        $('#select-receita').html(data);
                    },
                    error: function () {
                        alert('Erro ao carregar receitas');
                    }
                });
            }

            // Chama as funções ao carregar a página
            //carregarCompetencias();
            //carregarReceitas();

            // Recarrega as listas quando os botões são clicados
            //$('#btn-recarregar-competencias').on('click', carregarCompetencias);
            //$('#btn-recarregar-receitas').on('click', carregarReceitas);

            // Envia os dados do formulário de cadastro de cozinheiro via Ajax
            $('#btn-cadastrar').on('click', function (e) {
                e.preventDefault();

                // Criar o objeto FormData para enviar todos os dados
                const dadosCozinheiro = new FormData();
                dadosCozinheiro.append('nome', $('#nome').val());
                dadosCozinheiro.append('cpf', $('#cpf').val());
                dadosCozinheiro.append('email', $('#email').val());
                dadosCozinheiro.append('senha', $('#senha').val());
                dadosCozinheiro.append('confirmar_senha', $('#confirmar_senha').val());

                // Adiciona as competências temporárias ao FormData
                dadosCozinheiro.append('competencias', JSON.stringify(competenciasTemp));

                // Adiciona as receitas 
                dadosCozinheiro.append('receitas', JSON.stringify(receitasTemp));

                $.ajax({
                    url: 'cadastrar_cozinheiro.php',
                    method: 'POST',
                    data: dadosCozinheiro,
                    processData: false,  // Necessário para enviar arquivos
                    contentType: false,  // Necessário para enviar arquivos
                    success: function (response) {
                        alert(response);
                        // Limpa os arrays temporários após o cadastro
                        competenciasTemp = [];
                        receitasTemp = [];

                        // Opcional: Limpa os campos do formulário principal
                        $('#form-cadastro-cozinheiro')[0].reset();

                        // Atualiza a lista de competências e receitas
                        //carregarCompetencias();
                        //carregarReceitas();
                    },
                    error: function () {
                        alert('Erro ao cadastrar');
                    }
                });
            });

            // Funções para abrir e fechar o modal de competência
            $('#btn-nova-competencia').on('click', function () {
                $('#modal-competencia').show();
            });
            $('#close-competencia').on('click', function () {
                $('#modal-competencia').hide();
            });

            // Funções para abrir e fechar o modal de receita
            $('#btn-nova-receita').on('click', function () {
                $('#modal-receita').show();
            });
            $('#close-receita').on('click', function () {
                $('#modal-receita').hide();
            });

            let competenciasTemp = [];
            let receitasTemp = [];

            // Função para atualizar a exibição das competências temporárias
            function atualizarListaCompetencias() {
                let html = "";
                competenciasTemp.forEach((competencia, index) => {
                    html += `<p><strong>Competência ${index + 1}:</strong> ${competencia.nome} - ${competencia.descricao} (Proficiencia: ${competencia.proficiencia})</p>`;
                });
                $('#competencias-list').html(html);
            }

            // Função para atualizar a exibição das receitas temporárias
            function atualizarListaReceitas() {
                let html = "";
                receitasTemp.forEach((receita, index) => {
                    html += `<p><strong>Receita ${index + 1}:</strong> ${receita.nome} - ${receita.descricao}</p>`;
                });
                $('#receitas-list').html(html);
            }

            // Salva a nova competência temporariamente
            $('#btn-salvar-competencia').on('click', function () {
                const competencia = {
                    nome: $('#nome-competencia').val(),
                    descricao: $('#descricao-competencia').val(),
                    proficiencia: $('#proficiencia-competencia').val()
                };

                competenciasTemp.push(competencia);
                $('#modal-competencia').hide();
                alert("Competência adicionada!");

                // Limpa os campos do formulário
                $('#form-nova-competencia')[0].reset();

                /*$.ajax({
                    url: 'cadastrar_competencia.php',
                    method: 'POST',
                    data: competencia,
                    success: function (response) {
                        alert(response);
                        $('#modal-competencia').hide();
                        carregarCompetencias(); // Recarrega as competências
                    },
                    error: function () {
                        alert('Erro ao cadastrar competência');
                    }
                });*/
            });

            // Exibe a lista de competências temporárias ao clicar em "Recarregar Lista"
            $('#btn-recarregar-competencias').on('click', function () {
                atualizarListaCompetencias();
            });

            // Exibe a lista de receitas temporárias ao clicar em "Recarregar Lista"
            $('#btn-recarregar-receitas').on('click', function () {
                atualizarListaReceitas();
            });

            // Envia os dados do formulário de nova receita
            $('#btn-salvar-receita').on('click', function () {
                const receita = {
                    nome: $('#nome-receita').val(),
                    descricao: $('#descricao-receita').val()
                };
                receitasTemp.push(receita);
                $('#modal-receita').hide();

                // Limpa os campos do formulário
                $('#form-nova-receita')[0].reset();

                /*$.ajax({
                    url: 'cadastrar_receita.php',
                    method: 'POST',
                    data: formData,
                    processData: false,  // Necessário para o envio de arquivo
                    contentType: false,  // Necessário para o envio de arquivo
                    success: function (response) {
                        alert(response);
                        $('#modal-receita').hide();
                        carregarReceitas(); // Recarrega as receitas
                    },
                    error: function () {
                        alert('Erro ao cadastrar receita');
                    }
                });*/
            });
            // Exibe a lista de competências temporárias ao clicar em "Recarregar Lista"
            $('#btn-recarregar-competencias').on('click', function () {
                atualizarListaCompetencias();
            });

            // Exibe a lista de receitas temporárias ao clicar em "Recarregar Lista"
            $('#btn-recarregar-receitas').on('click', function () {
                atualizarListaReceitas();
            });




        });
    </script>

</body>
</html>
