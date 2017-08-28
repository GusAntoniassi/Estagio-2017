<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="formaPagamentos view card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Visualizar FormaPagamento'); ?>
    <table class="bordered highlight">
                                <tr>
            <th scope="row"><?= __('Nome') ?></th>
            <td><?= h($formaPagamento->nome) ?></td>
        </tr>
                            </table>
</div>