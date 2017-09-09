<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="formaPagamentos view card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Visualizar Forma de Pagamento'); ?>
    <table class="bordered highlight">
        <tr>
            <th scope="row"><?= __('Nome') ?></th>
            <td><?= h($formaPagamento->nome) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nº de parcelas') ?></th>
            <td><?= $this->Number->format($formaPagamento->num_parcelas) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Carência') ?></th>
            <td><?= $this->Number->format($formaPagamento->carencia) ?> dia(s)</td>
        </tr>
        <tr>
            <th scope="row"><?= __('Entrada') ?></th>
            <td><?= $this->Number->currency($formaPagamento->entrada, 'BRL') ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Gus->formataStatus($formaPagamento->nome) ?></td>
        </tr>
    </table>
</div>