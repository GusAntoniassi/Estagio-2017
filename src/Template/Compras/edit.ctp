<?php
/**
  * @var \App\View\AppView $this
  */
use Cake\Routing\Router;
?>
<div class="compras form edit compra-disabled row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Edição de Compra'); ?>

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
        'value' => $compra->status,
        ($compra->status ? 'disabled' : ''),
    ]); ?>
    <div class="clearfix"></div>
    <br/>
    <?= $this->Gus->control('fornecedor',
        [
            'div' => 'col s4 input-field',
            'class' => 'browser-default select2ajax',
            'disabled',
            'type' => 'text',
            'value' => $fornecedor,
            'label' => ['text' => 'Fornecedor', 'class' => 'active'],
        ]
    );
    ?>
    <?= $this->Gus->control('data_compra', [
        'div' => 'col s2 input-field',
        'label' => 'Data da compra',
        'disabled',
        'type' => 'text',
        'data-type' => 'date',
        'value' => date('d/m/Y') // Data atual
    ]); ?>

    <?= $this->Gus->control('forma_pagamento_id', [
        'div' => 'col s3 input-field select2-field',
        'data-material-select',
        'type' => 'select',
        'disabled',
        'label' => ['text' => 'Forma de pagamento', 'class' => 'active'],
    ]); ?>
    <?= $this->Gus->control('entrada', [
        'div' => 'col s3 input-field',
        'label' => 'Entrada (R$)',
        'type' => 'text',
        'disabled',
        'data-type' => 'money',
        'value' => $this->Number->format($compra->entrada, ['places' => 2])
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
            <tfoot>
            <tr>
                <td colspan="3"></td>
                <td class="right-align"><strong>Valor líquido</strong></td>
                <td class="right-align valor-liquido"><?= $this->Number->currency($compra->valor_liquido, 'BRL'); ?></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td class="right-align"><strong>Descontos</strong></td>
                <td class="right-align input-small descontos"><?= $this->Number->currency($compra->descontos, 'BRL'); ?></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td class="right-align"><strong>Valor total</strong></td>
                <td class="right-align valor-total"><?=  $this->Number->currency($compra->valor_total, 'BRL'); ?></td>
                <td></td>
            </tr>
            </tfoot>
        </table>
    </div>
    <?= $this->Gus->control('comentarios', ['div' => 'col s12 input-field', 'label' => 'Comentários']); ?>
    <?= $this->Gus->button('Enviar', ['div' => 'input-field col s2 right', 'class' => 'btn right waves-effect waves-light']) ?>
    <?= $this->Gus->end() ?>
</div>