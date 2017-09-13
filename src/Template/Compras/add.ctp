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
        <span class="input-group-btn"><a class="btn btn-small waves-effect waves-light refresh" data-href="http://localhost/estagio2017/fornecedores/get-all" onclick="return refreshSelect(event.target || event.srcElement);"><i class="material-icons">autorenew</i></a><a class="btn btn-small waves-effect waves-light edit" href="http://localhost/estagio2017/fornecedores/edit" onclick="return extendEdit(event);"><i class="material-icons">edit</i></a><a class="btn btn-small waves-effect waves-light add" href="http://localhost/estagio2017/fornecedores/add" onclick="return extendAdd(event);"><i class="material-icons">add</i></a></span>
    </div>
    <script>
//        var templateLinhaProduto = '';
//        templateLinhaProduto += '<tr class="produto" data-produto-id="{{idProduto}}" data-linha-id="{{linhaTabela}}">';
//        templateLinhaProduto +=     '<td style="width: 1px; padding-right: 10px;">';
//        templateLinhaProduto +=         '<input type="hidden" name="compras[itemcompras][{{linhaTabela}}][produto_id]" value="{{idProduto}}" />';
//        templateLinhaProduto +=         '<a href="#"><img src="{{fotoProduto}}" class="circle" /></a>';
//        templateLinhaProduto +=     '</td>';
//        templateLinhaProduto +=     '<td class="left-align"><a href="#">{{nomeProduto}}</a></td>';
//        templateLinhaProduto +=     '<td class="center-align">';
//        templateLinhaProduto +=     '<div class="input-field center-align">';
//        templateLinhaProduto +=         '<input type="number" name="compras[itemcompras][{{linhaTabela}}][quantidade]" value="{{quantidade}}" class="center-align" style="max-width: 75px">';
//        templateLinhaProduto +=     '</div>';
//        templateLinhaProduto +=     '</td>';
//        templateLinhaProduto +=     '<td class="right-align">';
//        templateLinhaProduto +=         '<div class="input-field right-align">';
//        templateLinhaProduto +=             '<input type="text" name="compras[itemcompras][{{linhaTabela}}][valor_unitario]" value="{{custo}}" class="right-align" data-type="money" style="max-width: 100px">';
//        templateLinhaProduto +=         '</div>';
//        templateLinhaProduto +=     '</td>';
//        templateLinhaProduto +=     '<td class="right-align">R$ {{total}}</td>';
//        templateLinhaProduto +=     '<td class="center-align" style="width: 1px">';
//        templateLinhaProduto +=         '<a href="#" class="remover-item"><i class="material-icons">close</i></a>';
//        templateLinhaProduto +=     '</td>';
//        templateLinhaProduto += '</tr>';

//        var templateLinhaLote = '';
//        templateLinhaLote += '<tr class="lote">';
//        templateLinhaLote +=     '<td colspan="5">';
//        templateLinhaLote +=         '<div class="input-field input-small col s3">';
//        templateLinhaLote +=         '<!-- Apenas na edição -->';
//        templateLinhaLote +=         '<input type="hidden" name="compras[itemcompras][{{linhaTabela}}][lotes][{{linhaTabelaLote}}][id]" />';
//        templateLinhaLote +=         '<!-- -->';
//        templateLinhaLote +=         '<input type="text" id="cod_lote" name="compras[itemcompras][{{linhaTabela}}][lotes][{{linhaTabelaLote}}][num_lote]" value="{{codigoLote}}" />';
//        templateLinhaLote +=         '<label for="cod_lote">Código do lote</label>';
//        templateLinhaLote +=     '</div>';
//        templateLinhaLote +=     '<div class="input-field input-small col s3">';
//        templateLinhaLote +=         '<input type="text" id="data_lote" name="compras[itemcompras][{{linhaTabela}}][lotes][{{linhaTabelaLote}}][data_vencimento]" value="{{vencimentoLote}}" data-type="date" />';
//        templateLinhaLote +=         '<label for="data_lote">Data do vencimento</label>';
//        templateLinhaLote +=     '</div>';
//        templateLinhaLote +=     '</td>';
//        templateLinhaLote +=     '<td class="center-align" style="width: 1px">';
//        templateLinhaLote +=         '<a href="#" class="adicionar-lote"><i class="material-icons">add</i></a>';
//        templateLinhaLote +=     '</td>';
//        templateLinhaLote += '</tr>';

        var linhaTabela = <?php echo 2; ?>;
        var linhaTabelaLote = <?php echo 1; ?>;

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
                }
            }).on('select2:select', function(e) {
                if (e) {
                    // TODO: Trocar linhaTabela por uma variável que soma quantas linhas tem
                    // mesma coisa pro lote
                    $(this).siblings('label').addClass('active');
                    var dados = e.params.data;
                    if (dados) {
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
                                            }
                                            linhaTabelaLote++;
                                        });
                                    }
                                    linhaTabela++;
                                });
                            } else {
                                console.error('Erro ao trazer a linha da tabela para o produto ID ' + dados.id);
                            }
                        });
                    }
                    /* Fazer uma tabela com inputs mesmo, sem gravar na sesion nem nada.
                        Quando selecionar, verificar se o produto tem lote ou não, se tiver abrir campos
                        pra digitar a data de validade e o código do lote.

                        Forma de pagamento fazer uma combobox mesmo
                     */
                }
            });

            $('#tabela-produtos').on('click', '.adicionar-lote', function(e) {
                var $target = $(e.target);
                var linhaTabela
            });
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
                <?php
                    // Apenas na edição
                    /*
                    echo $this->cell('LinhaTabela::produto', [1]);
                    echo $this->cell('LinhaTabela::lote', [1]);
                    echo $this->cell('LinhaTabela::produto', [4, 1, 3, 500]);
                    */
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"></td>
                    <td class="right-align"><strong>Valor líquido</strong></td>
                    <td class="right-align" data-role="valor-liquido">R$ 1.500,00</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td class="right-align"><strong>Descontos</strong></td>
                    <td class="right-align" data-role="descontos">R$ 500,00</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td class="right-align"><strong>Valor total</strong></td>
                    <td class="right-align" data-role="valor-total">R$ 1.000,00</td>
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
