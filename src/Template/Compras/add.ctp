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
        'options' => ['0' => 'Compra aberta', '1' => 'Compra fechada'],
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
        'div' => 'col s2 input-field',
        'label' => 'Data da compra',
        'type' => 'text',
        'data-type' => 'date',
//        'value' => (!empty($compra->get('data_compra')) ? $compra->get('data_compra') : date('d/m/Y')) // Data atual
    ]); ?>

    <?= $this->Gus->selectExtends('forma_pagamento_id', $formaPagamentos->toArray(), [
        'div' => 'col s5 input-field select2-field',
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
    <?= $this->Gus->control('entrada', [
        'div' => 'col s4 input-field',
        'label' => 'Entrada (R$)',
        'type' => 'text',
        'data-type' => 'money'
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
                <?php if (empty($compra->item_compras)) { ?>
                    <tr class="sem-produtos"><td colspan="100%">Nenhum produto selecionado!</td></tr>
                <?php } else {
                    foreach ($compra->item_compras as $linhaTabela => $itemCompra) {
                        echo $this->cell('LinhaTabela::produto', [
                            $itemCompra->produto,        // produto
                            $linhaTabela,                // linhaTabela
                            $itemCompra->quantidade,     // quantidade
                            $itemCompra->valor_unitario, // custo
                        ]);
                        if (!empty($itemCompra->lote_compras)) {
                            foreach ($itemCompra->lote_compras as $linhaTabelaLote => $loteCompra) {
                                echo $this->cell('LinhaTabela::lote', [
                                    $loteCompra->lote, // lote
                                    $linhaTabela, // linhaTabela
                                    $linhaTabelaLote, // linhaTabelaLote
                                    $itemCompra->produto->id, // produtoId
                                ]);
                            }
                        }
                    }
                }
                ?>
            </tbody>
            <tfoot <?= (empty($compra->item_compras) ? 'class="invisible"' : ''); ?>>
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
    <?= $this->Gus->control('comentarios', ['div' => 'col s12 input-field', 'label' => 'Comentários']); ?>
    <?= $this->Gus->button('Enviar', ['div' => 'input-field col s2 right', 'class' => 'btn right waves-effect waves-light']) ?>
    <?= $this->Gus->end() ?>

    <script>
        fornecedorAutocomplete('<?= Router::url(['controller' => 'fornecedores', 'action' => 'select2ajax']); ?>');
        produtoAutocompleteCompra('<?= Router::url(['controller' => 'produtos', 'action' => 'getProdutosCompraveis']); ?>');
    </script>

</div>
