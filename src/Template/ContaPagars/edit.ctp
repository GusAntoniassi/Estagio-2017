<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="contaPagars form edit row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Edição de ContaPagar'); ?>

    <?= $this->Gus->create($contaPagar, ['class' => 'row']) ?>
    <?php
                    echo $this->Gus->control('descricao', ['div' => 'col s12 input-field', 'label' => 'Descricao']);
                    echo $this->Gus->control('valor', ['div' => 'col s12 input-field', 'label' => 'Valor']);
        echo $this->Gus->control('data_cadastro', ['div' => 'col s12 input-field', 'label' => 'Data Cadastro', 'type' => 'text', 'data-type' => 'datetime']);
        echo $this->Gus->control('data_pagamento', ['div' => 'col s12 input-field', 'label' => 'Data Pagamento', 'type' => 'text', 'data-type' => 'datetime']);
                    echo $this->Gus->control('pago', ['div' => 'col s12 input-field', 'label' => 'Pago']);
                    echo $this->Gus->control('num_parcelas', ['div' => 'col s12 input-field', 'label' => 'Num Parcelas']);
                    echo $this->Gus->control('comentarios', ['div' => 'col s12 input-field', 'label' => 'Comentarios']);
            echo $this->Gus->selectExtends('fornecedor_id', $fornecedores->toArray(), [
                'div' => 'col s12 input-field select2-field',
                'label' => ['text' => 'Fornecedor', 'class' => 'active'],
                'controller' => 'fornecedores',
            ]);
            echo $this->Gus->selectExtends('compra_id', $compras->toArray(), [
                'div' => 'col s12 input-field select2-field',
                'label' => ['text' => 'Compra', 'class' => 'active'],
                'controller' => 'compras',
            ]);
            echo $this->Gus->selectExtends('forma_pagamento_id', $formaPagamentos->toArray(), [
                'div' => 'col s12 input-field select2-field',
                'label' => ['text' => 'FormaPagamento', 'class' => 'active'],
                'controller' => 'formaPagamentos',
            ]);
    ?>
    <?= $this->Gus->button('Enviar', ['div' => 'input-field col s2 right', 'class' => 'btn right waves-effect waves-light']) ?>
    <?= $this->Gus->end() ?>
</div>
