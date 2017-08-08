<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="pessoas form edit row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Edição de Pessoa'); ?>

    <?= $this->Gus->create($pessoa, ['class' => 'row']) ?>
    <?php
                    echo $this->Gus->control('tipo_pessoa', ['div' => 'col s12 input-field', 'label' => 'Tipo Pessoa']);
                    echo $this->Gus->control('nome_razaosocial', ['div' => 'col s12 input-field', 'label' => 'Nome Razaosocial']);
                    echo $this->Gus->control('sobrenome_nomefantasia', ['div' => 'col s12 input-field', 'label' => 'Sobrenome Nomefantasia']);
                    echo $this->Gus->control('cpfcnpj', ['div' => 'col s12 input-field', 'label' => 'Cpfcnpj']);
                    echo $this->Gus->control('rua', ['div' => 'col s12 input-field', 'label' => 'Rua']);
                    echo $this->Gus->control('numero', ['div' => 'col s12 input-field', 'label' => 'Numero']);
                    echo $this->Gus->control('bairro', ['div' => 'col s12 input-field', 'label' => 'Bairro']);
                    echo $this->Gus->control('cep', ['div' => 'col s12 input-field', 'label' => 'Cep']);
                    echo $this->Gus->control('telefone_1', ['div' => 'col s12 input-field', 'label' => 'Telefone 1']);
                    echo $this->Gus->control('telefone_2', ['div' => 'col s12 input-field', 'label' => 'Telefone 2']);
                    echo $this->Gus->control('email', ['div' => 'col s12 input-field', 'label' => 'Email']);
            echo $this->Gus->selectExtends('cidade_id', $cidades->toArray(), [
                'div' => 'col s12 input-field select2-field',
                'label' => ['text' => 'Cidade', 'class' => 'active'],
                'controller' => 'cidades',
            ]);
                    echo $this->Gus->control('fornecedor_pertencente_id', ['div' => 'col s12 input-field', 'label' => 'Fornecedor Pertencente Id']);
    ?>
    <?= $this->Gus->button('Enviar', ['div' => 'input-field col s2 right', 'class' => 'btn right waves-effect waves-light']) ?>
    <?= $this->Gus->end() ?>
</div>
