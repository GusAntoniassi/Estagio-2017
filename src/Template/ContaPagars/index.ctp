<?php
use Cake\Routing\Router;

/**
 * @var \App\View\AppView $this
 */
?>
    <div class="contaPagars index list row card-panel">
        <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
        <?php $this->assign('title', 'Contas a Pagar'); ?>
        <div class="row filtros">
            <div class="col s12">
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header"><?= $this->Gus->materialIcon('filter_list'); ?> Filtros</div>
                        <div class="collapsible-body">
                            <div class="row">
                                <?= $this->Gus->create(); ?>
                                <?= $this->Gus->control('id', ['div' => 'col s2 m1 l1', 'label' => 'ID']); ?>
                                <?= $this->Gus->control('descricao', ['div' => 'col s2 m1 l6', 'label' => 'Descrição']); ?>
                                <?= $this->Gus->control('valor', ['div' => 'col s2 m1 l3', 'label' => 'Valor (R$)', 'data-type' => 'money']); ?>
                                <?= $this->Gus->control('pago', ['div' => 'col s2 m1 l2', 'label' => 'Pago', 'options' => $this->Gus->getBooleanOptions(), 'data-material-select']); ?>
                                <?= $this->Gus->control('fornecedor_id', ['div' => 'col s2 m1 l5', 'label' => 'Fornecedor', 'data-material-select']); ?>
                                <?= $this->Gus->control('forma_pagamento_id', ['div' => 'col s2 m1 l5', 'label' => 'Forma de Pagamento', 'data-material-select']); ?>
                                <?= $this->Gus->button('<i class="material-icons">filter_list</i>', ['div' => 'input-field col s12 m2 l2 right submit', 'type' => 'submit', 'class' => 'btn waves-effect waves-light']); ?>
                                <?= $this->Gus->end(); ?>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <?= $this->Gus->create('ContaPagar', [
            'url' => ['controller' => 'contaPagars', 'action' => 'delete'],
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
                <th scope="col"><?= $this->Paginator->sort('ContaPagars.id', 'ID') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ContaPagars.descricao', 'Descrição') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ContaPagars.valor', 'Valor') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ContaPagars.data_cadastro', 'Data do cadastro') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ContaPagars.pago', 'Pago') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ContaPagars.data_pagamento', 'Data do pagamento') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Pessoas.nome_razaosocial', 'Fornecedor') ?></th>
                <th scope="col"><?= $this->Paginator->sort('FormaPagamentos.nome', 'Forma de pagamento') ?></th>
                <th scope="col" class="actions"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($contaPagars as $contaPagar): ?>
                <tr>
                    <td><input type="checkbox" id="check<?= $contaPagar->id ?>" class="filled-in"
                               name="data[ids][<?= $contaPagar->id ?>]" value="<?= $contaPagar->id ?>"/><label
                                for="check<?= $contaPagar->id ?>">&nbsp;</label></td>
                    <td><?= $this->Number->format($contaPagar->id) ?></td>
                    <td><?= h($contaPagar->descricao) ?></td>
                    <td><?= $this->Number->currency($contaPagar->valor, 'BRL') ?></td>
                    <td><?= $contaPagar->data_cadastro->format('d/m/Y') ?></td>
                    <td><?= $this->Gus->formataBoolean($contaPagar->pago) ?></td>
                    <td><?= !empty($contaPagar->data_pagamento) ? $contaPagar->data_pagamento->format('d/m/Y') : '' ?></td>
                    <td><?= $contaPagar->has('fornecedor') ? $this->Html->link($contaPagar->fornecedor->pessoa->nome_exibicao, ['controller' => 'Fornecedores', 'action' => 'view', $contaPagar->fornecedor->id]) : '' ?></td>
                    <td><?= $contaPagar->has('forma_pagamento') ? $this->Html->link($contaPagar->forma_pagamento->displayField, ['controller' => 'FormaPagamentos', 'action' => 'view', $contaPagar->forma_pagamento->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link($this->Gus->materialIcon('edit'), ['action' => 'edit', $contaPagar->id], ['escape' => false, 'class' => 'btn btn-floating btn-sm waves-effect waves-light edit']) ?>
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
        var addLink = '<?= Router::url(['controller' => 'contaPagars', 'action' => 'add'], true); ?>';
        var editLink = '<?= Router::url(['controller' => 'contaPagars', 'action' => 'edit', '--id--'], true); ?>';
        var viewLink = '<?= Router::url(['controller' => 'contaPagars', 'action' => 'view', '--id--'], true); ?>';
        var deleteLink = '<?= Router::url(['controller' => 'contaPagars', 'action' => 'delete'], true); ?>';
    </script>
<?= $this->element('botao_fixo', ['controller' => $this->request->getParam('controller')]) ?>