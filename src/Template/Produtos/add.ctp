<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="produtos form add row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Cadastro de Produto'); ?>

    <?= $this->Gus->create($produto, ['class' => 'row', 'type' => 'file']) ?>
    <?php
    echo $this->Gus->control('status', ['div' => 'col s12 input-field', 'label' => 'Status', 'checked' => 'checked']);
    echo $this->Gus->control('nome', ['div' => 'col s6 m5 input-field', 'label' => 'Nome']);
    echo $this->Gus->selectExtends('tipo_produto_id', $tipoProdutos->toArray(), [
        'div' => 'col s6 m4 input-field select2-field',
        'label' => ['text' => 'Tipo de Produto', 'class' => 'active'],
        'controller' => 'tipoProdutos',
    ]);
    echo $this->Gus->control('custo', ['div' => 'col s6 m3 input-field', 'label' => 'Custo (R$)', 'type' => 'text', 'data-type' => 'money']);
    echo '<div class="clearfix"></div>';
    ?>


    <div class="col s6 file-field input-field">
        <div class="btn">
            <span>Foto</span>
            <?= $this->Gus->input('foto', ['div' => false, 'label' => false, 'type' => 'file']); ?>
        </div>
        <div class="file-path-wrapper">
            <input class="file-path" type="text">
        </div>
    </div>
    <?php
    echo $this->Gus->control('produto_acabado', ['div' => 'col input-field', 'label' => 'Produto acabado']);
    echo $this->Gus->control('reduz_estoque', ['div' => 'col input-field', 'label' => 'Reduz estoque']);
    echo $this->Gus->control('possui_lote', ['div' => 'col input-field', 'label' => 'Possui lote']);
    echo '<div class="clearfix"></div><br/>';
    ?>
    <?php
    echo $this->Gus->control('preco', ['div' => 'col s6 m3 input-field', 'label' => 'Preço (R$)', 'type' => 'text', 'data-type' => 'money']);
    ?>
    <?= $this->Gus->button('Enviar', ['div' => 'input-field col s2 right', 'class' => 'btn right waves-effect waves-light']) ?>
    <?= $this->Gus->end() ?>

    <script>
        $('#produto-acabado').on('change', function() {
            $('#preco').closest('.input-field').toggleClass('invisible', !$(this).prop('checked'));
        });
        $('#produto-acabado').trigger('change');
    </script>
</div>
