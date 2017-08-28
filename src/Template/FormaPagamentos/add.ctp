<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="formaPagamentos form add row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Cadastro de FormaPagamento'); ?>

    <?= $this->Gus->create($formaPagamento, ['class' => 'row']) ?>
    <?php
                    echo $this->Gus->control('status', ['div' => 'col s12 input-field', 'label' => 'Status', 'checked' => 'checked']);
                    echo $this->Gus->control('nome', ['div' => 'col s12 input-field', 'label' => 'Nome']);
                    echo $this->Gus->control('num_parcelas', ['div' => 'col s12 input-field', 'label' => 'Num Parcelas']);
                    echo $this->Gus->control('dias_carencia_primeira_parcela', ['div' => 'col s12 input-field', 'label' => 'Dias Carencia Primeira Parcela']);
                    echo $this->Gus->control('entrada', ['div' => 'col s12 input-field', 'label' => 'Entrada']);
    ?>
    <?= $this->Gus->button('Enviar', ['div' => 'input-field col s2 right', 'class' => 'btn right waves-effect waves-light']) ?>
    <?= $this->Gus->end() ?>
</div>
