<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="funcionarios view card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Visualizar Funcionario'); ?>
    <table class="bordered highlight">
                                <tr>
            <th scope="row"><?= __('Pessoa') ?></th>
            <td><?= $funcionario->has('pessoa') ? $this->Html->link($funcionario->pessoa->id, ['controller' => 'Pessoas', 'action' => 'view', $funcionario->pessoa->id]) : '' ?></td>
        </tr>
                            </table>
</div>