<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="produtos view card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Visualizar Produto'); ?>
    <table class="bordered highlight">
        <tr>
            <th scope="row"><?= __('Nome') ?></th>
            <td><?= h($produto->nome) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tipo de Produto') ?></th>
            <td><?= $produto->has('tipo_produto') ? $this->Html->link($produto->tipo_produto->nome, ['controller' => 'TipoProdutos', 'action' => 'view', $produto->tipo_produto->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Custo') ?></th>
            <td><?= h($this->Number->currency($produto->custo, 'BRL')) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Preço') ?></th>
            <td><?= h($this->Number->currency($produto->preco)) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Produto acabado') ?></th>
            <td><?= $this->Gus->formataBoolean($produto->produto_acabado) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Reduz estoque') ?></th>
            <td><?= $this->Gus->formataBoolean($produto->reduz_estoque) ?></td>
        </tr>
        <?php if (!empty($produto->qtde_estoque)) { ?>
        <tr>
            <th scope="row"><?= __('Quantidade em estoque') ?></th>
            <td><?= h($produto->qtde_estoque) ?></td>
        </tr>
        <?php } ?>
        <tr>
            <th scope="row"><?= __('Possui lote') ?></th>
            <td><?= $this->Gus->formataBoolean($produto->possui_lote) ?></td>
        </tr>
    </table>
</div>