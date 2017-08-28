<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="funcionarios form add row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Cadastro de Funcionario'); ?>

    <?= $this->Gus->create($funcionario, ['class' => 'row']) ?>
    <?php
    echo $this->Gus->control('status', ['div' => 'col s12 input-field', 'label' => 'Status', 'checked' => 'checked']);

    echo $this->Gus->control('Pessoa.tipo_pessoa', ['div' => 'col s12 input-field', 'label' => false, 'type' => 'radio', 'options' => ['F' => 'Pessoa física', 'J' => 'Pessoa jurídica']]);
    echo $this->Gus->control('Pessoa.nome_razaosocial', ['div' => 'col s12 input-field', 'label' => 'Nome']);
    echo $this->Gus->control('Pessoa.sobrenome_nomefantasia', ['div' => 'col s12 input-field', 'label' => 'Sobrenome']);
    echo $this->Gus->control('Pessoa.cpfcnpj', ['div' => 'col s12 input-field', 'label' => 'CPF', 'data-type' => 'cpf']);
    echo $this->Gus->control('Pessoa.cep', ['div' => 'col s12 input-field', 'label' => 'CEP', 'data-type' => 'cep']);
    echo $this->Gus->control('Pessoa.rua', ['div' => 'col s12 input-field', 'label' => 'Endereço']);
    echo $this->Gus->control('Pessoa.numero', ['div' => 'col s12 input-field', 'label' => 'Número']);
    echo $this->Gus->control('Pessoa.bairro', ['div' => 'col s12 input-field', 'label' => 'Bairro']);
    echo $this->Gus->control('Pessoa.telefone_1', ['div' => 'col s12 input-field', 'label' => 'Telefone principal', 'data-type' => 'phone']);
    echo $this->Gus->control('Pessoa.telefone_2', ['div' => 'col s12 input-field', 'label' => 'Telefone secundário', 'data-type' => 'phone']);
    echo $this->Gus->control('Pessoa.email', ['div' => 'col s12 input-field', 'label' => 'E-mail']);
    echo $this->Gus->selectExtends('Pessoa.cidade_id', $cidades->toArray(), [
        'div' => 'col s12 input-field select2-field',
        'label' => ['text' => 'Cidade', 'class' => 'active'],
        'controller' => 'cidades',
    ]);
    echo $this->Gus->selectExtends('Pessoa.fornecedor_pertencente_id', $fornecedores->toArray(), [
        'div' => 'col s12 input-field select2-field',
        'label' => ['text' => 'Fornecedor a quem pertence', 'class' => 'active'],
        'controller' => 'fornecedores',
    ]);

    // Exclusivo cadastro de funcionários
    echo $this->Gus->control('data_nascimento', ['div' => 'col s12 input-field', 'label' => 'Data Nascimento', 'type' => 'text', 'data-type' => 'date']);
    echo $this->Gus->control('horista', ['div' => 'col s12 input-field', 'label' => 'Horista']);
    echo $this->Gus->control('valor_hora', ['div' => 'col s12 input-field', 'label' => 'Valor Hora']);
    ?>
    <?= $this->Gus->button('Enviar', ['div' => 'input-field col s2 right', 'class' => 'btn right waves-effect waves-light']) ?>
    <?= $this->Gus->end() ?>
</div>
