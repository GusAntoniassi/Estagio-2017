<?php
use Cake\Routing\Router;
/**
  * @var \App\View\AppView $this
  */
?>
<div class="contaPagars index list row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'ContaPagar'); ?>
    <div class="row filtros">
        <div class="col s12">
            <ul class="collapsible" data-collapsible="accordion">
                <li>
                    <div class="collapsible-header"><?= $this->Gus->materialIcon('filter_list'); ?> Filtros</div>
                    <div class="collapsible-body">
                        <div class="row">
                            <?= $this->Gus->create(); ?>
                                                                                    <?= $this->Gus->control('id', ['div' => 'col s2 m1 l1', 'label' => 'Id']); ?>
                                                                                                                <?= $this->Gus->control('descricao', ['div' => 'col s2 m1 l1', 'label' => 'Descricao']); ?>
                                                                                                                <?= $this->Gus->control('valor', ['div' => 'col s2 m1 l1', 'label' => 'Valor']); ?>
                                                                                                                <?= $this->Gus->control('data_cadastro', ['div' => 'col s2 m1 l1', 'label' => 'Data Cadastro']); ?>
                                                                                                                <?= $this->Gus->control('data_pagamento', ['div' => 'col s2 m1 l1', 'label' => 'Data Pagamento']); ?>
                                                                                                                <?= $this->Gus->control('pago', ['div' => 'col s2 m1 l1', 'label' => 'Pago']); ?>
                                                                                                                <?= $this->Gus->control('num_parcelas', ['div' => 'col s2 m1 l1', 'label' => 'Num Parcelas']); ?>
                                                                                                                <?= $this->Gus->control('fornecedor_id', ['div' => 'col s2 m1 l1', 'label' => 'Fornecedor Id']); ?>
                                                                                                                <?= $this->Gus->control('compra_id', ['div' => 'col s2 m1 l1', 'label' => 'Compra Id']); ?>
                                                                                                                <?= $this->Gus->control('forma_pagamento_id', ['div' => 'col s2 m1 l1', 'label' => 'Forma Pagamento Id']); ?>
                                                                                    <?= $this->Gus->control('Filtrar', ['div' => 'col s12 m2 l2 right', 'type' => 'submit', 'class' => 'btn waves-effect waves-light']); ?>
                            <?= $this->Gus->end(); ?>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <?= $this->Gus->create('ContaPagar', [
        'url' => ['controller' => 'contaPagars', 'action' => 'delete'],
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
                <input type="checkbox" class="filled-in" id="check-all" /><label for="check-all">&nbsp;</label>
            </th>
                        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('descricao') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('valor') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('data_cadastro') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('data_pagamento') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('pago') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('num_parcelas') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('fornecedor_id') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('compra_id') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('forma_pagamento_id') ?></th>
                        <th scope="col" class="actions"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($contaPagars as $contaPagar): ?>
            <tr>
                <td><input type="checkbox" id="check<?= $contaPagar->id ?>" class="filled-in" name="data[ids][<?= $contaPagar->id ?>]" value="<?= $contaPagar->id ?>" /><label for="check<?= $contaPagar->id ?>">&nbsp;</label></td>
                <td><?= $this->Number->format($contaPagar->id) ?></td>
                <td><?= h($contaPagar->descricao) ?></td>
                <td><input type="checkbox" id="check<?= $contaPagar->valor ?>" class="filled-in" name="data[ids][<?= $contaPagar->valor ?>]" value="<?= $contaPagar->valor ?>" /><label for="check<?= $contaPagar->valor ?>">&nbsp;</label></td>
                <td><?= $this->Number->format($contaPagar->valor) ?></td>
                <td><?= h($contaPagar->data_cadastro) ?></td>
                <td><?= h($contaPagar->data_pagamento) ?></td>
                <td><?= $this->Gus->formataStatus($contaPagar->pago) ?></td>
                <td><input type="checkbox" id="check<?= $contaPagar->num_parcelas ?>" class="filled-in" name="data[ids][<?= $contaPagar->num_parcelas ?>]" value="<?= $contaPagar->num_parcelas ?>" /><label for="check<?= $contaPagar->num_parcelas ?>">&nbsp;</label></td>
                <td><?= $this->Number->format($contaPagar->num_parcelas) ?></td>
                <td><?= $contaPagar->has('fornecedor') ? $this->Html->link($contaPagar->fornecedor->displayField, ['controller' => 'Fornecedores', 'action' => 'view', $contaPagar->fornecedor->id]) : '' ?></td>
                <td><?= $contaPagar->has('compra') ? $this->Html->link($contaPagar->compra->displayField, ['controller' => 'Compras', 'action' => 'view', $contaPagar->compra->id]) : '' ?></td>
                <td><?= $contaPagar->has('forma_pagamento') ? $this->Html->link($contaPagar->forma_pagamento->displayField, ['controller' => 'FormaPagamentos', 'action' => 'view', $contaPagar->forma_pagamento->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link($this->Gus->materialIcon('edit'), ['action' => 'edit', $contaPagar->id], ['escape' => false, 'class' => 'btn btn-floating btn-sm waves-effect waves-light edit']) ?>
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
    var addLink = '<?= Router::url(['controller' => 'contaPagars', 'action' => 'add'], true); ?>';
    var editLink = '<?= Router::url(['controller' => 'contaPagars', 'action' => 'edit', '--id--'], true); ?>';
    var viewLink = '<?= Router::url(['controller' => 'contaPagars', 'action' => 'view', '--id--'], true); ?>';
    var deleteLink = '<?= Router::url(['controller' => 'contaPagars', 'action' => 'delete'], true); ?>';
</script>
<?= $this->element('botao_fixo', ['controller' => $this->request->getParam('controller')]) ?>