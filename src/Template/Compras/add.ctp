<?php
/**
  * @var \App\View\AppView $this
  */
use Cake\Routing\Router;
?>
<div class="compras form add row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Cadastro de Compra'); ?>

    <script type="text/javascript">
        var urlProdutoAutocomplete = '<?= Router::url(['controller' => 'produtos', 'action' => 'getProdutosCompraveis']); ?>';
        var urlCellProduto = '<?php echo Router::url(['controller' => 'produtos', 'action' => 'getLinhaTabela']); ?>';
        var urlCellLote = '<?php echo Router::url(['controller' => 'lotes', 'action' => 'getLinhaTabela']); ?>';
    </script>
    <?= $this->Html->script('compra.js'); ?>

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
    <?= $this->Gus->selectAjaxExtends('fornecedor_id',
        [
            'div' => 'col s5 input-field',
            'attributes' => [
                'class' => 'browser-default select2ajax',
                'type' => 'select',
                'placeholder' => 'Digite para buscar...'
            ],
            'label' => ['text' => 'Fornecedor', 'class' => 'active'],
            'controller' => 'fornecedores',
            'ajax' => true
        ]
    );

    ?>
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

    <script>
        fornecedorAutocomplete('<?= Router::url(['controller' => 'fornecedores', 'action' => 'select2ajax']); ?>');
    </script>
</div>
