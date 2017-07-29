<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="cidades form edit row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Edição de Cidade'); ?>

    <?= $this->Gus->create($cidade, ['class' => 'row']) ?>
    <?php
                    echo $this->Gus->control('status', ['div' => 'col s12 input-field', 'label' => 'Status']);
                    echo $this->Gus->control('nome', ['div' => 'col s12 input-field', 'label' => 'Nome']);
            echo $this->Gus->selectExtends('estado_id', $estados->toArray(), [
                'div' => 'col s12 input-field select2-field',
                'label' => ['text' => 'Estado', 'class' => 'active'],
                'controller' => 'estados',
            ]);
    ?>
    <?= $this->Gus->button('Enviar', ['div' => 'input-field col s2 right', 'class' => 'btn right waves-effect waves-light']) ?>
    <?= $this->Gus->end() ?>
</div>
