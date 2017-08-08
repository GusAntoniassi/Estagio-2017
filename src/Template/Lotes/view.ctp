<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="lotes view card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Visualizar Lote'); ?>
    <table class="bordered highlight">
                                <tr>
            <th scope="row"><?= __('Num Lote') ?></th>
            <td><?= h($lote->num_lote) ?></td>
        </tr>
                                <tr>
            <th scope="row"><?= __('Produto') ?></th>
            <td><?= $lote->has('produto') ? $this->Html->link($lote->produto->id, ['controller' => 'Produtos', 'action' => 'view', $lote->produto->id]) : '' ?></td>
        </tr>
                            </table>
</div>