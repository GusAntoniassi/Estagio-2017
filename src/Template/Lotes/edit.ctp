<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="lotes form edit row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Edição de Lote'); ?>

    <?= $this->Gus->create($lote, ['class' => 'row']) ?>
    <?php
                    echo $this->Gus->control('status', ['div' => 'col s12 input-field', 'label' => 'Status']);
                    echo $this->Gus->control('num_lote', ['div' => 'col s12 input-field', 'label' => 'Num Lote']);
                    echo $this->Gus->control('qtde_estoque', ['div' => 'col s12 input-field', 'label' => 'Qtde Estoque']);
        echo $this->Gus->control('data_vencimento', ['div' => 'col s12 input-field', 'label' => 'Data Vencimento', 'type' => 'text', 'data-type' => 'date']);
            echo $this->Gus->selectExtends('produto_id', $produtos->toArray(), [
                'div' => 'col s12 input-field select2-field',
                'label' => ['text' => 'Produto', 'class' => 'active'],
                'controller' => 'produtos',
            ]);
    ?>
    <?= $this->Gus->button('Enviar', ['div' => 'input-field col s2 right', 'class' => 'btn right waves-effect waves-light']) ?>
    <?= $this->Gus->end() ?>
</div>
