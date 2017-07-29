<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="cidades view card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Visualizar Cidade'); ?>
    <table class="bordered highlight">
                                <tr>
            <th scope="row"><?= __('Nome') ?></th>
            <td><?= h($cidade->nome) ?></td>
        </tr>
                                <tr>
            <th scope="row"><?= __('Estado') ?></th>
            <td><?= $cidade->has('estado') ? $this->Html->link($cidade->estado->nome, ['controller' => 'Estados', 'action' => 'view', $cidade->estado->id]) : '' ?></td>
        </tr>
                            </table>
</div>