<?php
use Cake\Routing\Router;

/**
 * @var \App\View\AppView $this
 */
?>
    <div class="fornecedores index list row card-panel">
        <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
        <?php $this->assign('title', 'Fornecedor'); ?>
        <div class="row filtros">
            <div class="col s12">
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header"><?= $this->Gus->materialIcon('filter_list'); ?> Filtros</div>
                        <div class="collapsible-body">
                            <div class="row">
                                <?= $this->Gus->create(); ?>
                                <?= $this->Gus->control('id', ['div' => 'col s2 m1 l1', 'label' => 'ID']); ?>
                                <?= $this->Gus->control('Pessoas.cpfcnpj', ['div' => 'col s5 m5 l5', 'label' => 'CPF/CNPJ']); ?>
                                <?= $this->Gus->control('Pessoas.nome_razaosocial', ['div' => 'col s5 m6 l6', 'label' => 'Nome/Razão social']); ?>
                                <?= $this->Gus->control('Pessoas.sobrenome_nomefantasia', ['div' => 'col s9 m8 l8', 'label' => 'Sobrenome/Nome fantasia']); ?>
                                <?= $this->Gus->control('status', ['type' => 'select', 'data-material-select', 'div' => 'col s3 m2 l2', 'label' => 'Status', 'options' => $this->Gus->getStatusOptions(), 'value' => '']); ?>
                                <?= $this->Gus->control('Filtrar', ['div' => 'col s12 m2 l2 right', 'type' => 'submit', 'class' => 'btn waves-effect waves-light']); ?>
                                <?= $this->Gus->end(); ?>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <?= $this->Gus->create('Fornecedor', [
            'url' => ['controller' => 'fornecedores', 'action' => 'delete'],
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
                <th scope="col"><?= $this->Paginator->sort('Fornecedores.id', 'ID') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Pessoas.nome_razaosocial', 'Nome/Razão social') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Pessoas.sobrenome_nomefantasia', 'Sobrenome/Nome fantasia') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Pessoas.tipo_pessoa', 'Tipo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Pessoas.cpfcnpj', 'CPF/CNPJ') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Pessoas.telefone_1', 'Telefone principal') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Fornecedores.status', 'Status') ?></th>
                <th scope="col" class="actions"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($fornecedores as $fornecedor): ?>
                <tr>
                    <td><input type="checkbox" id="check<?= $fornecedor->id ?>" class="filled-in"
                               name="data[ids][<?= $fornecedor->id ?>]" value="<?= $fornecedor->id ?>"/><label
                                for="check<?= $fornecedor->id ?>">&nbsp;</label></td>
                    <td><?= $this->Number->format($fornecedor->id) ?></td>
                    <td><?= h($fornecedor->pessoa->nome_razaosocial) ?></td>
                    <td><?= h($fornecedor->pessoa->sobrenome_nomefantasia) ?></td>
                    <td><?= $this->Gus->tipoPessoaPorExtenso($fornecedor->pessoa->tipo_pessoa) ?></td>
                    <td><?= h($fornecedor->pessoa->cpfcnpj) ?></td>
                    <td><?= h($fornecedor->pessoa->telefone_1) ?></td>
                    <td><?= $this->Gus->formataStatus($fornecedor->status) ?></td>
                    <td class="actions">
                        <?= $this->Html->link($this->Gus->materialIcon('edit'), ['action' => 'edit', $fornecedor->id], ['escape' => false, 'class' => 'btn btn-floating btn-sm waves-effect waves-light edit']) ?>
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
        var addLink = '<?= Router::url(['controller' => 'fornecedores', 'action' => 'add'], true); ?>';
        var editLink = '<?= Router::url(['controller' => 'fornecedores', 'action' => 'edit', '--id--'], true); ?>';
        var viewLink = '<?= Router::url(['controller' => 'fornecedores', 'action' => 'view', '--id--'], true); ?>';
        var deleteLink = '<?= Router::url(['controller' => 'fornecedores', 'action' => 'delete'], true); ?>';
    </script>
<?= $this->element('botao_fixo', ['controller' => $this->request->getParam('controller')]) ?>