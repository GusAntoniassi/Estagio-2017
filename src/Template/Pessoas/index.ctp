<?php
use Cake\Routing\Router;
/**
  * @var \App\View\AppView $this
  */
?>
<div class="pessoas index list row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Pessoa'); ?>
    <div class="row filtros">
        <div class="col s12">
            <ul class="collapsible" data-collapsible="accordion">
                <li>
                    <div class="collapsible-header"><?= $this->Gus->materialIcon('filter_list'); ?> Filtros</div>
                    <div class="collapsible-body">
                        <div class="row">
                            <?= $this->Gus->create(); ?>
                                                                                    <?= $this->Gus->control('id', ['div' => 'col s2 m1 l1', 'label' => 'Id']); ?>
                                                                                                                <?= $this->Gus->control('tipo_pessoa', ['div' => 'col s2 m1 l1', 'label' => 'Tipo Pessoa']); ?>
                                                                                                                <?= $this->Gus->control('nome_razaosocial', ['div' => 'col s2 m1 l1', 'label' => 'Nome Razaosocial']); ?>
                                                                                                                <?= $this->Gus->control('sobrenome_nomefantasia', ['div' => 'col s2 m1 l1', 'label' => 'Sobrenome Nomefantasia']); ?>
                                                                                                                <?= $this->Gus->control('cpfcnpj', ['div' => 'col s2 m1 l1', 'label' => 'Cpfcnpj']); ?>
                                                                                                                <?= $this->Gus->control('rua', ['div' => 'col s2 m1 l1', 'label' => 'Rua']); ?>
                                                                                                                <?= $this->Gus->control('numero', ['div' => 'col s2 m1 l1', 'label' => 'Numero']); ?>
                                                                                                                <?= $this->Gus->control('bairro', ['div' => 'col s2 m1 l1', 'label' => 'Bairro']); ?>
                                                                                                                <?= $this->Gus->control('cep', ['div' => 'col s2 m1 l1', 'label' => 'Cep']); ?>
                                                                                                                <?= $this->Gus->control('telefone_1', ['div' => 'col s2 m1 l1', 'label' => 'Telefone 1']); ?>
                                                                                                                <?= $this->Gus->control('telefone_2', ['div' => 'col s2 m1 l1', 'label' => 'Telefone 2']); ?>
                                                                                                                <?= $this->Gus->control('email', ['div' => 'col s2 m1 l1', 'label' => 'Email']); ?>
                                                                                                                <?= $this->Gus->control('cidade_id', ['div' => 'col s2 m1 l1', 'label' => 'Cidade Id']); ?>
                                                                                                                <?= $this->Gus->control('fornecedor_pertencente_id', ['div' => 'col s2 m1 l1', 'label' => 'Fornecedor Pertencente Id']); ?>
                                                                                    <?= $this->Gus->button('<i class="material-icons">filter_list</i>', ['div' => 'input-field col s12 m2 l2 right submit', 'type' => 'submit', 'class' => 'btn waves-effect waves-light']); ?>
                            <?= $this->Gus->end(); ?>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <?= $this->Gus->create('Pessoa', [
        'url' => ['controller' => 'pessoas', 'action' => 'delete'],
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
                        <th scope="col"><?= $this->Paginator->sort('tipo_pessoa') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('nome_razaosocial') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('sobrenome_nomefantasia') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('cpfcnpj') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('rua') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('numero') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('bairro') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('cep') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('telefone_1') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('telefone_2') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('cidade_id') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('fornecedor_pertencente_id') ?></th>
                        <th scope="col" class="actions"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($pessoas as $pessoa): ?>
            <tr>
                <td><input type="checkbox" id="check<?= $pessoa->id ?>" class="filled-in" name="data[ids][<?= $pessoa->id ?>]" value="<?= $pessoa->id ?>" /><label for="check<?= $pessoa->id ?>">&nbsp;</label></td>
                <td><?= $this->Number->format($pessoa->id) ?></td>
                <td><?= h($pessoa->tipo_pessoa) ?></td>
                <td><?= h($pessoa->nome_razaosocial) ?></td>
                <td><?= h($pessoa->sobrenome_nomefantasia) ?></td>
                <td><?= h($pessoa->cpfcnpj) ?></td>
                <td><?= h($pessoa->rua) ?></td>
                <td><?= h($pessoa->numero) ?></td>
                <td><?= h($pessoa->bairro) ?></td>
                <td><?= h($pessoa->cep) ?></td>
                <td><?= h($pessoa->telefone_1) ?></td>
                <td><?= h($pessoa->telefone_2) ?></td>
                <td><?= h($pessoa->email) ?></td>
                <td><?= $pessoa->has('cidade') ? $this->Html->link($pessoa->cidade->displayField, ['controller' => 'Cidades', 'action' => 'view', $pessoa->cidade->id]) : '' ?></td>
                <td><input type="checkbox" id="check<?= $pessoa->fornecedor_pertencente_id ?>" class="filled-in" name="data[ids][<?= $pessoa->fornecedor_pertencente_id ?>]" value="<?= $pessoa->fornecedor_pertencente_id ?>" /><label for="check<?= $pessoa->fornecedor_pertencente_id ?>">&nbsp;</label></td>
                <td><?= $this->Number->format($pessoa->fornecedor_pertencente_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link($this->Gus->materialIcon('edit'), ['action' => 'edit', $pessoa->id], ['escape' => false, 'class' => 'btn btn-floating btn-sm waves-effect waves-light edit']) ?>
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
    var addLink = '<?= Router::url(['controller' => 'pessoas', 'action' => 'add'], true); ?>';
    var editLink = '<?= Router::url(['controller' => 'pessoas', 'action' => 'edit', '--id--'], true); ?>';
    var viewLink = '<?= Router::url(['controller' => 'pessoas', 'action' => 'view', '--id--'], true); ?>';
    var deleteLink = '<?= Router::url(['controller' => 'pessoas', 'action' => 'delete'], true); ?>';
</script>
<?= $this->element('botao_fixo', ['controller' => $this->request->getParam('controller')]) ?>