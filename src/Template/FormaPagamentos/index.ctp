<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\FormaPagamento[]|\Cake\Collection\CollectionInterface $formaPagamentos
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Forma Pagamento'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Compras'), ['controller' => 'Compras', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Compra'), ['controller' => 'Compras', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Conta Pagars'), ['controller' => 'ContaPagars', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Conta Pagar'), ['controller' => 'ContaPagars', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Conta Recebers'), ['controller' => 'ContaRecebers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Conta Receber'), ['controller' => 'ContaRecebers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Pedido Compras'), ['controller' => 'PedidoCompras', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Pedido Compra'), ['controller' => 'PedidoCompras', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="formaPagamentos index large-9 medium-8 columns content">
    <h3><?= __('Forma Pagamentos') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                <th scope="col"><?= $this->Paginator->sort('num_parcelas') ?></th>
                <th scope="col"><?= $this->Paginator->sort('dias_carencia_primeira_parcela') ?></th>
                <th scope="col"><?= $this->Paginator->sort('entrada') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($formaPagamentos as $formaPagamento): ?>
            <tr>
                <td><?= $this->Number->format($formaPagamento->id) ?></td>
                <td><?= h($formaPagamento->nome) ?></td>
                <td><?= $this->Number->format($formaPagamento->num_parcelas) ?></td>
                <td><?= $this->Number->format($formaPagamento->dias_carencia_primeira_parcela) ?></td>
                <td><?= $this->Number->format($formaPagamento->entrada) ?></td>
                <td><?= h($formaPagamento->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $formaPagamento->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $formaPagamento->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $formaPagamento->id], ['confirm' => __('Are you sure you want to delete # {0}?', $formaPagamento->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
