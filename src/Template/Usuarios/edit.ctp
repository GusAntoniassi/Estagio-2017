<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="usuarios form edit row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Edição de Usuário'); ?>

    <?= $this->Gus->create($usuario, ['class' => 'row']) ?>
    <?php
    echo $this->Gus->control('status', ['div' => 'col s12 input-field', 'label' => 'Status']);
    echo $this->Gus->control('login', ['div' => 'col s4 input-field', 'label' => 'Login']);
    echo $this->Gus->control('senha', ['div' => 'col s4 input-field', 'label' => 'Senha', 'type' => 'password']);
    echo $this->Gus->control('grupo_usuario_id', ['div' => 'col s4 input-field select2-field', 'label' => ['text' => 'Grupo de Usuários', 'class' => 'active'], 'options' => $grupoUsuarios, 'data-select-2']);
    ?>
    <?= $this->Gus->button('Enviar', ['div' => 'input-field col s2 right', 'class' => 'btn right waves-effect waves-light']) ?>
    <?= $this->Gus->end() ?>
</div>
