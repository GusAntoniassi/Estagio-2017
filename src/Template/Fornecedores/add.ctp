<?php
/**
  * @var \App\View\AppView $this
  */
use Cake\Routing\Router;
?>
<div class="fornecedores form add row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Cadastro de Fornecedor'); ?>

    <?= $this->Gus->create($fornecedor, ['class' => 'row']) ?>

    <?= $this->Gus->control('Fornecedor.status', ['div' => 'col s12 input-field', 'label' => 'Status', 'checked' => 'checked']); ?>
    <div class="col s12">
        <h5><strong>Dados da pessoa</strong></h5>
    </div>
    <?php
        $tipoPessoa = (!empty($this->request->getData('Pessoa.tipo_pessoa')) ?
            $this->request->getData('Pessoa.tipo_pessoa') : 'F');
        // Campos cadastro de pessoa
        echo $this->Gus->control('Pessoa.tipo_pessoa', [
            'div' => 'col s12 input-field',
            'label' => false,
            'type' => 'radio',
            'data-type' => 'tipo-pessoa',
            'options' => ['F' => 'Pessoa física', 'J' => 'Pessoa jurídica'],
            'value' => $tipoPessoa
        ]);
    ?>
    <div class="clearfix"></div>
    <?php
        echo $this->Gus->control('Pessoa.nome_razaosocial', ['div' => 'col s6 input-field', 'label' => $this->Gus->getPessoaLabel('nome_razaosocial', $tipoPessoa)]);
        echo $this->Gus->control('Pessoa.sobrenome_nomefantasia', ['div' => 'col s6 input-field', 'label' => $this->Gus->getPessoaLabel('sobrenome_nomefantasia', $tipoPessoa)]);
        echo $this->Gus->control('Pessoa.cpfcnpj', ['div' => 'col s3 input-field', 'label' => $this->Gus->getPessoaLabel('cpfcnpj', $tipoPessoa), 'data-type' => 'cpf']);
        echo $this->Gus->control('Pessoa.email', ['div' => 'col s3 input-field', 'label' => 'E-mail']);
        echo $this->Gus->control('Pessoa.telefone_1', ['div' => 'col s3 input-field', 'label' => 'Telefone principal', 'data-type' => 'phone']);
        echo $this->Gus->control('Pessoa.telefone_2', ['div' => 'col s3 input-field', 'label' => 'Telefone secundário', 'data-type' => 'phone']);
    ?>
    <div class="col s12">
        <h5><strong>Endereço</strong></h5>
    </div>
    <?php
        echo $this->Gus->control('Pessoa.cep', ['div' => 'col s3 input-field', 'label' => 'CEP', 'data-type' => 'cep']);
        echo $this->Gus->control('Pessoa.rua', ['div' => 'col s7 input-field invisible cep-toggle', 'data-cep' => 'logradouro', 'label' => 'Logradouro']);
        echo $this->Gus->control('Pessoa.numero', ['div' => 'col s2 input-field invisible cep-toggle', 'label' => 'Número']);
        echo $this->Gus->control('Pessoa.bairro', ['div' => 'col s3 input-field invisible cep-toggle', 'data-cep' => 'bairro',  'label' => 'Bairro']);
        echo $this->Gus->selectAjaxExtends('Pessoa.cidade_id',
        [
            'div' => 'col s4 input-field invisible cep-toggle',
            'attributes' => [
                'class' => 'browser-default select2ajax',
                'type' => 'select',
                'placeholder' => 'Digite para buscar...',
                'data-cep' => 'cidade'
            ],
            'label' => ['text' => 'Cidade', 'class' => 'active'],
            'controller' => 'cidades',
            'ajax' => true,
        ]);
    ?>
    <div class="col-sm-12">
        <div class="progress invisible">
            <div class="indeterminate"></div>
        </div>
    </div>
    <div class="clearfix"></div>
    <script> // Configurar select2ajax
        $(function() {
            $.fn.select2.defaults.set('language', 'pt-BR');
            $('select[name="Pessoa[cidade_id]"]').data('ajax', {
                url: '<?= Router::url(['controller' => 'cidades', 'action' => 'select2ajax']); ?>',
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
            $('select[name="Pessoa[cidade_id]"]').select2({
                ajax: $(this).data('ajax'),
                minimumInputLength: 1,
                placeholder: $('select[name="Pessoa[cidade_id]"]').attr('placeholder'),
            });
        });
    </script>
    <div class="col s12">
        <h5><strong>Dados do fornecedor</strong></h5>
    </div>
    <?php
        // Campos exclusivos ao cadastro de fornecedores
        echo $this->Gus->control('Fornecedor.comentarios', ['div' => 'col s12 input-field', 'label' => 'Comentários']);
        echo $this->Gus->control('Fornecedor.dia_semana_visita', ['type' => 'select', 'div' => 'col s3 input-field', 'data-material-select', 'label' => 'Dia da semana em que visita', 'options' => $diasSemana]);
    ?>
    <div class="clearfix"></div>
    <?= $this->Gus->button('Enviar', ['div' => 'input-field col s2 right', 'class' => 'btn right waves-effect waves-light']) ?>
    <?= $this->Gus->end() ?>

    <script>
    $(function() {
        if ($('input[data-type="cep"]').val().length) {
            completaCep();
        }
        $('input[data-type="tipo-pessoa"]').on('change', function() {
            tipoPessoa(this);
        });
    });
    </script>
</div>
