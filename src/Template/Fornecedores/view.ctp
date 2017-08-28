<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="fornecedores view card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Visualizar Fornecedor'); ?>
    <table class="bordered highlight">
        <tr>
            <th scope="row"><?= __('Pessoa') ?></th>
            <td><?= $fornecedor->has('pessoa') ? $this->Html->link($fornecedor->pessoa->id, ['controller' => 'Pessoas', 'action' => 'view', $fornecedor->pessoa->id]) : '' ?></td>
        </tr>
    </table>
</div>