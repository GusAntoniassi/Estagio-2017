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
        var linhaTabela = <?php echo 2; ?>;

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
                                    custo: item.custo,
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
                    $(this).siblings('label').addClass('active');
                    console.log(e.params);
                    var dados = e.params.data;
                    if (dados) {
                        var html = '';
                        var foto = (dados.foto ? dados.foto : 'http://via.placeholder.com/45x45')
                        var custo = (dados.custo ? dados.custo : 1);
                        var qtdInicial = 1;

                        html += '<tr class="produto" data-produto-id="' + dados.id + '" data-linha-id="' + linhaTabela + '">';
                        html +=     '<td style="width: 1px; padding-right: 10px;">';
                        html +=         '<input type="hidden" name="compras[itemcompras][' + linhaTabela + '][produto_id]" value="' + dados.id + '" />';
                        html +=         '<a href="#"><img src="' + foto + '" class="circle" /></a>';
                        html +=     '</td>';
                        html +=     '<td class="left-align"><a href="#">' + dados.nome + '</a></td>';
                        html +=     '<td class="center-align">';
                        html +=     '<div class="input-field center-align">';
                        html +=         '<input type="number" name="compras[itemcompras][' + linhaTabela + '][quantidade]" value="' + qtdInicial + '" class="center-align" style="max-width: 75px" id="qtde">';
                        html +=     '</div>';
                        html +=     '</td>';
                        html +=     '<td class="right-align">';
                        html +=         '<div class="input-field right-align">';
                        html +=             '<input type="text" name="compras[itemcompras][' + linhaTabela + '][valor_unitario]" value="' + custo + '" class="right-align" data-type="money" style="max-width: 100px" id="qtde">';
                        html +=         '</div>';
                        html +=     '</td>';
                        html +=     '<td class="right-align">R$ ' + custo + '</td>';
                        html +=     '<td class="center-align" style="width: 1px">';
                        html +=         '<a href="#" class="remover-item"><i class="material-icons">close</i></a>';
                        html +=     '</td>';
                        html += '</tr>';

                        if (dados.possuiLote) {
                            html += '<tr class="lote">';
                            html +=     '<td colspan="5">';
                            html +=         '<div class="input-field input-small col s3">';
                            html +=         '<!-- Apenas na edição -->';
                            html +=         '<input type="hidden" name="compras[itemcompras][0][lotes][0][id]" />';
                            html +=         '<!-- -->';
                            html +=         '<input type="text" id="cod_lote" name="compras[itemcompras][0][lotes][0][num_lote]" />';
                            html +=         '<label for="cod_lote">Código do lote</label>';
                            html +=     '</div>';
                            html +=     '<div class="input-field input-small col s3">';
                            html +=         '<input type="text" id="data_lote" name="compras[itemcompras][0][lotes][0][data_vencimento]" data-type="date" />';
                            html +=         '<label for="data_lote">Data do vencimento</label>';
                            html +=     '</div>';
                            html +=     '</td>';
                            html +=     '<td class="center-align" style="width: 1px">';
                            html +=         '<a href="#" class="adicionar-lote"><i class="material-icons">add</i></a>';
                            html +=     '</td>';
                            html += '</tr>';
                        }

                        $('#tabela-produtos').append(html);
                    }


                    /* Fazer uma tabela com inputs mesmo, sem gravar na sesion nem nada.
                        Quando selecionar, verificar se o produto tem lote ou não, se tiver abrir campos
                        pra digitar a data de validade e o código do lote.

                        Forma de pagamento fazer uma combobox mesmo
                     */
                }
            });

//            $('input.autocomplete').autocomplete({
//                data: {
//                    "Apple": null,
//                    "Microsoft": null,
//                    "Google": 'https://placehold.it/250x250'
//                },
//                limit: 20, // The max amount of results that can be shown at once. Default: Infinity.
//                onAutocomplete: function(val) {
//                    // Callback function when value is autcompleted.
//                },
//                minLength: 1, // The minimum length of the input for the autocomplete to start. Default: 1.
//            });
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
                <!--
                <tr class="produto" data-produto-id="1" data-linha-id="0">
                    <td style="width: 1px; padding-right: 10px;">
                        <input type="hidden" name="compras[itemcompras][0][produto_id]" value="1" />
                        <a href="#"><img src="http://www.placecage.com/g/45/45" class="circle" /></a>
                    </td>
                    <td class="left-align"><a href="#">Filé de pacu</a></td>
                    <td class="center-align">
                        <div class="input-field center-align">
                            <input type="number" name="compras[itemcompras][0][quantidade]" value="3"
                                   class="center-align" style="max-width: 75px" id="qtde">
                        </div>
                    </td>
                    <td class="right-align">
                        <div class="input-field right-align">
                            <input type="text" name="compras[itemcompras][0][valor_unitario]" value="500,00"
                                   class="right-align" data-type="money" style="max-width: 100px" id="qtde">
                        </div>
                    </td>
                    <td class="right-align">
                        R$ 1.500,00
                    </td>
                    <td class="center-align" style="width: 1px">
                        <a href="#" class="remover-item" data-row-id="0"><i class="material-icons">close</i></a>
                    </td>
                </tr>
                <tr class="lote">
                    <td colspan="5">
                        <div class="input-field input-small col s3">
                            <?php // Apenas na edição ?>
                            <input type="hidden" name="compras[itemcompras][0][lotes][0][id]" />

                            <input type="text" id="cod_lote" name="compras[itemcompras][0][lotes][0][num_lote]" />
                            <label for="cod_lote">Código do lote</label>
                        </div>
                        <div class="input-field input-small col s3">
                            <input type="text" id="data_lote" name="compras[itemcompras][0][lotes][0][data_vencimento]" data-type="date" />
                            <label for="data_lote">Data do vencimento</label>
                        </div>
                    </td>
                    <td class="center-align" style="width: 1px">
                        <a href="#" class="adicionar-lote"><i class="material-icons">add</i></a>
                    </td>
                </tr>
                <tr class="produto" data-produto-id="1" data-linha-id="0">
                    <td style="width: 1px; padding-right: 10px;">
                        <a href="#"><img src="http://www.placecage.com/45/45" class="circle" /></a>
                    </td>
                    <td class="left-align"><a href="#">Filé de sardinha</a></td>
                    <td class="center-align">
                        <div class="input-field center-align">
                            <input type="number" name="compras[itemcompras][1][quantidade]" value="3"
                                   class="center-align" style="max-width: 75px" id="qtde">
                        </div>
                    </td>
                    <td class="right-align">
                        <div class="input-field right-align">
                            <input type="text" name="compras[itemcompras][1][valor_unitario]" value="500,00"
                                   class="right-align" data-type="money" style="max-width: 100px" id="qtde">
                        </div>
                    </td>
                    <td class="right-align">R$ 1.500,00</td>
                    <td class="center-align" style="width: 1px">
                        <a href="#" class="remover-item"><i class="material-icons">close</i></a>
                    </td>
                </tr>
                -->
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"></td>
                    <td class="right-align"><strong>Valor líquido</strong></td>
                    <td class="right-align">R$ 1.500,00</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td class="right-align"><strong>Descontos</strong></td>
                    <td class="right-align">R$ 500,00</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td class="right-align"><strong>Valor total</strong></td>
                    <td class="right-align">R$ 1.000,00</td>
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
