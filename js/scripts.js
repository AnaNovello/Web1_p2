$(document).ready(function () {
    let competenciasTemp = [];
    let receitasTemp = [];
    let cozinheiroID = null;
    let idParaExcluir = null;
    let tipoParaExcluir = null;

    // Função para exibir uma mensagem de erro
    function showErrorMessage(message) {
        $('#error-message').text(message).css('color', 'red').show();
        setTimeout(function() {
            $('#error-message').fadeOut();
        }, 3000);
    }

    // Envia os dados via Ajax
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

                    // Limpeza de campos
                    $('#form-cadastro-cozinheiro')[0].reset();
                    competenciasTemp = [];
                    receitasTemp = [];
                    cozinheiroID = result.cozinheiro_id;

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


    $('#btn-nova-competencia').on('click', function () {
        $('#modal-competencia').show();
    });

    $('#close-competencia').on('click', function () {
        $('#modal-competencia').hide();
    });

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

    $('#close-editar-competencia').on('click', function () {
        $('#modal-editar-competencia').hide();
    });
    

    $('#btn-editar-receitas').on('click', function () {
        $('#modal-editar-receita').show();
        carregarReceitasParaEditar();
    });

    $('#close-editar-receita').on('click', function () {
        $('#modal-editar-receita').hide();
    });


    // Dialog de edição
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

    // Dialog de exclusão
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

    // Atualizar dados no banco via Ajax
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

    // Atualizar dados no banco via Ajax
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

    // Carrega os dados do banco e exibe no modal de edição
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


    // Carrega os dados do banco e exibe no modal de edição
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

    //Dialog para confirmar exclusão
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

    // Atualiza a exibição das competências
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

    // Atualiza a exibição das receitas
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


    $('#btn-recarregar-competencias').on('click', function () {
        atualizarListaCompetencias();
    });

    $('#btn-recarregar-receitas').on('click', function () {
        atualizarListaReceitas();
    });

    // Cadastro de nova receita
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


    $('#btn-recarregar-competencias').on('click', function () {
        atualizarListaCompetencias();
    });

    $('#btn-recarregar-receitas').on('click', function () {
        atualizarListaReceitas();
    });
});
