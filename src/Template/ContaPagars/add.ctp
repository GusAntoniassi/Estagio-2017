<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="contaPagars form add row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Cadastro de ContaPagar'); ?>

    <?= $this->Gus->create($contaPagar, ['class' => 'row']) ?>
    <?php
    echo $this->Gus->control('descricao', ['div' => 'col s6 input-field', 'label' => 'Descrição']);
    echo $this->Gus->control('valor', [
        'div' => 'col s3 input-field',
        'label' => 'Valor (R$)',
        'type' => 'text',
        'data-type' => 'money',
        'value' => (!empty($contaPagar->valor) ? $this->Number->currency($contaPagar->valor) : '')
    ]);
    echo $this->Gus->control('pago', [
        'div' => 'col s3 input-field',
        'label' => 'Situação',
        'type' => 'select',
        'data-material-select',
        'options' => [0 => 'Não pago', 1 => 'Pago'],
        'disabled',
    ]);
    echo $this->Gus->selectExtends('forma_pagamento_id', $formaPagamentos->toArray(), [
        'div' => 'col s4 input-field select2-field',
        'data-material-select',
        'label' => ['text' => 'Forma de pagamento', 'class' => 'active'],
        'controller' => 'formaPagamentos',
    ]);
    echo $this->Gus->selectExtends('fornecedor_id', $fornecedores->toArray(), [
        'div' => 'col s4 input-field',
        'data-material-select',
        'label' => ['text' => 'Fornecedor', 'class' => 'active'],
        'controller' => 'fornecedores',
    ]);
    ?>
    <?= $this->Gus->button('Enviar', ['div' => 'input-field col s2 right', 'class' => 'btn right waves-effect waves-light']) ?>
    <?= $this->Gus->end() ?>
</div>
