<?php
use Cake\Routing\Router;

/**
 * @var \App\View\AppView $this
 */
?>
    <div class="compras index list row card-panel">
        <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
        <?php $this->assign('title', 'Compra'); ?>
        <div class="row filtros">
            <div class="col s12">
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header"><?= $this->Gus->materialIcon('filter_list'); ?> Filtros</div>
                        <div class="collapsible-body">
                            <div class="row">
                                <?= $this->Gus->create(); ?>
                                <?= $this->Gus->control('id', ['div' => 'col s2 m1 l1', 'label' => 'ID']); ?>
                                <?= $this->Gus->control('status', ['type' => 'select', 'data-material-select', 'div' => 'col s10 m2 l2', 'label' => 'Status', 'options' => $this->Gus->getStatusOptionsCompra()]); ?>
                                <?= $this->Gus->control('forma_pagamento_id', ['div' => 'col s6 m3 l3', 'label' => 'Forma de pagamento', 'data-material-select']); ?>
                                <?= $this->Gus->control('fornecedor_id', ['div' => 'col s6 m4 l4', 'label' => 'Fornecedor', 'data-material-select']); ?>
                                <?= $this->Gus->button('<i class="material-icons">filter_list</i>', ['div' => 'input-field col s12 m2 l2 right submit', 'type' => 'submit', 'class' => 'btn waves-effect waves-light']); ?>
                                <?= $this->Gus->end(); ?>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <?= $this->Gus->create('Compra', [
            'url' => ['controller' => 'compras', 'action' => 'delete'],
            'method' => 'post',
            'class' => 'hide',
            'id' => 'form-delete',
        ]); ?>
        <?php // <input name="ids[]" type="hidden" value="1" /> ?>
        <?= $this->Gus->end(); ?>

        <table class="responsive-table index highlight">
            <thead>
            <tr>
                <th scope="col">
                    <input type="checkbox" class="filled-in" id="check-all"/><label for="check-all">&nbsp;</label>
                </th>
                <th scope="col"><?= $this->Paginator->sort('id', 'ID') ?></th>
                <th scope="col"><?= $this->Paginator->sort('data_compra', 'Data da compra') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fornecedor_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('valor_total', 'Valor total') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('forma_pagamento_id', 'Forma de pagamento') ?></th>
                <th scope="col" class="actions"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($compras as $compra): ?>
                <tr>
                    <td><input type="checkbox" id="check<?= $compra->id ?>" class="filled-in"
                               name="data[ids][<?= $compra->id ?>]" value="<?= $compra->id ?>"/><label
                                for="check<?= $compra->id ?>">&nbsp;</label></td>
                    <td><?= $this->Number->format($compra->id) ?></td>
                    <td><?= h($compra->data_compra) ?></td>
                    <td><?= $compra->has('fornecedor') ? $this->Html->link($compra->fornecedor->pessoa->nome_exibicao, ['controller' => 'Fornecedores', 'action' => 'view', $compra->fornecedor->id]) : '' ?></td>
                    <td><?= $this->Number->currency($compra->valor_total, 'BRL') ?></td>
                    <td><?= $this->Gus->formataStatusCompra($compra->status) ?></td>
                    <td><?= $compra->has('forma_pagamento') ? $this->Html->link($compra->forma_pagamento->displayField, ['controller' => 'FormaPagamentos', 'action' => 'view', $compra->forma_pagamento->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link($this->Gus->materialIcon('edit'), ['action' => 'edit', $compra->id], ['escape' => false, 'class' => 'btn btn-floating btn-sm waves-effect waves-light edit']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <div class="paginator">
            <ul class="pagination">
                <?= $this->Gus->paginatorControls(); ?>
            </ul>
            <p><?= $this->Paginator->counter() ?></p>
        </div>
    </div>
    <script>
        var addLink = '<?= Router::url(['controller' => 'compras', 'action' => 'add'], true); ?>';
        var editLink = '<?= Router::url(['controller' => 'compras', 'action' => 'edit', '--id--'], true); ?>';
        var viewLink = '<?= Router::url(['controller' => 'compras', 'action' => 'view', '--id--'], true); ?>';
        var deleteLink = '<?= Router::url(['controller' => 'compras', 'action' => 'delete'], true); ?>';
    </script>
<?= $this->element('botao_fixo', ['controller' => $this->request->getParam('controller')]) ?>