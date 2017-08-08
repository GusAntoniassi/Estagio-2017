<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\FormaPagamento $formaPagamento
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Forma Pagamento'), ['action' => 'edit', $formaPagamento->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Forma Pagamento'), ['action' => 'delete', $formaPagamento->id], ['confirm' => __('Are you sure you want to delete # {0}?', $formaPagamento->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Forma Pagamentos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Forma Pagamento'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Compras'), ['controller' => 'Compras', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Compra'), ['controller' => 'Compras', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Conta Pagars'), ['controller' => 'ContaPagars', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Conta Pagar'), ['controller' => 'ContaPagars', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Conta Recebers'), ['controller' => 'ContaRecebers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Conta Receber'), ['controller' => 'ContaRecebers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Pedido Compras'), ['controller' => 'PedidoCompras', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pedido Compra'), ['controller' => 'PedidoCompras', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="formaPagamentos view large-9 medium-8 columns content">
    <h3><?= h($formaPagamento->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nome') ?></th>
            <td><?= h($formaPagamento->nome) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($formaPagamento->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Num Parcelas') ?></th>
            <td><?= $this->Number->format($formaPagamento->num_parcelas) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Dias Carencia Primeira Parcela') ?></th>
            <td><?= $this->Number->format($formaPagamento->dias_carencia_primeira_parcela) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Entrada') ?></th>
            <td><?= $this->Number->format($formaPagamento->entrada) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $formaPagamento->status ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Compras') ?></h4>
        <?php if (!empty($formaPagamento->compras)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Data Compra') ?></th>
                <th scope="col"><?= __('Valor Liquido') ?></th>
                <th scope="col"><?= __('Descontos') ?></th>
                <th scope="col"><?= __('Valor Total') ?></th>
                <th scope="col"><?= __('Comentarios') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('Pedido Compra Id') ?></th>
                <th scope="col"><?= __('Forma Pagamento Id') ?></th>
                <th scope="col"><?= __('Fornecedor Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($formaPagamento->compras as $compras): ?>
            <tr>
                <td><?= h($compras->id) ?></td>
                <td><?= h($compras->data_compra) ?></td>
                <td><?= h($compras->valor_liquido) ?></td>
                <td><?= h($compras->descontos) ?></td>
                <td><?= h($compras->valor_total) ?></td>
                <td><?= h($compras->comentarios) ?></td>
                <td><?= h($compras->status) ?></td>
                <td><?= h($compras->pedido_compra_id) ?></td>
                <td><?= h($compras->forma_pagamento_id) ?></td>
                <td><?= h($compras->fornecedor_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Compras', 'action' => 'view', $compras->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Compras', 'action' => 'edit', $compras->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Compras', 'action' => 'delete', $compras->id], ['confirm' => __('Are you sure you want to delete # {0}?', $compras->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Conta Pagars') ?></h4>
        <?php if (!empty($formaPagamento->conta_pagars)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Descricao') ?></th>
                <th scope="col"><?= __('Valor') ?></th>
                <th scope="col"><?= __('Data Cadastro') ?></th>
                <th scope="col"><?= __('Data Pagamento') ?></th>
                <th scope="col"><?= __('Pago') ?></th>
                <th scope="col"><?= __('Num Parcelas') ?></th>
                <th scope="col"><?= __('Comentarios') ?></th>
                <th scope="col"><?= __('Fornecedor Id') ?></th>
                <th scope="col"><?= __('Compra Id') ?></th>
                <th scope="col"><?= __('Forma Pagamento Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($formaPagamento->conta_pagars as $contaPagars): ?>
            <tr>
                <td><?= h($contaPagars->id) ?></td>
                <td><?= h($contaPagars->descricao) ?></td>
                <td><?= h($contaPagars->valor) ?></td>
                <td><?= h($contaPagars->data_cadastro) ?></td>
                <td><?= h($contaPagars->data_pagamento) ?></td>
                <td><?= h($contaPagars->pago) ?></td>
                <td><?= h($contaPagars->num_parcelas) ?></td>
                <td><?= h($contaPagars->comentarios) ?></td>
                <td><?= h($contaPagars->fornecedor_id) ?></td>
                <td><?= h($contaPagars->compra_id) ?></td>
                <td><?= h($contaPagars->forma_pagamento_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ContaPagars', 'action' => 'view', $contaPagars->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ContaPagars', 'action' => 'edit', $contaPagars->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ContaPagars', 'action' => 'delete', $contaPagars->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contaPagars->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Conta Recebers') ?></h4>
        <?php if (!empty($formaPagamento->conta_recebers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Descricao') ?></th>
                <th scope="col"><?= __('Valor') ?></th>
                <th scope="col"><?= __('Data Cadastro') ?></th>
                <th scope="col"><?= __('Data Recebimento') ?></th>
                <th scope="col"><?= __('Recebido') ?></th>
                <th scope="col"><?= __('Comentarios') ?></th>
                <th scope="col"><?= __('Pessoa Id') ?></th>
                <th scope="col"><?= __('Comanda Id') ?></th>
                <th scope="col"><?= __('Forma Pagamento Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($formaPagamento->conta_recebers as $contaRecebers): ?>
            <tr>
                <td><?= h($contaRecebers->id) ?></td>
                <td><?= h($contaRecebers->descricao) ?></td>
                <td><?= h($contaRecebers->valor) ?></td>
                <td><?= h($contaRecebers->data_cadastro) ?></td>
                <td><?= h($contaRecebers->data_recebimento) ?></td>
                <td><?= h($contaRecebers->recebido) ?></td>
                <td><?= h($contaRecebers->comentarios) ?></td>
                <td><?= h($contaRecebers->pessoa_id) ?></td>
                <td><?= h($contaRecebers->comanda_id) ?></td>
                <td><?= h($contaRecebers->forma_pagamento_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ContaRecebers', 'action' => 'view', $contaRecebers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ContaRecebers', 'action' => 'edit', $contaRecebers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ContaRecebers', 'action' => 'delete', $contaRecebers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contaRecebers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Pedido Compras') ?></h4>
        <?php if (!empty($formaPagamento->pedido_compras)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Data Pedido') ?></th>
                <th scope="col"><?= __('Data Entrega') ?></th>
                <th scope="col"><?= __('Valor Liquido') ?></th>
                <th scope="col"><?= __('Descontos') ?></th>
                <th scope="col"><?= __('Valor Total') ?></th>
                <th scope="col"><?= __('Comentarios') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('Orcamento Id') ?></th>
                <th scope="col"><?= __('Forma Pagamento Id') ?></th>
                <th scope="col"><?= __('Fornecedor Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($formaPagamento->pedido_compras as $pedidoCompras): ?>
            <tr>
                <td><?= h($pedidoCompras->id) ?></td>
                <td><?= h($pedidoCompras->data_pedido) ?></td>
                <td><?= h($pedidoCompras->data_entrega) ?></td>
                <td><?= h($pedidoCompras->valor_liquido) ?></td>
                <td><?= h($pedidoCompras->descontos) ?></td>
                <td><?= h($pedidoCompras->valor_total) ?></td>
                <td><?= h($pedidoCompras->comentarios) ?></td>
                <td><?= h($pedidoCompras->status) ?></td>
                <td><?= h($pedidoCompras->orcamento_id) ?></td>
                <td><?= h($pedidoCompras->forma_pagamento_id) ?></td>
                <td><?= h($pedidoCompras->fornecedor_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'PedidoCompras', 'action' => 'view', $pedidoCompras->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'PedidoCompras', 'action' => 'edit', $pedidoCompras->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'PedidoCompras', 'action' => 'delete', $pedidoCompras->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pedidoCompras->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
