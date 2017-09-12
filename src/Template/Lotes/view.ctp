<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="lotes view card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Visualizar Lote'); ?>
    <table class="bordered highlight">
        <tr>
            <th scope="row"><?= __('Número do lote') ?></th>
            <td><?= h($lote->num_lote) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantidade em estoque') ?></th>
            <td><?= $this->Number->format($lote->qtde_estoque) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Data de vencimento') ?></th>
            <td><?= h($lote->data_vencimento) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Produto') ?></th>
            <td><?= $lote->has('produto') ? $this->Html->link($lote->produto->nome, ['controller' => 'Produtos', 'action' => 'view', $lote->produto->id]) : '' ?></td>
        </tr>
    </table>
</div>