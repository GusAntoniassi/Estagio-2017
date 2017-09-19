$(document).ready(function() {
    // Clicar na tabela handler
    $('select[name="produto_id"]').on('select2:select', function(e) {
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
                        // $select2.val(null).trigger('change');
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
                        // $select2.val(null).trigger('change');
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

    // Descontos change handler
    $('#tabela-produtos').on('change', 'tfoot input[name="descontos"]', atualizaRodape);

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
            var descontos = moedaToFloat($('#tabela-produtos tfoot input[name="descontos"]').val()) || 0;
            console.log(descontos);
            var valorTotal = valorLiquido - descontos;
            if (valorTotal < 0) {
                valorTotal = 0;
            }

            var $tfoot = $('#tabela-produtos tfoot');
            // Valor líquido
            $tfoot.find('.valor-liquido').text(floatToMoeda(valorLiquido));
            $tfoot.find('input[name="valor_liquido"]').val(valorLiquido);
            // Descontos
            // $tfoot.find('.descontos').text(floatToMoeda(descontos));
            $tfoot.find('input[name="descontos"]').val(floatToMoeda(descontos, ''));
            // Valor total
            $tfoot.find('.valor-total').text(floatToMoeda(valorTotal));
            $tfoot.find('input[name="valor_total"]').val(valorTotal);
        } else {
            // Esconder o rodapé e mostrar a mensagem "Sem produtos"
            $('#tabela-produtos .sem-produtos').removeClass('invisible');
            $('#tabela-produtos tfoot').addClass('invisible');
        }
    }
});