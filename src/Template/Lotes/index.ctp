<?php
use Cake\Routing\Router;

/**
 * @var \App\View\AppView $this
 */
?>
    <div class="lotes index list row card-panel">
        <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
        <?php $this->assign('title', 'Lote'); ?>
        <div class="row filtros">
            <div class="col s12">
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header"><?= $this->Gus->materialIcon('filter_list'); ?> Filtros</div>
                        <div class="collapsible-body">
                            <div class="row">
                                <?= $this->Gus->create(); ?>
                                <?= $this->Gus->control('id', ['div' => 'col s2 m1 l1', 'label' => 'ID']); ?>
                                <?= $this->Gus->control('num_lote', ['div' => 'col s10 m3 l3', 'label' => 'Nº do lote']); ?>
                                <?= $this->Gus->control('produto_id',
                                    [
                                        'type' => 'select',
                                        'div' => 'col s9 m4 l4',
                                        'class' => 'browser-default select2ajax',
                                        'placeholder' => 'Digite para buscar...',
                                        'label' => ['text' => 'Produto', 'class' => 'active'],
                                        'options' => $produtos->toArray()
                                    ]
                                ); ?>
                                <?= $this->Gus->control('status', ['type' => 'select', 'data-material-select', 'div' => 'col s3 m2 l2', 'label' => 'Status', 'options' => $this->Gus->getStatusOptions()]); ?>
                                <?= $this->Gus->control('Filtrar', ['div' => 'col s12 m2 l2 right', 'type' => 'submit', 'class' => 'btn waves-effect waves-light']); ?>
                                <?= $this->Gus->end(); ?>
                            </div>
                        </div>

                        <script>
                            $(function() {
                                $.fn.select2.defaults.set('language', 'pt-BR');
                                $('select[name="produto_id"]').data('ajax', {
                                    url: '<?= Router::url(['controller' => 'produtos', 'action' => 'select2ajax']); ?>',
                                    dataType: 'json',
                                    type: 'GET',
                                    data: function(params) {
                                        return {q: params.term}
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
                                    allowClear: true,
                                });
                            });
                        </script>
                    </li>
                </ul>
            </div>
        </div>

        <?= $this->Gus->create('Lote', [
            'url' => ['controller' => 'lotes', 'action' => 'delete'],
            'method' => 'post',
            'class' => 'hide',
            'id' => 'form-delete',
        ]); ?>
        <?php // <input name="ids[]" type="hidden" value="1" /> ?>
        <?= $this->Gus->end(); ?>

        <table class="responsive-table index highlight">
            <thead>
            <tr>
                <th scope="col">
                    <input type="checkbox" class="filled-in" id="check-all"/><label for="check-all">&nbsp;</label>
                </th>
                <th scope="col"><?= $this->Paginator->sort('id', 'ID') ?></th>
                <th scope="col"><?= $this->Paginator->sort('num_lote', 'Nº do lote') ?></th>
                <th scope="col"><?= $this->Paginator->sort('qtde_estoque', 'Qtde em estoque') ?></th>
                <th scope="col"><?= $this->Paginator->sort('data_vencimento', 'Data de vencimento') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('produto_id') ?></th>
                <th scope="col" class="actions"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($lotes as $lote): ?>
                <tr>
                    <td><input type="checkbox" id="check<?= $lote->id ?>" class="filled-in"
                               name="data[ids][<?= $lote->id ?>]" value="<?= $lote->id ?>"/><label
                                for="check<?= $lote->id ?>">&nbsp;</label></td>
                    <td><?= $this->Number->format($lote->id) ?></td>
                    <td><?= h($lote->num_lote) ?></td>
                    <td><?= $this->Number->format($lote->qtde_estoque) ?></td>
                    <td><?= h($lote->data_vencimento) ?></td>
                    <td><?= $this->Gus->formataStatus($lote->status) ?></td>
                    <td><?= $lote->has('produto') ? $this->Html->link($lote->produto->displayField, ['controller' => 'Produtos', 'action' => 'view', $lote->produto->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link($this->Gus->materialIcon('edit'), ['action' => 'edit', $lote->id], ['escape' => false, 'class' => 'btn btn-floating btn-sm waves-effect waves-light edit']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <div class="paginator">
            <ul class="pagination">
                <?= $this->Gus->paginatorControls(); ?>
            </ul>
            <p><?= $this->Paginator->counter() ?></p>
        </div>
    </div>
    <script>
        var addLink = '<?= Router::url(['controller' => 'lotes', 'action' => 'add'], true); ?>';
        var editLink = '<?= Router::url(['controller' => 'lotes', 'action' => 'edit', '--id--'], true); ?>';
        var viewLink = '<?= Router::url(['controller' => 'lotes', 'action' => 'view', '--id--'], true); ?>';
        var deleteLink = '<?= Router::url(['controller' => 'lotes', 'action' => 'delete'], true); ?>';
    </script>
<?= $this->element('botao_fixo', ['controller' => $this->request->getParam('controller')]) ?>