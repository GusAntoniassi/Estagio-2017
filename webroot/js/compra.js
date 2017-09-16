$(document).ready(function() {
    $('#autocomplete-input').select2({
        ajax: {
            url: urlProdutoAutocomplete,
            dataType: 'json',
            type: 'GET',
            data: function(params) {
                return {q: params.term}
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            id: item.id,
                            nome: item.nome,
                            foto: item.foto,
//                                    custo: item.custo,
                            possuiLote: item.possuiLote,
                        }
                    })
                }
            },
        },
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        templateResult: function(dados) {
            if (dados.loading) return null;

            var foto = (dados.foto ? dados.foto : 'http://via.placeholder.com/45x45')

            var html = '<div class="valign-wrapper">' +
                '<img src="' + foto + '" class="circle">' +
                '<span>&nbsp; ' + dados.nome + '</span>' +
                '</div>';

            return html;
        },
        templateSelection: function(dados) {
            return dados.nome;
        },
    });

    // Clicar na tabela handler
    $('#autocomplete-input').on('select2:select', function(e) {
        var $select2 = $(this);
        if (e) {
            $select2.siblings('label').addClass('active');
            var dados = e.params.data;
            if (dados) {
                if ($('tr.produto[data-produto-id="' + dados.id + '"]').length > 0) { // Se o produto já existe na tabela
                    // Incrementar a quantidade em estoque
                    $('tr.produto[data-produto-id="' + dados.id + '"] .quantidade input').get(0).value++;
                    setTimeout(function() {
                        // Limpar o select
                        $select2.val(null).trigger('change');
                    }, 100);
                } else {
                    // Quantos produtos já tem na tabela
                    var linhaTabela = $('tr.produto').length;
                    $.get({
                        url: urlCellProduto,
                        data: {
                            id: dados.id,
                            linhaAtual: linhaTabela,
                        },
                        dataType: 'html'
                    }).done(function(html) {
                        if (html) {
                            $('#tabela-produtos tbody').append(html).promise().done(function() {
                                if (dados.possuiLote) {
                                    // Quantos lotes já tem naquele produto
                                    var linhaTabelaLote = $('tr.lote[data-produto-id="' + dados.id + '"]').length;
                                    $.get({
                                        url: urlCellLote,
                                        data: {
                                            linhaAtual: linhaTabela,
                                            linhaAtualLote: linhaTabelaLote,
                                            produtoId: dados.id,
                                        },
                                        dataType: 'html'
                                    }).done(function(html) {
                                        if (html) {
                                            $('#tabela-produtos tbody').append(html);
                                            maskInputs();
                                        }
                                    });
                                } else {
                                    maskInputs();
                                }
                            });
                        } else {
                            console.error('Erro ao trazer a linha da tabela para o produto ID ' + dados.id);
                        }
                        atualizaRodape();
                    });
                }
            }
        }
    });

    // Quantidade change handler
    $('#tabela-produtos').on('change', 'tbody .quantidade input, tbody .valor-unitario input', function() {
        var produtoId = $(this).closest('tr.produto').data('produto-id') || 0;
        atualizaTotalLinha(produtoId);
        atualizaRodape();
    });
    // Remover produto handler
    $('#tabela-produtos').on('click', 'tr.produto .remover-item', function(e) {
        var produtoId = $(e.target).closest('tr.produto').data('produto-id');
        $('tr[data-produto-id="' + produtoId + '"]').remove();
        atualizaRodape();
    });

    // Adicionar lote handler
    $('#tabela-produtos').on('click', '.adicionar-lote', function(e) {
        var $target = $(e.target);
        var $trAtual = $target.closest('tr.lote');

        // Parâmetros necessários para o AJAX de criar linha
        var produtoId = $trAtual.data('produto-id'); // ID do produto
        var linhaAtualLote = $('tr.lote[data-produto-id="' + produtoId + '"]').length; // Quantidade de lotes que já tem
        var linhaAtual = $('tr.produto[data-produto-id="' + produtoId + '"]').data('linha-id'); // ID da linha do produto

        $.get({
            url: urlCellLote,
            data: {
                produtoId: produtoId,
                linhaAtual: linhaAtual,
                linhaAtualLote: linhaAtualLote,
            },
            dataType: 'html'
        }).done(function(html) {
            if (html) {
                $('#tabela-produtos tbody').append(html);
                // Remover o botão de 'adicionar lote' de todos os lotes daquele produtoId, menos o último
                $('tr.lote[data-produto-id="'+ produtoId +'"]:not(:last-of-type)').find('.adicionar-lote').remove();
                maskInputs();
                atualizaRodape();
            }
        });
    });
    // Remover lote handler
    $('#tabela-produtos').on('click', '.remover-lote', function(e) {
        var $target = $(e.target);
        var $trAtual = $target.closest('tr.lote');

        var produtoId = $trAtual.data('produto-id');
        var linhaIdTrRemovido = $trAtual.attr('data-linha-id');

        var $lotesProduto = $('tr.lote[data-produto-id="' + produtoId + '"]');

        // Não deixa remover o último lote
        if ($lotesProduto.length == 1) {
            return;
        }

        // Se estiver deletando o último lote, adicionar o botão de adicionar no penúltimo
        if ($lotesProduto.last().is($trAtual)) {
            $lotesProduto.last().prev().find('.wrapper-adicionar').append('<a class="adicionar-lote"><i class="material-icons">add</i></a>')
        }

        $trAtual.remove();
        // Decrementar o linha-id de todos os <tr>s que estavam abaixo daquele que foi removido para manter a sequência
        $lotesProduto.each(function(i, $el) {
            var linhaId = $($el).attr('data-linha-id');
            console.log(linhaId);
            console.log(linhaIdTrRemovido);
            if (linhaId > linhaIdTrRemovido) {
                $($el).attr('data-linha-id', --linhaId);
            }
        });
    });

    // Pegar o valor total do tr.produto
    function getValorTotalLinha($tr) {
        if (!($tr instanceof jQuery)) {
            $tr = $($tr);
        }
        return parseInt($tr.find('.quantidade input').val(), 10) * moedaToFloat($($tr).find('.valor-unitario input').val());

    }
    // Atualizar valor total na linha
    function atualizaTotalLinha(produtoId) {
        var $tr = $('#tabela-produtos tr.produto[data-produto-id="' + produtoId + '"]');
        if ($tr.length) {
            var valorTotal = getValorTotalLinha($tr);
            $tr.find('.valor-total').text(floatToMoeda(valorTotal));
        } else {
            console.error('Erro ao pegar o tr.produto de id ' + produtoId);
        }
    }
    // Atualizar rodapé da compra
    function atualizaRodape() {
        if ($('#tabela-produtos tr.produto').length) {
            $('#tabela-produtos .sem-produtos').addClass('invisible');
            $('#tabela-produtos tfoot').removeClass('invisible');

            var valorLiquido = 0;
            $('tr.produto').each(function(i, $tr) {
                valorLiquido += getValorTotalLinha($tr);
            });
            var descontos = $('#tabela-produtos tfoot .descontos input').val() || 0;
            var valorTotal = valorLiquido - descontos;

            $('#tabela-produtos tfoot .valor-liquido').text(floatToMoeda(valorLiquido));
            $('#tabela-produtos tfoot .descontos').text(floatToMoeda(descontos));
            $('#tabela-produtos tfoot .valor-total').text(floatToMoeda(valorTotal));
        } else {
            // Esconder o rodapé e mostrar a mensagem "Sem produtos"
            $('#tabela-produtos .sem-produtos').removeClass('invisible');
            $('#tabela-produtos tfoot').addClass('invisible');
        }
    }
});