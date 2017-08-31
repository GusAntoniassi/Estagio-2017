<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="compras view card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Visualizar Compra'); ?>
    <table class="bordered highlight">
                                <tr>
            <th scope="row"><?= __('Pedido Compra') ?></th>
            <td><?= $compra->has('pedido_compra') ? $this->Html->link($compra->pedido_compra->id, ['controller' => 'PedidoCompras', 'action' => 'view', $compra->pedido_compra->id]) : '' ?></td>
        </tr>
                                <tr>
            <th scope="row"><?= __('Forma Pagamento') ?></th>
            <td><?= $compra->has('forma_pagamento') ? $this->Html->link($compra->forma_pagamento->id, ['controller' => 'FormaPagamentos', 'action' => 'view', $compra->forma_pagamento->id]) : '' ?></td>
        </tr>
                                <tr>
            <th scope="row"><?= __('Fornecedor') ?></th>
            <td><?= $compra->has('fornecedor') ? $this->Html->link($compra->fornecedor->id, ['controller' => 'Fornecedores', 'action' => 'view', $compra->fornecedor->id]) : '' ?></td>
        </tr>
                            </table>
</div>