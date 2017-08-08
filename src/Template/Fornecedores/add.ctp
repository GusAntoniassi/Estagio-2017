<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="fornecedores form add row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Cadastro de Fornecedor'); ?>

    <?= $this->Gus->create($fornecedor, ['class' => 'row']) ?>
    <?php
                    echo $this->Gus->control('status', ['div' => 'col s12 input-field', 'label' => 'Status', 'checked' => 'checked']);
                    echo $this->Gus->control('comentarios', ['div' => 'col s12 input-field', 'label' => 'Comentarios']);
                    echo $this->Gus->control('dia_semana_visita', ['div' => 'col s12 input-field', 'label' => 'Dia Semana Visita']);
            echo $this->Gus->selectExtends('pessoa_id', $pessoas->toArray(), [
                'div' => 'col s12 input-field select2-field',
                'label' => ['text' => 'Pessoa', 'class' => 'active'],
                'controller' => 'pessoas',
            ]);
    ?>
    <?= $this->Gus->button('Enviar', ['div' => 'input-field col s2 right', 'class' => 'btn right waves-effect waves-light']) ?>
    <?= $this->Gus->end() ?>
</div>
