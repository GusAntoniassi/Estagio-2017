<?php
use Cake\Routing\Router;

/**
 * @var \App\View\AppView $this
 */
?>
    <div class="produtos index list row card-panel">
        <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
        <?php $this->assign('title', 'Produto'); ?>
        <div class="row filtros">
            <div class="col s12">
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header"><?= $this->Gus->materialIcon('filter_list'); ?> Filtros</div>
                        <div class="collapsible-body">
                            <div class="row">
                                <?= $this->Gus->create(); ?>
                                <?= $this->Gus->control('id', ['div' => 'col s2 m1 l1', 'label' => 'ID']); ?>
                                <?= $this->Gus->control('nome', ['div' => 'col s10 m6 l6', 'label' => 'Nome']); ?>
                                <?= $this->Gus->control('tipo_produto_id', ['div' => 'col s12 m5 l5', 'label' => 'Tipo de produto', 'type' => 'select', 'data-material-select']); ?>
                                <?= $this->Gus->control('preco', ['div' => 'col s6 m4 l4', 'label' => 'Preço (R$)', 'data-type' => 'money']); ?>
                                <?= $this->Gus->control('custo', ['div' => 'col s6 m4 l4', 'label' => 'Custo (R$)', 'data-type' => 'money']); ?>
                                <?= $this->Gus->control('status', ['type' => 'select', 'data-material-select', 'div' => 'col s12 m2 l2', 'label' => 'Status', 'options' => $this->Gus->getStatusOptions()]); ?>
                                <?= $this->Gus->control('Filtrar', ['div' => 'col s12 m2 l2 right', 'type' => 'submit', 'class' => 'btn waves-effect waves-light']); ?>
                                <?= $this->Gus->end(); ?>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <?= $this->Gus->create('Produto', [
            'url' => ['controller' => 'produtos', 'action' => 'delete'],
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
                <th scope="col"><?= $this->Paginator->sort('preco', 'Preço') ?></th>
                <th scope="col"><?= $this->Paginator->sort('custo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tipo_produto_id', 'Tipo de produto') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col" class="actions"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($produtos as $produto): ?>
                <tr>
                    <td><input type="checkbox" id="check<?= $produto->id ?>" class="filled-in"
                               name="data[ids][<?= $produto->id ?>]" value="<?= $produto->id ?>"/><label
                                for="check<?= $produto->id ?>">&nbsp;</label></td>
                    <td><?= $this->Number->format($produto->id) ?></td>
                    <td><?= h($produto->nome) ?></td>
                    <td><?= $this->Number->currency($produto->preco, 'BRL') ?></td>
                    <td><?= $this->Number->currency($produto->custo, 'BRL') ?></td>
                    <td><?= $produto->has('tipo_produto') ? $this->Html->link($produto->tipo_produto->displayField, ['controller' => 'TipoProdutos', 'action' => 'view', $produto->tipo_produto->id]) : '' ?></td>
                    <td><?= $this->Gus->formataStatus($produto->status) ?></td>
                    <td class="actions">
                        <?= $this->Html->link($this->Gus->materialIcon('edit'), ['action' => 'edit', $produto->id], ['escape' => false, 'class' => 'btn btn-floating btn-sm waves-effect waves-light edit']) ?>
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
        var addLink = '<?= Router::url(['controller' => 'produtos', 'action' => 'add'], true); ?>';
        var editLink = '<?= Router::url(['controller' => 'produtos', 'action' => 'edit', '--id--'], true); ?>';
        var viewLink = '<?= Router::url(['controller' => 'produtos', 'action' => 'view', '--id--'], true); ?>';
        var deleteLink = '<?= Router::url(['controller' => 'produtos', 'action' => 'delete'], true); ?>';
    </script>
<?= $this->element('botao_fixo', ['controller' => $this->request->getParam('controller')]) ?>