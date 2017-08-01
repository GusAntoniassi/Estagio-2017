<?php
use Cake\Routing\Router;

/**
 * @var \App\View\AppView $this
 */
?>
    <div class="tipoProdutos index list row card-panel">
        <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
        <?php $this->assign('title', 'Tipos de Produtos'); ?>
        <div class="row filtros">
            <div class="col s12">
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header"><?= $this->Gus->materialIcon('filter_list'); ?> Filtros</div>
                        <div class="collapsible-body">
                            <div class="row">
                                <?= $this->Gus->create(); ?>
                                <?= $this->Gus->control('id', ['div' => 'col s2 m1 l1', 'label' => 'Id']); ?>
                                <?= $this->Gus->control('nome', ['div' => 'col s2 m1 l1', 'label' => 'Nome']); ?>
                                <?= $this->Gus->control('status', ['type' => 'select', 'data-material-select', 'div' => 'col s2 m1 l1', 'label' => 'Status', 'options' => $this->Gus->getStatusOptions(), 'value' => '']); ?>
                                <?= $this->Gus->control('Filtrar', ['div' => 'col s12 m2 l2 right', 'type' => 'submit', 'class' => 'btn waves-effect waves-light']); ?>
                                <?= $this->Gus->end(); ?>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <?= $this->Gus->create('TipoProduto', [
            'url' => ['controller' => 'tipoProdutos', 'action' => 'delete'],
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
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col" class="actions"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tipoProdutos as $tipoProduto): ?>
                <tr>
                    <td><?= $this->Number->format($tipoProduto->id) ?></td>
                    <td><input type="checkbox" id="check<?= $tipoProduto->id ?>" class="filled-in"
                               name="data[ids][<?= $tipoProduto->id ?>]" value="<?= $tipoProduto->id ?>"/><label
                                for="check<?= $tipoProduto->id ?>">&nbsp;</label></td>
                    <td><?= h($tipoProduto->nome) ?></td>
                    <td><?= $this->Gus->formataStatus($tipoProduto->status) ?></td>
                    <td class="actions">
                        <?= $this->Html->link($this->Gus->materialIcon('edit'), ['action' => 'edit', $tipoProduto->id], ['escape' => false, 'class' => 'btn btn-floating btn-sm waves-effect waves-light edit']) ?>
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
        var addLink = '<?= Router::url(['controller' => 'tipoProdutos', 'action' => 'add'], true); ?>';
        var editLink = '<?= Router::url(['controller' => 'tipoProdutos', 'action' => 'edit', '--id--'], true); ?>';
        var viewLink = '<?= Router::url(['controller' => 'tipoProdutos', 'action' => 'view', '--id--'], true); ?>';
        var deleteLink = '<?= Router::url(['controller' => 'tipoProdutos', 'action' => 'delete'], true); ?>';
    </script>
<?= $this->element('botao_fixo', ['controller' => $this->request->getParam('controller')]) ?>