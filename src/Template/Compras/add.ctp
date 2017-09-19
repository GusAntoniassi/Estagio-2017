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
        var urlCellProduto = '<?php echo Router::url(['controller' => 'produtos', 'action' => 'getLinhaTabela']); ?>';
        var urlCellLote = '<?php echo Router::url(['controller' => 'lotes', 'action' => 'getLinhaTabela']); ?>';
    </script>
    <?= $this->Html->script('compra.js'); ?>

    <?= $this->Gus->create($compra, ['class' => 'row']) ?>
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
    <?= $this->Gus->control('data_compra', [
        'div' => 'col s3 input-field',
        'label' => 'Data da compra',
        'type' => 'text',
        'data-type' => 'date',
        'value' => date('d/m/Y') // Data atual
    ]); ?>

    <?= $this->Gus->selectExtends('forma_pagamento_id', $formaPagamentos->toArray(), [
        'div' => 'col s4 input-field select2-field',
        'label' => ['text' => 'Forma de pagamento', 'class' => 'active'],
        'controller' => 'formaPagamentos',
    ]); ?>
    <?= $this->Gus->selectAjaxExtends('produto_id', [
        'div' => 'input-field input-group col s6',
        'attributes' => [
            'class' => 'browser-default select2ajax',
            'type' => 'select',
            'placeholder' => 'Clique para buscar...'
        ],
        'label' => ['text' => 'Produto', 'class' => 'active'],
        'controller' => 'produtos',
        'ajax' => true
    ]); ?>

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
                    <td class="right-align valor-liquido"><?php // Atualizado por javascript ?></td>
                    <td><?= $this->Gus->control('valor_liquido', ['type' => 'hidden']); ?></td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td class="right-align"><strong>Descontos (R$)</strong></td>
                    <td class="right-align input-small descontos"><?= $this->Gus->control('descontos', ['div' => false, 'label' => false, 'class' => 'right-align', 'type' => 'text', 'data-type' => 'money', 'style' => 'width: 100px; margin-bottom: 0;']);
                        ?></td>
                    <td><?= $this->Gus->control('descontos', ['type' => 'hidden']); ?></td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td class="right-align"><strong>Valor total</strong></td>
                    <td class="right-align valor-total"><?php // Atualizado por javascript ?></td>
                    <td><?= $this->Gus->control('valor_total', ['type' => 'hidden']); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="input-field col s12">
        <textarea id="textarea1" class="materialize-textarea"></textarea>
        <label for="textarea1">Comentários</label>
    </div>

    <!--
    <?php
            echo $this->Gus->control('status', ['div' => 'col s12 input-field', 'label' => 'Status', 'checked' => 'checked']);
            echo $this->Gus->control('valor_liquido', ['div' => 'col s12 input-field', 'label' => 'Valor Liquido']);
            echo $this->Gus->control('descontos', ['div' => 'col s12 input-field', 'label' => 'Descontos']);
            echo $this->Gus->control('valor_total', ['div' => 'col s12 input-field', 'label' => 'Valor Total']);
            echo $this->Gus->control('comentarios', ['div' => 'col s12 input-field', 'label' => 'Comentarios']);
            echo $this->Gus->selectExtends('pedido_compra_id', $pedidoCompras->toArray(), [
                'div' => 'col s12 input-field select2-field',
                'label' => ['text' => 'PedidoCompra', 'class' => 'active'],
                'controller' => 'pedidoCompras',
            ]);
            echo $this->Gus->selectExtends('fornecedor_id', $fornecedores->toArray(), [
                'div' => 'col s12 input-field select2-field',
                'label' => ['text' => 'Fornecedor', 'class' => 'active'],
                'controller' => 'fornecedores',
            ]);
    ?>
    -->

    <script>
        fornecedorAutocomplete('<?= Router::url(['controller' => 'fornecedores', 'action' => 'select2ajax']); ?>');
        produtoAutocompleteCompra('<?= Router::url(['controller' => 'produtos', 'action' => 'getProdutosCompraveis']); ?>');
    </script>

    <?= $this->Gus->button('Enviar', ['div' => 'input-field col s2 right', 'class' => 'btn right waves-effect waves-light']) ?>
    <?= $this->Gus->end() ?>
</div>
