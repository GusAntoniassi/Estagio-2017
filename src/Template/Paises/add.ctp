<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="paises form add row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Cadastro de País'); ?>

    <?= $this->Gus->create($pais, ['class' => 'row']) ?>
    <?php
    echo $this->Gus->control('status', ['div' => 'col s12 input-field', 'label' => 'Status', 'checked' => 'checked']);
    echo $this->Gus->control('nome', ['div' => 'col s10 input-field', 'label' => 'Nome']);
    echo $this->Gus->control('sigla', ['div' => 'col s2 input-field', 'label' => 'Sigla']);
    ?>
    <?= $this->Gus->button('Enviar', ['div' => 'input-field col s2 right', 'class' => 'btn right waves-effect waves-light']) ?>
    <?= $this->Gus->end() ?>
</div>
