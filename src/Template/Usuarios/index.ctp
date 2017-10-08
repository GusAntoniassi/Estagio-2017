<?php
use Cake\Routing\Router;

/**
 * @var \App\View\AppView $this
 */
?>
    <div class="usuarios index list row card-panel">
        <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
        <?php $this->assign('title', 'Usuário'); ?>
        <div class="row filtros">
            <div class="col s12">
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header"><?= $this->Gus->materialIcon('filter_list'); ?> Filtros</div>
                        <div class="collapsible-body">
                            <div class="row">
                                <?= $this->Gus->create(); ?>
                                <?= $this->Gus->control('id', ['div' => 'colF s2 m1 l1', 'label' => 'ID']); ?>
                                <?= $this->Gus->control('login', ['div' => 'col s4 m4 l4', 'label' => 'E-mail']); ?>
                                <?= $this->Gus->control('status', ['type' => 'select', 'data-material-select', 'div' => 'col s3 m2 l2', 'label' => 'Status', 'options' => $this->Gus->getStatusOptions()]); ?>
                                <?= $this->Gus->control('grupo_usuario_id', ['div' => 'col s3 m3 l3', 'data-material-select', 'label' => 'Grupo de Usuários']); ?>
                                <?= $this->Gus->control('Filtrar', ['div' => 'col s12 m2 l2 right', 'type' => 'submit', 'class' => 'btn waves-effect waves-light']); ?>
                                <?= $this->Gus->end(); ?>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <?= $this->Gus->create('Usuario', [
            'url' => ['controller' => 'usuarios', 'action' => 'delete'],
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
                <th scope="col"><?= $this->Paginator->sort('login', 'E-mail') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('grupo_usuario_id', 'Grupo de Usuários') ?></th>
                <th scope="col" class="actions"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><input type="checkbox" id="check<?= $usuario->id ?>" class="filled-in"
                               name="data[ids][<?= $usuario->id ?>]" value="<?= $usuario->id ?>"/><label
                                for="check<?= $usuario->id ?>">&nbsp;</label></td>
                    <td><?= $this->Number->format($usuario->id) ?></td>
                    <td><?= h($usuario->login) ?></td>
                    <td><?= $this->Gus->formataStatus($usuario->status) ?></td>
                    <td><?= $usuario->has('grupo_usuario') ? $this->Html->link($usuario->grupo_usuario->nome, ['controller' => 'GrupoUsuarios', 'action' => 'view', $usuario->grupo_usuario->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link($this->Gus->materialIcon('edit'), ['action' => 'edit', $usuario->id], ['escape' => false, 'class' => 'btn btn-floating btn-sm waves-effect waves-light edit']) ?>
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
        var addLink = '<?= Router::url(['controller' => 'usuarios', 'action' => 'add'], true); ?>';
        var editLink = '<?= Router::url(['controller' => 'usuarios', 'action' => 'edit', '--id--'], true); ?>';
        var viewLink = '<?= Router::url(['controller' => 'usuarios', 'action' => 'view', '--id--'], true); ?>';
        var deleteLink = '<?= Router::url(['controller' => 'usuarios', 'action' => 'delete'], true); ?>';
    </script>
<?= $this->element('botao_fixo', ['controller' => $this->request->getParam('controller')]) ?>