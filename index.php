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
    <div class="container">
        <div id="cadastro-principal" class="section">
            <h1 class="titulo">Cadastro de Cozinheiro</h1>
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
            <div class="btn_group">
                <button type="button" id="btn-nova-competencia" class="buttons">Nova Competência</button>
                <button id="btn-recarregar-competencias" class="buttons">Recarregar Lista</button>
                <button id="btn-editar-competencias" class="buttons">Editar</button>
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
            <div class="btn_group">
                <button type="button" id="btn-nova-receita" class="buttons">Nova Receita</button>
                <button id="btn-recarregar-receitas" class="buttons">Recarregar Lista</button>
                <button id="btn-editar-receitas" class="buttons">Editar</button>
            </div>

            <!-- Listagem de Receitas -->
            <div id="listagem-receitas" class="section">
                <div id="receitas-list">
                    <!-- Receitas serão carregadas aqui -->
                </div>
            </div>
        </div>

        <button  id="btn-cadastrar" type="submit" class="btn">Cadastrar</button>
        <div id="success-message" style="display: none; color: green; font-weight: bold; margin-top: 10px;"></div>
        <div id="error-message"></div>

        <!-- Dialog de Confirmação de Exclusão -->
        <div id="dialog-confirm" title="Confirmação de Exclusão" style="display:none;">
            <p>Tem certeza de que deseja excluir este registro?</p>
        </div>


    </div>

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

    <!-- Modal para edição de Competências -->
    <div id="modal-editar-competencia" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close" id="close-editar-competencia">&times;</span>
            <h2>Editar Competências</h2>
            <div id="competencias-list-edit" class="edit-list">
                <!-- Lista de competências para editar/excluir será carregada aqui -->
            </div>
        </div>
    </div>

    <!-- Modal para edição de Receitas -->
    <div id="modal-editar-receita" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close" id="close-editar-receita">&times;</span>
            <h2>Editar Receitas</h2>
            <div id="receitas-list-edit" class="edit-list">
                <!-- Lista de receitas para editar/excluir será carregada aqui -->
            </div>
        </div>
    </div>

    <div id="dialog-editar" style="display:none;">
        <form>
            <label for="nome">Nome:</label>
            <input type="text" name="nome" required>
            <label for="descricao">Descrição:</label>
            <textarea name="descricao" required></textarea>
            <label for="proficiencia">Proficiência (1-10):</label>
            <input type="number" name="proficiencia" min="1" max="10">
        </form>
    </div>

    <div id="dialog-confirm" title="Confirmar exclusão" style="display:none;">
        <p>Tem certeza de que deseja excluir este registro?</p>
    </div>




    <!-- Scripts jQuery e Ajax -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function () {
            let competenciasTemp = [];
            let receitasTemp = [];
            let cozinheiroID = null;
            let idParaExcluir = null;
            let tipoParaExcluir = null;

            // Função para exibir mensagem temporária de sucesso
            function showSuccessMessage(message) {
                $('#success-message').text(message).show();
                setTimeout(function() {
                    $('#success-message').fadeOut();
                }, 3000);
            }

            // Função para exibir uma mensagem de erro
            function showErrorMessage(message) {
                $('#error-message').text(message).css('color', 'red').show();
                setTimeout(function() {
                    $('#error-message').fadeOut();
                }, 3000);
            }

            // Envia os dados do formulário de cadastro de cozinheiro via Ajax
            $('#btn-cadastrar').on('click', function (e) {
                e.preventDefault();
                // Verificação de campos obrigatórios
                if (!$('#nome').val() || !$('#cpf').val() || !$('#email').val() || !$('#senha').val() || !$('#confirmar_senha').val()) {
                    showErrorMessage("Por favor, preencha todos os campos obrigatórios.");
                    return;
                }
                const dadosCozinheiro = new FormData();
                dadosCozinheiro.append('nome', $('#nome').val());
                dadosCozinheiro.append('cpf', $('#cpf').val());
                dadosCozinheiro.append('email', $('#email').val());
                dadosCozinheiro.append('senha', $('#senha').val());
                dadosCozinheiro.append('competencias', JSON.stringify(competenciasTemp));
                dadosCozinheiro.append('receitas', JSON.stringify(receitasTemp));

                $.ajax({
                    url: 'cadastrar_cozinheiro.php',
                    method: 'POST',
                    data: dadosCozinheiro,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        const result = JSON.parse(response);
                        if (result.success) {
                            alert(result.success);
                            $('#form-cadastro-cozinheiro')[0].reset();
                            competenciasTemp = [];
                            receitasTemp = [];
                            cozinheiroID = result.cozinheiro_id;

                            // Recarrega as listas de competência e receita
                            atualizarListaCompetencias();
                            atualizarListaReceitas();
                        } else {
                            alert(result.error);
                        }
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


            $('#btn-editar-competencias').on('click', function () {
                $('#modal-editar-competencia').show();
                carregarCompetenciasParaEditar();
            });
            // Funções para fechar os modais de edição
            $('#close-editar-competencia').on('click', function () {
                $('#modal-editar-competencia').hide();
            });
            

            // Função para abrir o modal de edição de receita e carregar dados
            $('#btn-editar-receitas').on('click', function () {
                $('#modal-editar-receita').show();
                carregarReceitasParaEditar();
            });
            $('#close-editar-receita').on('click', function () {
                $('#modal-editar-receita').hide();
            });


            // Define o diálogo de edição de dados
            function abrirDialogEdicao(tipo, id, nomeAtual, descricaoAtual, proficienciaAtual) {
                // Preenche os campos com os valores atuais
                $('#dialog-editar input[name="nome"]').val(nomeAtual);
                $('#dialog-editar textarea[name="descricao"]').val(descricaoAtual);
                if (tipo === "competencia") {
                    $('#dialog-editar input[name="proficiencia"]').val(proficienciaAtual).show();
                } else {
                    $('#dialog-editar input[name="proficiencia"]').hide();
                }

                $('#dialog-editar').dialog({
                    title: `Editar ${tipo === "competencia" ? "Competência" : "Receita"}`,
                    modal: true,
                    buttons: {
                        "Salvar": function () {
                            const nome = $('#dialog-editar input[name="nome"]').val();
                            const descricao = $('#dialog-editar textarea[name="descricao"]').val();
                            const proficiencia = $('#dialog-editar input[name="proficiencia"]').val();
                            if (tipo === "competencia") {
                                atualizarCompetencia(id, nome, descricao, proficiencia);
                            } else {
                                atualizarReceita(id, nome, descricao);
                            }
                            $(this).dialog("close");
                        },
                        "Cancelar": function () {
                            $(this).dialog("close");
                        }
                    }
                });
            }

            // Define o diálogo de confirmação de exclusão
            function abrirDialogExclusao(tipo, id) {
                $('#dialog-confirm').dialog({
                    title: `Confirmar exclusão de ${tipo === "competencia" ? "Competência" : "Receita"}`,
                    modal: true,
                    buttons: {
                        "Excluir": function () {
                            if (tipo === "competencia") {
                                confirmarExclusaoCompetencia(id);
                            } else {
                                confirmarExclusaoReceita(id);
                            }
                            $(this).dialog("close");
                        },
                        "Cancelar": function () {
                            $(this).dialog("close");
                        }
                    }
                });
            }

            // Função para atualizar competência no servidor
            function atualizarCompetencia(id, nome, descricao, proficiencia) {
                $.ajax({
                    url: 'editar_competencia.php',
                    method: 'POST',
                    data: { id, nome, descricao, proficiencia },
                    success: function(response) {
                        alert("Competência atualizada com sucesso!");
                        carregarCompetenciasParaEditar();
                    },
                    error: function() {
                        alert("Erro ao atualizar competência.");
                    }
                });
            }

            // Função para atualizar receita no servidor
            function atualizarReceita(id, nome, descricao) {
                $.ajax({
                    url: 'editar_receita.php',
                    method: 'POST',
                    data: { id, nome, descricao },
                    success: function(response) {
                        alert("Receita atualizada com sucesso!");
                        carregarReceitasParaEditar();
                    },
                    error: function() {
                        alert("Erro ao atualizar receita.");
                    }
                });
            }

            // Função para carregar competências do banco e exibir no modal de edição
            function carregarCompetenciasParaEditar() {
                $.ajax({
                    url: 'list_competencias.php',
                    method: 'GET',
                    success: function(data) {
                        const competencias = JSON.parse(data);
                        let html = competencias.map(competencia => `
                            <div>
                                <p><strong>${competencia.nome}</strong>: ${competencia.descricao} (Proficiência: ${competencia.proficiencia})</p>
                                <button class="editar-competencia" data-id="${competencia.id}" data-nome="${competencia.nome}" data-descricao="${competencia.descricao}" data-proficiencia="${competencia.proficiencia}">Editar</button>
                                <button class="excluir-competencia" data-id="${competencia.id}">Excluir</button>
                            </div>
                        `).join('');
                        $('#competencias-list-edit').html(html);
                        // Adiciona eventos de click para os botões de editar e excluir após o HTML ser carregado
                        $('.editar-competencia').on('click', function() {
                        const id = $(this).data('id');
                        const nome = $(this).data('nome');
                        const descricao = $(this).data('descricao');
                        const proficiencia = $(this).data('proficiencia');
                        abrirDialogEdicao("competencia", id, nome, descricao, proficiencia);
                    });
                    
                    $('.excluir-competencia').on('click', function() {
                        const id = $(this).data('id');
                        abrirDialogExclusao("competencia", id);
                    });
                    },
                    error: function() {
                        alert('Erro ao carregar competências.');
                    }
                });
            }

            // Função para carregar receitas do banco e exibir no modal de edição
            function carregarReceitasParaEditar() {
                $.ajax({
                    url: 'list_receitas.php',
                    method: 'GET',
                    success: function(data) {
                        const receitas = JSON.parse(data);
                        let html = receitas.map(receita => `
                            <div>
                                <p><strong>${receita.nome}</strong>: ${receita.descricao}</p>
                                <button class="editar-receita" data-id="${receita.id}" data-nome="${receita.nome}" data-descricao="${receita.descricao}">Editar</button>
                                <button class="excluir-receita" data-id="${receita.id}">Excluir</button>
                            </div>
                        `).join('');
                        $('#receitas-list-edit').html(html);

                        // Adiciona eventos para os botões de editar e excluir
                        $('.editar-receita').on('click', function() {
                            const id = $(this).data('id');
                            const nome = $(this).data('nome');
                            const descricao = $(this).data('descricao');
                            abrirDialogEdicao("receita", id, nome, descricao);
                        });
                        
                        $('.excluir-receita').on('click', function() {
                            const id = $(this).data('id');
                            abrirDialogExclusao("receita", id);
                        });
                    },
                    error: function() {
                        alert('Erro ao carregar receitas.');
                    }
                });
            }

            function editarCompetencia(id) {
                const nome = prompt("Digite o novo nome da competência:");
                const descricao = prompt("Digite a nova descrição da competência:");
                const proficiencia = prompt("Digite a nova proficiência da competência (1-10):");

                $.ajax({
                    url: 'editar_competencia.php',
                    method: 'POST',
                    data: { id, nome, descricao, proficiencia },
                    success: function(response) {
                        alert("Competência atualizada com sucesso!");
                        carregarCompetenciasParaEditar();
                    },
                    error: function() {
                        alert("Erro ao atualizar competência.");
                    }
                });
            }

            $("#dialog-confirm").dialog({
                autoOpen: false,
                resizable: false,
                height: "auto",
                width: 400,
                modal: true,
                buttons: {
                    "Excluir": function () {
                        if (tipoParaExcluir === "competencia") {
                            confirmarExclusaoCompetencia(idParaExcluir);
                        } else if (tipoParaExcluir === "receita") {
                            confirmarExclusaoReceita(idParaExcluir);
                        }
                        $(this).dialog("close");
                    },
                    "Cancelar": function () {
                        $(this).dialog("close");
                    }
                }
            });


            function excluirCompetencia(id) {
                idParaExcluir = id;
                tipoParaExcluir = "competencia";
                $("#dialog-confirm").dialog("open");
            }

            function editarReceita(id) {
                const nome = prompt("Digite o novo nome da receita:");
                const descricao = prompt("Digite a nova descrição da receita:");

                $.ajax({
                    url: 'editar_receita.php',
                    method: 'POST',
                    data: { id, nome, descricao },
                    success: function(response) {
                        alert("Receita atualizada com sucesso!");
                        carregarReceitasParaEditar();
                    },
                    error: function() {
                        alert("Erro ao atualizar receita.");
                    }
                });
            }

            function excluirReceita(id) {
                idParaExcluir = id;
                tipoParaExcluir = "receita";
                $("#dialog-confirm").dialog("open");
            }

             // Função para confirmar a exclusão de competência
            function confirmarExclusaoCompetencia(id) {
                $.ajax({
                    url: 'excluir_competencia.php',
                    method: 'POST',
                    data: { id },
                    success: function(response) {
                        alert("Competência excluída com sucesso!");
                        carregarCompetenciasParaEditar();
                    },
                    error: function() {
                        alert("Erro ao excluir competência.");
                    }
                });
            }

            function confirmarExclusaoReceita(id) {
                $.ajax({
                    url: 'excluir_receita.php',
                    method: 'POST',
                    data: { id },
                    success: function(response) {
                        alert("Receita excluída com sucesso!");
                        carregarReceitasParaEditar();
                    },
                    error: function() {
                        alert("Erro ao excluir receita.");
                    }
                });
            }

            // Função para atualizar a exibição das competências temporárias
            function atualizarListaCompetencias() {
                $.ajax({
                    url: 'list_competencias.php',
                    method: 'GET',
                    success: function(data) {
                        const competencias = JSON.parse(data);
                        let html = competencias.map(competencia => `<p><b>${competencia.nome} - Proficiência: ${competencia.proficiencia}</b></p> <p>${competencia.descricao}</p>`).join('');
                        $('#competencias-list').html(html);
                    },
                    error: function() {
                        alert('Erro ao carregar competências.');
                    }
                });
            }

            // Função para atualizar a exibição das receitas temporárias
            function atualizarListaReceitas() {
                $.ajax({
                    url: 'list_receitas.php',
                    method: 'GET',
                    success: function(data) {
                        const receitas = JSON.parse(data);
                        let html = receitas.map(receita => `<p><b>${receita.nome}</b></p> <p>${receita.descricao}</p>`).join('');
                        $('#receitas-list').html(html);
                    },
                    error: function() {
                        alert('Erro ao carregar receitas.');
                    }
                });
            }

            // Salva a nova competência
            $('#btn-salvar-competencia').on('click', function () {
                const competencia = {
                    nome: $('#nome-competencia').val(),
                    descricao: $('#descricao-competencia').val(),
                    proficiencia: $('#proficiencia-competencia').val(),
                    id_cozinheiro: cozinheiroID
                };

                $.ajax({
                    url: 'cadastrar_competencia.php',
                    method: 'POST',
                    data: competencia,
                    success: function(response) {
                        const result = JSON.parse(response);
                        if (result.success) {
                            alert(result.success);
                            $('#modal-competencia').hide();
                        } else {
                            alert(result.error);
                        }
                    },
                    error: function() {
                        alert('Erro ao cadastrar competência');
                    }
                });

            });

            // Exibe a lista de competências temporárias ao clicar em "Recarregar Lista"
            $('#btn-recarregar-competencias').on('click', function () {
                atualizarListaCompetencias();
            });

            // Exibe a lista de receitas temporárias ao clicar em "Recarregar Lista"
            $('#btn-recarregar-receitas').on('click', function () {
                atualizarListaReceitas();
            });

            // Evento de cadastro de nova receita
            $('#btn-salvar-receita').on('click', function () {
                const receita = {
                    nome: $('#nome-receita').val(),
                    descricao: $('#descricao-receita').val(),
                    id_cozinheiro: cozinheiroID
                };

                $.ajax({
                    url: 'cadastrar_receita.php',
                    method: 'POST',
                    data: receita,
                    success: function(response) {
                        const result = JSON.parse(response);
                        if (result.success) {
                            alert(result.success);
                            $('#modal-receita').hide();
                        } else {
                            alert(result.error);
                        }
                    },
                    error: function() {
                        alert('Erro ao cadastrar receita');
                    }
                });
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
