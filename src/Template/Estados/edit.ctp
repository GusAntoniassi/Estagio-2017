<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="estados form edit row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Edição de Estado'); ?>

    <?= $this->Gus->create($estado, ['class' => 'row']) ?>
    <?php
    echo $this->Gus->control('status', ['div' => 'col s12 input-field', 'label' => 'Status']);
    echo $this->Gus->control('nome', ['div' => 'col s8 m6 input-field', 'label' => 'Nome']);
    echo $this->Gus->control('sigla', ['div' => 'col s4 m1 input-field', 'label' => 'Sigla']);
    echo $this->Gus->control('pais_id', ['div' => 'col s5 input-field', 'data-material-select', 'label' => ['text' => 'País', 'class' => 'active']]);
    ?>
    <?= $this->Gus->button('Enviar', ['div' => 'input-field col s2 right', 'class' => 'btn right waves-effect waves-light']) ?>
    <?= $this->Gus->end() ?>
</div>
