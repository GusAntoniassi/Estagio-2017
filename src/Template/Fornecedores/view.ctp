<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="fornecedores view card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Visualizar Fornecedor'); ?>
    <table class="bordered highlight">
        <tr>
            <th scope="row"><?= __('Tipo de pessoa') ?></th>
            <td><?= $this->Gus->tipoPessoaPorExtenso($fornecedor->pessoa->tipo_pessoa) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= $this->Gus->getPessoaLabel('nome_razaosocial', $fornecedor->pessoa->tipo_pessoa) ?></th>
            <td><?= $fornecedor->pessoa->nome_razaosocial ?></td>
        </tr>
        <tr>
            <th scope="row"><?= $this->Gus->getPessoaLabel('sobrenome_nomefantasia', $fornecedor->pessoa->tipo_pessoa) ?></th>
            <td><?= $fornecedor->pessoa->sobrenome_nomefantasia ?></td>
        </tr>
        <tr>
            <th scope="row"><?= $this->Gus->getPessoaLabel('cpfcnpj', $fornecedor->pessoa->tipo_pessoa) ?></th>
            <td><?= $fornecedor->pessoa->cpfcnpj ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('E-mail') ?></th>
            <td><?= $fornecedor->pessoa->email ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Telefone principal') ?></th>
            <td><?= $fornecedor->pessoa->telefone_1 ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Telefone secundário') ?></th>
            <td><?= $fornecedor->pessoa->telefone_2 ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('CEP') ?></th>
            <td><?= $fornecedor->pessoa->cep ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Logradouro') ?></th>
            <td><?= $fornecedor->pessoa->rua ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Número') ?></th>
            <td><?= $fornecedor->pessoa->numero ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Bairro') ?></th>
            <td><?= $fornecedor->pessoa->bairro ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cidade') ?></th>
            <td><?= $fornecedor->pessoa->cidade->cidade_estado ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Dia da semana em que visita') ?></th>
            <td>
                <?php
                    $dia = ($fornecedor->dia_semana_visita === FALSE ? '' : $fornecedor->dia_semana_visita);
                    echo (!empty($diasSemana) ? $diasSemana[$dia] : '')
                ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><?= __('Comentários') ?></th>
            <td><?= $fornecedor->comentarios ?></td>
        </tr>
    </table>
</div>