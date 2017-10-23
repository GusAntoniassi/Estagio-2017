<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="contaPagars form edit row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Edição de Conta a Pagar'); ?>

    <?= $this->Gus->create($contaPagar, ['class' => 'row']) ?>
    <?php
    echo $this->Gus->control('descricao', ['div' => 'col s3 input-field', 'label' => 'Descrição', 'disabled']);
    echo $this->Gus->control('valor', ['div' => 'col s3 input-field', 'label' => 'Valor', 'type' => 'text', 'disabled', 'value' => (!empty($contaPagar->valor) ? $this->Number->currency($contaPagar->valor) : '')]);
    echo $this->Gus->control('data_cadastro', ['div' => 'col s3 input-field', 'label' => 'Data do cadastro', 'type' => 'text', 'disabled']);
    echo $this->Gus->control('data_pagamento', ['div' => 'col s3 input-field', 'label' => ['class' => 'active', 'text' => 'Data do pagamento'], 'type' => 'text', 'disabled']);
    echo $this->Gus->control('forma_pagamento_id', [
        'div' => 'col s3 input-field select2-field',
        'data-material-select',
        'label' => ['text' => 'Forma de pagamento', 'class' => 'active'],
        'controller' => 'formaPagamentos',
        'disabled',
    ]);
    echo $this->Gus->control('fornecedor_id', [
        'div' => 'col s3 input-field',
        'data-material-select',
        'label' => ['text' => 'Fornecedor', 'class' => 'active'],
        'disabled',
    ]);
    echo $this->Gus->control('compra_id', [
        'div' => 'col s3 input-field select2-field',
        'data-material-select',
        'label' => ['text' => 'Compra', 'class' => 'active'],
        'controller' => 'compras',
        'disabled',
    ]);
    echo $this->Gus->control('pago', ['div' => 'col s3 input-field', 'label' => 'Situação', 'type' => 'select', 'data-material-select', 'disabled', 'options' => [0 => 'Não pago', 1 => 'Pago']]);
    ?>
    <div class="clearfix"></div>
    <br/>
    <div class="col s12">
        <legend style="font-size: 20px; font-weight: 300;">Parcelas</legend>
        <table class="bordered highlight responsive-table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Valor</th>
                    <th>Data de vencimento</th>
                    <th>Pago?</th>
                    <th>Data de pagamento</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contaPagar->parcela_conta_pagars as $idx => $parcela) { ?>
                    <tr <?= ($parcela->pago ? 'class="pago"' : ''); ?>>
                        <td><?= h($parcela->nome); ?></td>
                        <td><?= $this->Number->currency($parcela->valor, 'BRL'); ?></td>
                        <td><?= $this->Time->format($parcela->data_vencimento, 'dd/MM/yyyy'); ?></td>
                        <td><?= $this->Gus->formataBoolean($parcela->pago); ?></td>

                        <?php if (empty($parcela->pagamento)) { ?>
                            <td></td>
                            <td>
                                <a class="waves-effect waves-light btn pagar">Pagar</a>
                                <input type="hidden" name="parcela[<?= $idx ?>][id]" value="<?= $parcela->id ?>" />
                            </td>
                        <?php } else { ?>
                            <td><?= (!empty($parcela->pagamento) ? $this->Time->format($parcela->pagamento->data_pagamento, 'dd/MM/yyyy') : ''); ?></td>
                            <td>
                                <a class="waves-effect waves-light btn disabled">Paga</a>
                            </td>
                        <?php } ?>

                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="clearfix"></div>
    <br/>

    <?= $this->Gus->control('comentarios', ['div' => 'col s12 input-field', 'label' => 'Comentários']); ?>
    <?= $this->Gus->button('Enviar', ['div' => 'input-field col s2 right', 'class' => 'btn right waves-effect waves-light']) ?>
    <?= $this->Gus->end() ?>

    <script>
        var idConta = '<?php echo $contaPagar->id; ?>';

        $(document).on('click', '.btn.pagar', function() {
            var idParcela = $(this).siblings('input[type="hidden"]').val();

            var trataErro = function(json) {
                if (typeof json !== 'undefined' && json.length) {
                    console.error(json);
                }

//                alert('Houve um problema ao realizar o pagamento da parcela. \nPor favor atualize a página e tente novamente.');
            };

            $.post({
                url: '<?= \Cake\Routing\Router::url(['action' => 'pagaParcela'], true); ?>',
                data: {
                    parcela_id: idParcela,
                    conta_id: idConta,
                },
            }).done(function(json) {
                try {
                    json = JSON.parse(json);
                } catch (e) {
                    console.error(e);
                    trataErro();
                }
                if (json['success']) {
                    window.location.reload();
                }
            }).fail(trataErro);
        });
    </script>
</div>
