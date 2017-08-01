<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="tipoProdutos form edit row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Edição de Tipo de Produto'); ?>

    <?= $this->Gus->create($tipoProduto, ['class' => 'row']) ?>
    <?php
    echo $this->Gus->control('status', ['div' => 'col s12 input-field', 'label' => 'Status']);
    echo $this->Gus->control('nome', ['div' => 'col s12 input-field', 'label' => 'Nome']);
    ?>
    <?= $this->Gus->button('Enviar', ['div' => 'input-field col s2 right', 'class' => 'btn right waves-effect waves-light']) ?>
    <?= $this->Gus->end() ?>
</div>
