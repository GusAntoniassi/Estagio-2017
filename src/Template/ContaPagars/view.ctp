<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="contaPagars view card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Visualizar ContaPagar'); ?>
    <table class="bordered highlight">
                                <tr>
            <th scope="row"><?= __('Descricao') ?></th>
            <td><?= h($contaPagar->descricao) ?></td>
        </tr>
                                <tr>
            <th scope="row"><?= __('Fornecedor') ?></th>
            <td><?= $contaPagar->has('fornecedor') ? $this->Html->link($contaPagar->fornecedor->id, ['controller' => 'Fornecedores', 'action' => 'view', $contaPagar->fornecedor->id]) : '' ?></td>
        </tr>
                                <tr>
            <th scope="row"><?= __('Compra') ?></th>
            <td><?= $contaPagar->has('compra') ? $this->Html->link($contaPagar->compra->id, ['controller' => 'Compras', 'action' => 'view', $contaPagar->compra->id]) : '' ?></td>
        </tr>
                                <tr>
            <th scope="row"><?= __('Forma Pagamento') ?></th>
            <td><?= $contaPagar->has('forma_pagamento') ? $this->Html->link($contaPagar->forma_pagamento->id, ['controller' => 'FormaPagamentos', 'action' => 'view', $contaPagar->forma_pagamento->id]) : '' ?></td>
        </tr>
                            </table>
</div>