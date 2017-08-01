<?php
use Cake\Routing\Router;

/**
 * @var \App\View\AppView $this
 */
?>
    <div class="grupoUsuarios index list row card-panel">
        <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
        <?php $this->assign('title', 'Grupo de Usuário'); ?>
        <div class="row filtros">
            <div class="col s12">
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header"><?= $this->Gus->materialIcon('filter_list'); ?> Filtros</div>
                        <div class="collapsible-body">
                            <div class="row">
                                <?= $this->Gus->create(); ?>
                                <?= $this->Gus->control('id', ['div' => 'col s2 m1 l1', 'label' => 'ID']); ?>
                                <?= $this->Gus->control('nome', ['div' => 'col s7 m7 l7', 'label' => 'Nome']); ?>
                                <?= $this->Gus->control('status', ['type' => 'select', 'data-material-select', 'div' => 'col s3 m2 l2', 'label' => 'Status', 'options' => $this->Gus->getStatusOptions(), 'value' => '']); ?>
                                <?= $this->Gus->control('Filtrar', ['div' => 'col s12 m2 l2 right', 'type' => 'submit', 'class' => 'btn waves-effect waves-light']); ?>
                                <?= $this->Gus->end(); ?>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <?= $this->Gus->create('GrupoUsuario', [
            'url' => ['controller' => 'grupoUsuarios', 'action' => 'delete'],
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
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col" class="actions"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($grupoUsuarios as $grupoUsuario): ?>
                <tr>
                    <td><input type="checkbox" id="check<?= $grupoUsuario->id ?>" class="filled-in"
                               name="data[ids][<?= $grupoUsuario->id ?>]" value="<?= $grupoUsuario->id ?>"/><label
                                for="check<?= $grupoUsuario->id ?>">&nbsp;</label></td>
                    <td><?= $this->Number->format($grupoUsuario->id) ?></td>
                    <td><?= h($grupoUsuario->nome) ?></td>
                    <td><?= $this->Gus->formataStatus($grupoUsuario->status) ?></td>
                    <td class="actions">
                        <?= $this->Html->link($this->Gus->materialIcon('edit'), ['action' => 'edit', $grupoUsuario->id], ['escape' => false, 'class' => 'btn btn-floating btn-sm waves-effect waves-light edit']) ?>
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
        var addLink = '<?= Router::url(['controller' => 'grupoUsuarios', 'action' => 'add'], true); ?>';
        var editLink = '<?= Router::url(['controller' => 'grupoUsuarios', 'action' => 'edit', '--id--'], true); ?>';
        var viewLink = '<?= Router::url(['controller' => 'grupoUsuarios', 'action' => 'view', '--id--'], true); ?>';
        var deleteLink = '<?= Router::url(['controller' => 'grupoUsuarios', 'action' => 'delete'], true); ?>';
    </script>
<?= $this->element('botao_fixo', ['controller' => $this->request->getParam('controller')]) ?>