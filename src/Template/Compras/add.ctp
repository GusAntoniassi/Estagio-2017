<?php
/**
  * @var \App\View\AppView $this
  */
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
    <div class="input-field col s2">
        <input type="text" id="data" data-type="date" value="<?= date('d/m/Y'); ?>">
        <label for="data">Data da compra</label>
    </div>
    <div class="clearfix"></div>

    <div class="input-field col s5">
        <input type="text" id="autocomplete-input" class="autocomplete">
        <label for="autocomplete-input">Produto</label>
    </div>
    <script>
        $(document).ready(function() {
            $('input.autocomplete').autocomplete({
                data: {
                    "Apple": null,
                    "Microsoft": null,
                    "Google": 'https://placehold.it/250x250'
                },
                limit: 20, // The max amount of results that can be shown at once. Default: Infinity.
                onAutocomplete: function(val) {
                    // Callback function when value is autcompleted.
                },
                minLength: 1, // The minimum length of the input for the autocomplete to start. Default: 1.
            });
        });
    </script>
    <div class="clearfix"></div>
    <br/>
    <div class="col s12">
        <table class="bordered responsive-table">
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
            <tr>
                <td style="width: 1px; padding-right: 10px;">
                    <a href="#"><img src="http://www.placecage.com/g/45/45" class="circle" /></a>
                </td>
                <td class="left-align"><a href="#">Filé de pacu</a></td>
                <td class="center-align">3</td>
                <td class="right-align">R$ 500,00</td>
                <td class="right-align">R$ 1.500,00</td>
                <td class="center-align" style="width: 1px">
                    <a href="#" class="remover-item"><i class="material-icons">close</i></a>
                </td>
            </tr>
            <tr>
                <td style="width: 1px; padding-right: 10px;">
                    <a href="#"><img src="http://www.placecage.com/45/45" class="circle" /></a>
                </td>
                <td class="left-align"><a href="#">Filé de sardinha</a></td>
                <td class="center-align">3</td>
                <td class="right-align">R$ 500,00</td>
                <td class="right-align">R$ 1.500,00</td>
                <td class="center-align" style="width: 1px">
                    <a href="#" class="remover-item"><i class="material-icons">close</i></a>
                </td>
            </tr>
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
