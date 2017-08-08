<?php
use Cake\Routing\Router;
/**
  * @var \App\View\AppView $this
  */
?>
<div class="funcionarios index list row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Funcionario'); ?>
    <div class="row filtros">
        <div class="col s12">
            <ul class="collapsible" data-collapsible="accordion">
                <li>
                    <div class="collapsible-header"><?= $this->Gus->materialIcon('filter_list'); ?> Filtros</div>
                    <div class="collapsible-body">
                        <div class="row">
                            <?= $this->Gus->create(); ?>
                                                                                    <?= $this->Gus->control('id', ['div' => 'col s2 m1 l1', 'label' => 'Id']); ?>
                                                                                                                <?= $this->Gus->control('data_nascimento', ['div' => 'col s2 m1 l1', 'label' => 'Data Nascimento']); ?>
                                                                                                                <?= $this->Gus->control('horista', ['div' => 'col s2 m1 l1', 'label' => 'Horista']); ?>
                                                                                                                <?= $this->Gus->control('valor_hora', ['div' => 'col s2 m1 l1', 'label' => 'Valor Hora']); ?>
                                                                                                                <?= $this->Gus->control('status', ['type' => 'select', 'data-material-select', 'div' => 'col s2 m1 l1', 'label' => 'Status', 'options' => $this->Gus->getStatusOptions(), 'value' => '']); ?>
                            <?= $this->Gus->control('status', ['div' => 'col s2 m1 l1', 'label' => 'Status']); ?>
                                                                                                                <?= $this->Gus->control('pessoa_id', ['div' => 'col s2 m1 l1', 'label' => 'Pessoa Id']); ?>
                                                                                    <?= $this->Gus->control('Filtrar', ['div' => 'col s12 m2 l2 right', 'type' => 'submit', 'class' => 'btn waves-effect waves-light']); ?>
                            <?= $this->Gus->end(); ?>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <?= $this->Gus->create('Funcionario', [
        'url' => ['controller' => 'funcionarios', 'action' => 'delete'],
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
                        <th scope="col"><?= $this->Paginator->sort('data_nascimento') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('horista') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('valor_hora') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('pessoa_id') ?></th>
                        <th scope="col" class="actions"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($funcionarios as $funcionario): ?>
            <tr>
                <td><input type="checkbox" id="check<?= $funcionario->id ?>" class="filled-in" name="data[ids][<?= $funcionario->id ?>]" value="<?= $funcionario->id ?>" /><label for="check<?= $funcionario->id ?>">&nbsp;</label></td>
                <td><?= $this->Number->format($funcionario->id) ?></td>
                <td><?= h($funcionario->data_nascimento) ?></td>
                <td><?= $this->Gus->formataStatus($funcionario->horista) ?></td>
                <td><input type="checkbox" id="check<?= $funcionario->valor_hora ?>" class="filled-in" name="data[ids][<?= $funcionario->valor_hora ?>]" value="<?= $funcionario->valor_hora ?>" /><label for="check<?= $funcionario->valor_hora ?>">&nbsp;</label></td>
                <td><?= $this->Number->format($funcionario->valor_hora) ?></td>
                <td><?= $this->Gus->formataStatus($funcionario->status) ?></td>
                <td><?= $funcionario->has('pessoa') ? $this->Html->link($funcionario->pessoa->displayField, ['controller' => 'Pessoas', 'action' => 'view', $funcionario->pessoa->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link($this->Gus->materialIcon('edit'), ['action' => 'edit', $funcionario->id], ['escape' => false, 'class' => 'btn btn-floating btn-sm waves-effect waves-light edit']) ?>
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
    var addLink = '<?= Router::url(['controller' => 'funcionarios', 'action' => 'add'], true); ?>';
    var editLink = '<?= Router::url(['controller' => 'funcionarios', 'action' => 'edit', '--id--'], true); ?>';
    var viewLink = '<?= Router::url(['controller' => 'funcionarios', 'action' => 'view', '--id--'], true); ?>';
    var deleteLink = '<?= Router::url(['controller' => 'funcionarios', 'action' => 'delete'], true); ?>';
</script>
<?= $this->element('botao_fixo', ['controller' => $this->request->getParam('controller')]) ?>