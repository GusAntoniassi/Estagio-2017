<?php
/**
  * @var \App\View\AppView $this
  */
    use Cake\Routing\Router;
?>
<div class="lotes form edit row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Edição de Lote'); ?>

    <?= $this->Gus->create($lote, ['class' => 'row']) ?>
    <?php
    echo $this->Gus->control('status', ['div' => 'col s12 input-field', 'label' => 'Status', 'checked' => 'checked']);
    echo $this->Gus->control('num_lote', ['div' => 'col s12 m4 l5 input-field', 'label' => 'Número do lote']);
    echo $this->Gus->control('qtde_estoque', ['div' => 'col s12 m4 l3 input-field', 'label' => 'Qtde em estoque', 'type' => 'number', 'min' => 0]);
    echo $this->Gus->control('data_vencimento', ['div' => 'col s12 m4 l4 input-field', 'label' => 'Data de vencimento', 'type' => 'text', 'data-type' => 'date']);
    echo $this->Gus->selectAjaxExtends('produto_id',
        [
            'div' => 'col s12 m6 l5 input-field',
            'attributes' => [
                'class' => 'browser-default select2ajax',
                'type' => 'select',
                'placeholder' => 'Digite para buscar...',
            ],
            'label' => ['text' => 'Produto', 'class' => 'active'],
            'controller' => 'produtos',
            'ajax' => true,
        ], $produtos->toArray()
    );
    ?>
    <div class="clearfix"></div>
    <?= $this->Gus->button('Enviar', ['div' => 'input-field col s2 right', 'class' => 'btn right waves-effect waves-light']) ?>
    <?= $this->Gus->end() ?>

    <script>
        $(function() {
            $.fn.select2.defaults.set('language', 'pt-BR');
            $('select[name="produto_id"]').data('ajax', {
                url: '<?= Router::url(['controller' => 'produtos', 'action' => 'select2ajax']); ?>',
                dataType: 'json',
                type: 'GET',
                data: function(params) {
                    return {q: params.term, possui_lote: 1}
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name,
                                id: item.id,
                            }
                        })
                    }
                }
            });
            $('select[name="produto_id"]').select2({
                ajax: $(this).data('ajax'),
                minimumInputLength: 1,
                placeholder: $('select[name="produto_id"]').attr('placeholder'),
            });
        });
    </script>
</div>
