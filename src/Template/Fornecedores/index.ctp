<?php
use Cake\Routing\Router;
/**
  * @var \App\View\AppView $this
  */
?>
<div class="fornecedores index list row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Fornecedor'); ?>
    <div class="row filtros">
        <div class="col s12">
            <ul class="collapsible" data-collapsible="accordion">
                <li>
                    <div class="collapsible-header"><?= $this->Gus->materialIcon('filter_list'); ?> Filtros</div>
                    <div class="collapsible-body">
                        <div class="row">
                            <?= $this->Gus->create(); ?>
                                                                                    <?= $this->Gus->control('id', ['div' => 'col s2 m1 l1', 'label' => 'Id']); ?>
                                                                                                                <?= $this->Gus->control('status', ['type' => 'select', 'data-material-select', 'div' => 'col s2 m1 l1', 'label' => 'Status', 'options' => $this->Gus->getStatusOptions(), 'value' => '']); ?>
                            <?= $this->Gus->control('status', ['div' => 'col s2 m1 l1', 'label' => 'Status']); ?>
                                                                                                                <?= $this->Gus->control('dia_semana_visita', ['div' => 'col s2 m1 l1', 'label' => 'Dia Semana Visita']); ?>
                                                                                                                <?= $this->Gus->control('pessoa_id', ['div' => 'col s2 m1 l1', 'label' => 'Pessoa Id']); ?>
                                                                                    <?= $this->Gus->control('Filtrar', ['div' => 'col s12 m2 l2 right', 'type' => 'submit', 'class' => 'btn waves-effect waves-light']); ?>
                            <?= $this->Gus->end(); ?>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <?= $this->Gus->create('Fornecedor', [
        'url' => ['controller' => 'fornecedores', 'action' => 'delete'],
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
                        <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('dia_semana_visita') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('pessoa_id') ?></th>
                        <th scope="col" class="actions"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($fornecedores as $fornecedor): ?>
            <tr>
                <td><input type="checkbox" id="check<?= $fornecedor->id ?>" class="filled-in" name="data[ids][<?= $fornecedor->id ?>]" value="<?= $fornecedor->id ?>" /><label for="check<?= $fornecedor->id ?>">&nbsp;</label></td>
                <td><?= $this->Number->format($fornecedor->id) ?></td>
                <td><?= $this->Gus->formataStatus($fornecedor->status) ?></td>
                <td><?= $this->Gus->formataStatus($fornecedor->dia_semana_visita) ?></td>
                <td><?= $fornecedor->has('pessoa') ? $this->Html->link($fornecedor->pessoa->displayField, ['controller' => 'Pessoas', 'action' => 'view', $fornecedor->pessoa->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link($this->Gus->materialIcon('edit'), ['action' => 'edit', $fornecedor->id], ['escape' => false, 'class' => 'btn btn-floating btn-sm waves-effect waves-light edit']) ?>
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
    var addLink = '<?= Router::url(['controller' => 'fornecedores', 'action' => 'add'], true); ?>';
    var editLink = '<?= Router::url(['controller' => 'fornecedores', 'action' => 'edit', '--id--'], true); ?>';
    var viewLink = '<?= Router::url(['controller' => 'fornecedores', 'action' => 'view', '--id--'], true); ?>';
    var deleteLink = '<?= Router::url(['controller' => 'fornecedores', 'action' => 'delete'], true); ?>';
</script>
<?= $this->element('botao_fixo', ['controller' => $this->request->getParam('controller')]) ?>