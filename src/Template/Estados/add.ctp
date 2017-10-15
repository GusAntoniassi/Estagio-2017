<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="estados form add row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Cadastro de Estado'); ?>

    <?= $this->Gus->create($estado, ['class' => 'row']) ?>
    <?php
    echo $this->Gus->control('status', ['div' => 'col s12 input-field', 'label' => 'Status', 'checked' => 'checked']);
    echo $this->Gus->control('nome', ['div' => 'col s6 input-field', 'label' => 'Nome']);
    echo $this->Gus->control('sigla', ['div' => 'col s1 input-field', 'label' => 'Sigla']);
    echo $this->Gus->control('pais_id', ['div' => 'col s5 input-field', 'data-material-select', 'label' => ['text' => 'País', 'class' => 'active']]);
    ?>
    <?= $this->Gus->button('Enviar', ['div' => 'input-field col s2 right', 'class' => 'btn right waves-effect waves-light']) ?>
    <?= $this->Gus->end() ?>

    <script type="text/javascript">
        // Quando clicar no botão de atualizar
        $('#botao-atualizar').on('click', function () {
            // Envia a requisição AJAX
            $.ajax({
                url: 'http://localhost/estagio2017/paises/getPaises',
                // Se a requisição foi um sucesso
                success: function (data) {
                    // Substitui o html do select antigo pelo html do select que buscamos do banco
                    $('#paisId').html(data);
                }
            })
        })
    </script>
</div>
