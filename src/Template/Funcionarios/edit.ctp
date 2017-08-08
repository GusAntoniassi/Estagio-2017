<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="funcionarios form edit row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Edição de Funcionario'); ?>

    <?= $this->Gus->create($funcionario, ['class' => 'row']) ?>
    <?php
                    echo $this->Gus->control('status', ['div' => 'col s12 input-field', 'label' => 'Status']);
        echo $this->Gus->control('data_nascimento', ['div' => 'col s12 input-field', 'label' => 'Data Nascimento', 'type' => 'text', 'data-type' => 'date']);
                    echo $this->Gus->control('horista', ['div' => 'col s12 input-field', 'label' => 'Horista']);
                    echo $this->Gus->control('valor_hora', ['div' => 'col s12 input-field', 'label' => 'Valor Hora']);
            echo $this->Gus->selectExtends('pessoa_id', $pessoas->toArray(), [
                'div' => 'col s12 input-field select2-field',
                'label' => ['text' => 'Pessoa', 'class' => 'active'],
                'controller' => 'pessoas',
            ]);
    ?>
    <?= $this->Gus->button('Enviar', ['div' => 'input-field col s2 right', 'class' => 'btn right waves-effect waves-light']) ?>
    <?= $this->Gus->end() ?>
</div>
