<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="tipoProdutos view card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Visualizar Tipo de Produto'); ?>
    <table class="bordered highlight">
        <tr>
            <th scope="row"><?= __('Nome') ?></th>
            <td><?= h($tipoProduto->nome) ?></td>
        </tr>
    </table>
</div>