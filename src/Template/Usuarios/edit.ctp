<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="usuarios form edit row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Edição de Usuario'); ?>

    <?= $this->Gus->create($usuario, ['class' => 'row']) ?>
    <?php
                    echo $this->Gus->control('status', ['div' => 'col s12 input-field', 'label' => 'Status']);
                    echo $this->Gus->control('login', ['div' => 'col s12 input-field', 'label' => 'Login']);
                    echo $this->Gus->control('senha', ['div' => 'col s12 input-field', 'label' => 'Senha']);
                    echo $this->Gus->control('salt', ['div' => 'col s12 input-field', 'label' => 'Salt']);
        echo $this->Gus->control('grupo_usuario_id', ['div' => 'col s12 input-field select2-field', 'label' => ['text' => 'Grupo Usuario Id', 'class' => 'active'], 'options' => $grupoUsuarios, 'data-select-2']);
    ?>
    <?= $this->Gus->button('Enviar', ['div' => 'input-field col s2 right', 'class' => 'btn right waves-effect waves-light']) ?>
    <?= $this->Gus->end() ?>
</div>
