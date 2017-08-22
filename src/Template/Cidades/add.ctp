<?php
/**
 * @var \App\View\AppView $this
 */
use Cake\Routing\Router;
?>
<div class="cidades form add row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Cadastro de Cidade'); ?>

    <?= $this->Gus->create($cidade, ['class' => 'row']) ?>
    <?php
    echo $this->Gus->control('status', ['div' => 'col s12 input-field', 'label' => 'Status', 'checked' => 'checked']);
    echo $this->Gus->control('nome', ['div' => 'col s6 input-field', 'label' => 'Nome']);
    echo $this->Gus->selectAjaxExtends('estado_id',
        [
            'div' => 'col s6 input-field',
            'attributes' => [
                'class' => 'browser-default select2ajax',
                'type' => 'select',
                'placeholder' => 'Digite para buscar...'
            ],
            'label' => ['text' => 'Estado', 'class' => 'active'],
            'controller' => 'estados',
            'ajax' => true
        ]
    );
    ?>
    <?= $this->Gus->button('Enviar', ['div' => 'input-field col s2 right', 'class' => 'btn right waves-effect waves-light']) ?>
    <?= $this->Gus->end() ?>

    <script>
        $(function() {
            $.fn.select2.defaults.set('language', 'pt-BR');
            $('select[name="estado_id"]').data('ajax', {
                url: '<?= Router::url(['controller' => 'estados', 'action' => 'select2ajax']); ?>',
                dataType: 'json',
                type: 'GET',
                data: function(params) {
                    return {q: params.term}
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            console.log(item);
                            return {
                                text: item.name,
                                id: item.id,
                            }
                        })
                    }
                }
            });
            $('select[name="estado_id"]').select2({
                ajax: $(this).data('ajax'),
                minimumInputLength: 1,
                placeholder: $('select[name="estado_id"]').attr('placeholder'),
            });
        });
    </script>
</div>
