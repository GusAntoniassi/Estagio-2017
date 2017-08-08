<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Forma Pagamentos'), ['action' => 'index']) ?></li>
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
<div class="formaPagamentos form large-9 medium-8 columns content">
    <?= $this->Form->create($formaPagamento) ?>
    <fieldset>
        <legend><?= __('Add Forma Pagamento') ?></legend>
        <?php
            echo $this->Form->control('nome');
            echo $this->Form->control('num_parcelas');
            echo $this->Form->control('dias_carencia_primeira_parcela');
            echo $this->Form->control('entrada');
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
