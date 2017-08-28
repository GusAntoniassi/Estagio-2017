<?php
use Cake\Routing\Router;
/**
  * @var \App\View\AppView $this
  */
?>
<div class="formaPagamentos index list row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'FormaPagamento'); ?>
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
                                                                                                                <?= $this->Gus->control('num_parcelas', ['div' => 'col s2 m1 l1', 'label' => 'Num Parcelas']); ?>
                                                                                                                <?= $this->Gus->control('dias_carencia_primeira_parcela', ['div' => 'col s2 m1 l1', 'label' => 'Dias Carencia Primeira Parcela']); ?>
                                                                                                                <?= $this->Gus->control('entrada', ['div' => 'col s2 m1 l1', 'label' => 'Entrada']); ?>
                                                                                                                <?= $this->Gus->control('status', ['type' => 'select', 'data-material-select', 'div' => 'col s2 m1 l1', 'label' => 'Status', 'options' => $this->Gus->getStatusOptions(), 'value' => '']); ?>
                            <?= $this->Gus->control('status', ['div' => 'col s2 m1 l1', 'label' => 'Status']); ?>
                                                                                    <?= $this->Gus->control('Filtrar', ['div' => 'col s12 m2 l2 right', 'type' => 'submit', 'class' => 'btn waves-effect waves-light']); ?>
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
                <input type="checkbox" class="filled-in" id="check-all" /><label for="check-all">&nbsp;</label>
            </th>
                        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('num_parcelas') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('dias_carencia_primeira_parcela') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('entrada') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                        <th scope="col" class="actions"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($formaPagamentos as $formaPagamento): ?>
            <tr>
                <td><input type="checkbox" id="check<?= $formaPagamento->id ?>" class="filled-in" name="data[ids][<?= $formaPagamento->id ?>]" value="<?= $formaPagamento->id ?>" /><label for="check<?= $formaPagamento->id ?>">&nbsp;</label></td>
                <td><?= $this->Number->format($formaPagamento->id) ?></td>
                <td><?= h($formaPagamento->nome) ?></td>
                <td><input type="checkbox" id="check<?= $formaPagamento->num_parcelas ?>" class="filled-in" name="data[ids][<?= $formaPagamento->num_parcelas ?>]" value="<?= $formaPagamento->num_parcelas ?>" /><label for="check<?= $formaPagamento->num_parcelas ?>">&nbsp;</label></td>
                <td><?= $this->Number->format($formaPagamento->num_parcelas) ?></td>
                <td><input type="checkbox" id="check<?= $formaPagamento->dias_carencia_primeira_parcela ?>" class="filled-in" name="data[ids][<?= $formaPagamento->dias_carencia_primeira_parcela ?>]" value="<?= $formaPagamento->dias_carencia_primeira_parcela ?>" /><label for="check<?= $formaPagamento->dias_carencia_primeira_parcela ?>">&nbsp;</label></td>
                <td><?= $this->Number->format($formaPagamento->dias_carencia_primeira_parcela) ?></td>
                <td><input type="checkbox" id="check<?= $formaPagamento->entrada ?>" class="filled-in" name="data[ids][<?= $formaPagamento->entrada ?>]" value="<?= $formaPagamento->entrada ?>" /><label for="check<?= $formaPagamento->entrada ?>">&nbsp;</label></td>
                <td><?= $this->Number->format($formaPagamento->entrada) ?></td>
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