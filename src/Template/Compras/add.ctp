<?php
/**
  * @var \App\View\AppView $this
  */
use Cake\Routing\Router;
?>
<div class="compras form add row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Cadastro de Compra'); ?>

    <?= $this->Gus->control('status', [
        'div' => 'col s12 input-field',
        'label' => false,
        'type' => 'radio',
        'data-type' => 'tipo-pessoa',
        'options' => ['0' => 'Compra aberta', 'J' => 'Compra fechada'],
        'value' => '0',
    ]); ?>
    <div class="clearfix"></div>
    <br/>
    <?= $this->Gus->selectExtends('fornecedor_id', ['J. Martins Atacado', 'Supermercados Planalto', 'Musamar'], [
        'div' => 'col s5 input-field select2-field',
        'label' => ['text' => 'Fornecedor', 'class' => 'active'],
        'controller' => 'fornecedores',
    ]); ?>
    <div class="input-field col s3">
        <input type="text" id="data" data-type="date" value="<?= date('d/m/Y'); ?>">
        <label for="data">Data da compra</label>
    </div>
    <div class="clearfix"></div>

    <div class="input-field input-group col s6">
        <select id="autocomplete-input" class="autocomplete browser-default"></select>
        <label for="autocomplete-input">Produto</label>
        <span class="input-group-btn">
            <a class="btn btn-small waves-effect waves-light refresh" data-href="http://localhost/estagio2017/fornecedores/get-all" onclick="return refreshSelect(event.target || event.srcElement);"><i class="material-icons">autorenew</i></a>
            <a class="btn btn-small waves-effect waves-light edit" href="http://localhost/estagio2017/fornecedores/edit" onclick="return extendEdit(event);"><i class="material-icons">edit</i></a>
            <a class="btn btn-small waves-effect waves-light add" href="http://localhost/estagio2017/fornecedores/add" onclick="return extendAdd(event);"><i class="material-icons">add</i></a>
        </span>
    </div>
    <script>
        $(document).ready(function() {
            $('#autocomplete-input').select2({
                ajax: {
                    url: '<?= Router::url(['controller' => 'produtos', 'action' => 'getProdutosCompraveis']); ?>',
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
            // Clicar na tabela handler
            }).on('select2:select', function(e) {
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
                                url: '<?php echo Router::url(['controller' => 'produtos', 'action' => 'getLinhaTabela']); ?>',
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
                                                url: '<?php echo Router::url(['controller' => 'lotes', 'action' => 'getLinhaTabela']); ?>',
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
                                // Limpar o select
                                $select2.val(null).trigger('change');
                                atualizaRodape();
                            });
                        }
                    }
                    /* Fazer uma tabela com inputs mesmo, sem gravar na sesion nem nada.
                        Quando selecionar, verificar se o produto tem lote ou não, se tiver abrir campos
                        pra digitar a data de validade e o código do lote.

                        Forma de pagamento fazer uma combobox mesmo
                     */
                }
            });

            // Quantidade change handler
            $('#tabela-produtos').on('change', 'tbody .quantidade input, tbody .valor-unitario input', function() {
                var produtoId = $(this).closest('tr.produto').data('produto-id') || 0;
                atualizaTotalLinha(produtoId);
                atualizaRodape();
            });
            // TODO: Remover produto handler
            $('#tabela-produtos').on('click', 'tr.produto .remover-item', function(e) {
                var produtoId = $(e.target).closest('tr.produto').data('produto-id');
                $('tr[data-produto-id="' + produtoId + '"]').remove();
                atualizaRodape();
            });

            // Adicionar lote handler
            $('#tabela-produtos').on('click', '.adicionar-lote', function(e) {
                var $target = $(e.target);
                atualizaRodape();
//                var linhaTabela
            });

            // TODO: Remover lote handler

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
    </script>
    <div class="clearfix"></div>
    <br/>
    <div class="col s12">
        <table class="bordered responsive-table" id="tabela-produtos">
            <thead>
                <tr>
                    <th class="left-align" colspan="2">Produto</th>
                    <th class="center-align">Qtde</th>
                    <th class="right-align">Valor un.</th>
                    <th class="right-align">Valor tot.</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr class="sem-produtos"><td colspan="100%">Nenhum produto selecionado!</td></tr>
                <?php
                    // Apenas na edição
                    /*
                    echo $this->cell('LinhaTabela::produto', [1]);
                    echo $this->cell('LinhaTabela::lote', [1]);
                    echo $this->cell('LinhaTabela::produto', [4, 1, 3, 500]);
                    */
                ?>
            </tbody>
            <tfoot class="invisible">
                <tr>
                    <td colspan="3"></td>
                    <td class="right-align"><strong>Valor líquido</strong></td>
                    <td class="right-align valor-liquido">R$ 1.500,00</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td class="right-align"><strong>Descontos</strong></td>
                    <td class="right-align descontos">R$ 500,00</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td class="right-align"><strong>Valor total</strong></td>
                    <td class="right-align valor-total">R$ 1.000,00</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="input-field col s12">FORMA DE PAGAMENTO?</div>
    <div class="input-field col s12">
        <textarea id="textarea1" class="materialize-textarea"></textarea>
        <label for="textarea1">Comentários</label>
    </div>

    <!--
    <?= $this->Gus->create($compra, ['class' => 'row']) ?>
    <?php
                    echo $this->Gus->control('status', ['div' => 'col s12 input-field', 'label' => 'Status', 'checked' => 'checked']);
        echo $this->Gus->control('data_compra', ['div' => 'col s12 input-field', 'label' => 'Data Compra', 'type' => 'text', 'data-type' => 'date']);
                    echo $this->Gus->control('valor_liquido', ['div' => 'col s12 input-field', 'label' => 'Valor Liquido']);
                    echo $this->Gus->control('descontos', ['div' => 'col s12 input-field', 'label' => 'Descontos']);
                    echo $this->Gus->control('valor_total', ['div' => 'col s12 input-field', 'label' => 'Valor Total']);
                    echo $this->Gus->control('comentarios', ['div' => 'col s12 input-field', 'label' => 'Comentarios']);
            echo $this->Gus->selectExtends('pedido_compra_id', $pedidoCompras->toArray(), [
                'div' => 'col s12 input-field select2-field',
                'label' => ['text' => 'PedidoCompra', 'class' => 'active'],
                'controller' => 'pedidoCompras',
            ]);
            echo $this->Gus->selectExtends('forma_pagamento_id', $formaPagamentos->toArray(), [
                'div' => 'col s12 input-field select2-field',
                'label' => ['text' => 'FormaPagamento', 'class' => 'active'],
                'controller' => 'formaPagamentos',
            ]);
            echo $this->Gus->selectExtends('fornecedor_id', $fornecedores->toArray(), [
                'div' => 'col s12 input-field select2-field',
                'label' => ['text' => 'Fornecedor', 'class' => 'active'],
                'controller' => 'fornecedores',
            ]);
    ?>
    <?= $this->Gus->button('Enviar', ['div' => 'input-field col s2 right', 'class' => 'btn right waves-effect waves-light']) ?>
    <?= $this->Gus->end() ?>
    -->
</div>
