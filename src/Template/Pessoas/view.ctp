<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="pessoas view card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Visualizar Pessoa'); ?>
    <table class="bordered highlight">
                                <tr>
            <th scope="row"><?= __('Tipo Pessoa') ?></th>
            <td><?= h($pessoa->tipo_pessoa) ?></td>
        </tr>
                                <tr>
            <th scope="row"><?= __('Nome Razaosocial') ?></th>
            <td><?= h($pessoa->nome_razaosocial) ?></td>
        </tr>
                                <tr>
            <th scope="row"><?= __('Sobrenome Nomefantasia') ?></th>
            <td><?= h($pessoa->sobrenome_nomefantasia) ?></td>
        </tr>
                                <tr>
            <th scope="row"><?= __('Cpfcnpj') ?></th>
            <td><?= h($pessoa->cpfcnpj) ?></td>
        </tr>
                                <tr>
            <th scope="row"><?= __('Rua') ?></th>
            <td><?= h($pessoa->rua) ?></td>
        </tr>
                                <tr>
            <th scope="row"><?= __('Numero') ?></th>
            <td><?= h($pessoa->numero) ?></td>
        </tr>
                                <tr>
            <th scope="row"><?= __('Bairro') ?></th>
            <td><?= h($pessoa->bairro) ?></td>
        </tr>
                                <tr>
            <th scope="row"><?= __('Cep') ?></th>
            <td><?= h($pessoa->cep) ?></td>
        </tr>
                                <tr>
            <th scope="row"><?= __('Telefone 1') ?></th>
            <td><?= h($pessoa->telefone_1) ?></td>
        </tr>
                                <tr>
            <th scope="row"><?= __('Telefone 2') ?></th>
            <td><?= h($pessoa->telefone_2) ?></td>
        </tr>
                                <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($pessoa->email) ?></td>
        </tr>
                                <tr>
            <th scope="row"><?= __('Cidade') ?></th>
            <td><?= $pessoa->has('cidade') ? $this->Html->link($pessoa->cidade->nome, ['controller' => 'Cidades', 'action' => 'view', $pessoa->cidade->id]) : '' ?></td>
        </tr>
                            </table>
</div>