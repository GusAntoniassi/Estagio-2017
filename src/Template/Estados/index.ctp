<?php
use Cake\Routing\Router;

/**
 * @var \App\View\AppView $this
 */
?>
    <div class="estados index list row card-panel">
        <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
        <?php $this->assign('title', 'Estado'); ?>
        <div class="row filtros">
            <div class="col s12">
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header"><?= $this->Gus->materialIcon('filter_list'); ?> Filtros</div>
                        <div class="collapsible-body">
                            <div class="row">
                                <?= $this->Gus->create(); ?>
                                <?= $this->Gus->control('id', ['div' => 'col s2 m1 l1', 'label' => 'ID']); ?>
                                <?= $this->Gus->control('nome', ['div' => 'col s2 m4 l4', 'label' => 'Nome']); ?>
                                <?= $this->Gus->control('sigla', ['div' => 'col s2 m1 l1', 'label' => 'Sigla']); ?>
                                <?= $this->Gus->control('status', ['type' => 'select', 'data-material-select', 'div' => 'col s3 m2 l2', 'label' => 'Status', 'options' => $this->Gus->getStatusOptions(), 'value' => '']); ?>
                                <?= $this->Gus->control('pais_id', ['div' => 'col s3 m2 l2', 'data-material-select', 'label' => 'País']); ?>
                                <?= $this->Gus->control('Filtrar', ['div' => 'col s12 m2 l2 right', 'type' => 'submit', 'class' => 'btn waves-effect waves-light']); ?>
                                <?= $this->Gus->end(); ?>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <?= $this->Gus->create('Estado', [
            'url' => ['controller' => 'estados', 'action' => 'delete'],
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
                <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sigla') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('pais_id', 'País') ?></th>
                <th scope="col" class="actions"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($estados as $estado): ?>
                <tr>
                    <td><input type="checkbox" id="check<?= $estado->id ?>" class="filled-in"
                               name="data[ids][<?= $estado->id ?>]" value="<?= $estado->id ?>"/><label
                                for="check<?= $estado->id ?>">&nbsp;</label></td>
                    <td><?= $this->Number->format($estado->id) ?></td>
                    <td><?= h($estado->nome) ?></td>
                    <td><?= h($estado->sigla) ?></td>
                    <td><?= $this->Gus->formataStatus($estado->status) ?></td>
                    <td><?= $estado->has('pais') ? $this->Html->link($estado->pais->nome, ['controller' => 'Paises', 'action' => 'view', $estado->pais->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link($this->Gus->materialIcon('edit'), ['action' => 'edit', $estado->id], ['escape' => false, 'class' => 'btn btn-floating btn-sm waves-effect waves-light edit']) ?>
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
        var addLink = '<?= Router::url(['controller' => 'estados', 'action' => 'add'], true); ?>';
        var editLink = '<?= Router::url(['controller' => 'estados', 'action' => 'edit', '--id--'], true); ?>';
        var viewLink = '<?= Router::url(['controller' => 'estados', 'action' => 'view', '--id--'], true); ?>';
        var deleteLink = '<?= Router::url(['controller' => 'estados', 'action' => 'delete'], true); ?>';
    </script>
<?= $this->element('botao_fixo', ['controller' => $this->request->getParam('controller')]) ?>