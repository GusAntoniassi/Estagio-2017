<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="formaPagamentos form add row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Cadastro de Forma de Pagamento'); ?>

    <?= $this->Gus->create($formaPagamento, ['class' => 'row']) ?>
    <?php
    echo $this->Gus->control('status', ['div' => 'col s12 input-field', 'label' => 'Status', 'checked' => 'checked']);
    echo $this->Gus->control('nome', ['div' => 'col s12 m4 l4 input-field', 'label' => 'Nome']);
    echo $this->Gus->control('num_parcelas', ['div' => 'col s12 m4 l2 input-field', 'label' => 'Número de parcelas', 'min' => 1]);
    echo $this->Gus->control('dias_carencia_primeira_parcela', ['div' => 'col s12 m4 l3 input-field', 'label' => 'Dias de carência p/ primeira parcela', 'min' => 0]);
    ?>
    <?= $this->Gus->button('Enviar', ['div' => 'input-field col s2 right', 'class' => 'btn right waves-effect waves-light']) ?>
    <?= $this->Gus->end() ?>
</div>
