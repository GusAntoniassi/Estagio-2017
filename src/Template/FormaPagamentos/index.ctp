<?php
use Cake\Routing\Router;

/**
 * @var \App\View\AppView $this
 */
?>
    <div class="formaPagamentos index list row card-panel">
        <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
        <?php $this->assign('title', 'Formas de Pagamento'); ?>
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
                                <?= $this->Gus->control('num_parcelas', ['div' => 'col s6 m3 l3', 'label' => 'Nº de parcelas']); ?>
                                <?= $this->Gus->control('status', ['type' => 'select', 'data-material-select', 'div' => 'col s6 m3 l3', 'label' => 'Status', 'options' => $this->Gus->getStatusOptions()]); ?>
                                <?= $this->Gus->button('<i class="material-icons">filter_list</i>', ['div' => 'input-field col s12 m2 l2 right submit', 'type' => 'submit', 'class' => 'btn waves-effect waves-light']); ?>
                                <?= $this->Gus->end(); ?>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <?= $this->Gus->create('FormaPagamento', [
            'url' => ['controller' => 'formaPagamentos', 'action' => 'delete'],
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
                <th scope="col"><?= $this->Paginator->sort('num_parcelas', 'Nº de parcelas') ?></th>
                <th scope="col"><?= $this->Paginator->sort('dias_carencia_primeira_parcela', 'Carência') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col" class="actions"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($formaPagamentos as $formaPagamento): ?>
                <tr>
                    <td><input type="checkbox" id="check<?= $formaPagamento->id ?>" class="filled-in"
                               name="data[ids][<?= $formaPagamento->id ?>]" value="<?= $formaPagamento->id ?>"/><label
                                for="check<?= $formaPagamento->id ?>">&nbsp;</label></td>
                    <td><?= $this->Number->format($formaPagamento->id) ?></td>
                    <td><?= h($formaPagamento->nome) ?></td>
                    <td><?= $this->Number->format($formaPagamento->num_parcelas) ?></td>
                    <td><?= $this->Number->format($formaPagamento->dias_carencia_primeira_parcela) . ' dia(s)'?></td>
                    <td><?= $this->Gus->formataStatus($formaPagamento->status) ?></td>
                    <td class="actions">
                        <?= $this->Html->link($this->Gus->materialIcon('edit'), ['action' => 'edit', $formaPagamento->id], ['escape' => false, 'class' => 'btn btn-floating btn-sm waves-effect waves-light edit']) ?>
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
        var addLink = '<?= Router::url(['controller' => 'formaPagamentos', 'action' => 'add'], true); ?>';
        var editLink = '<?= Router::url(['controller' => 'formaPagamentos', 'action' => 'edit', '--id--'], true); ?>';
        var viewLink = '<?= Router::url(['controller' => 'formaPagamentos', 'action' => 'view', '--id--'], true); ?>';
        var deleteLink = '<?= Router::url(['controller' => 'formaPagamentos', 'action' => 'delete'], true); ?>';
    </script>
<?= $this->element('botao_fixo', ['controller' => $this->request->getParam('controller')]) ?>