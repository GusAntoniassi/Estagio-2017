<?php
use Cake\Routing\Router;

/**
 * @var \App\View\AppView $this
 */
?>
    <div class="cidades index list row card-panel">
        <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
        <?php $this->assign('title', 'Cidade'); ?>
        <div class="row filtros">
            <div class="col s12">
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header"><?= $this->Gus->materialIcon('filter_list'); ?> Filtros</div>
                        <div class="collapsible-body">
                            <div class="row">
                                <?= $this->Gus->create(); ?>
                                <?= $this->Gus->control('id', ['div' => 'col s2 m1 l1', 'label' => 'ID']); ?>
                                <?= $this->Gus->control('nome', ['div' => 'col s10 m3 l3', 'label' => 'Nome']); ?>
                                <?= $this->Gus->control('status', ['type' => 'select', 'data-material-select', 'div' => 'col s6 m3 l3', 'label' => 'Status', 'options' => $this->Gus->getStatusOptions()]); ?>
                                <?= $this->Gus->control('estado_id', ['div' => 'col s6 m3 l3', 'label' => 'Estado', 'data-material-select']); ?>
                                <?= $this->Gus->button('<i class="material-icons">filter_list</i>', ['div' => 'input-field col s12 m2 l2 right submit', 'type' => 'submit', 'class' => 'btn waves-effect waves-light']); ?>
                                <?= $this->Gus->end(); ?>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <?= $this->Gus->create('Cidade', [
            'url' => ['controller' => 'cidades', 'action' => 'delete'],
            'method' => 'post',
            'class' => 'hide',
            'id' => 'form-delete',
        ]); ?>
        <?= $this->Gus->end(); ?>

        <table class="responsive-table index highlight">
            <thead>
            <tr>
                <th scope="col">
                    <input type="checkbox" class="filled-in" id="check-all"/><label for="check-all">&nbsp;</label>
                </th>
                <th scope="col"><?= $this->Paginator->sort('id', 'ID') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('estado_id') ?></th>
                <th scope="col" class="actions"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($cidades as $cidade): ?>
                <tr>
                    <td><input type="checkbox" id="check<?= $cidade->id ?>" class="filled-in"
                               name="data[ids][<?= $cidade->id ?>]" value="<?= $cidade->id ?>"/><label
                                for="check<?= $cidade->id ?>">&nbsp;</label></td>
                    <td><?= $this->Number->format($cidade->id) ?></td>
                    <td><?= h($cidade->nome) ?></td>
                    <td><?= $this->Gus->formataStatus($cidade->status) ?></td>
                    <td><?= $cidade->has('estado') ? $this->Html->link($cidade->estado->displayField, ['controller' => 'Estados', 'action' => 'view', $cidade->estado->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link($this->Gus->materialIcon('edit'), ['action' => 'edit', $cidade->id], ['escape' => false, 'class' => 'btn btn-floating btn-sm waves-effect waves-light edit']) ?>
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
        var addLink = '<?= Router::url(['controller' => 'cidades', 'action' => 'add'], true); ?>';
        var editLink = '<?= Router::url(['controller' => 'cidades', 'action' => 'edit', '--id--'], true); ?>';
        var viewLink = '<?= Router::url(['controller' => 'cidades', 'action' => 'view', '--id--'], true); ?>';
        var deleteLink = '<?= Router::url(['controller' => 'cidades', 'action' => 'delete'], true); ?>';
    </script>
<?= $this->element('botao_fixo', ['controller' => $this->request->getParam('controller')]) ?>