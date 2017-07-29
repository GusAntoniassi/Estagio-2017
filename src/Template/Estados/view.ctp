<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="estados view card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Visualizar Estado'); ?>
    <table class="bordered highlight">
                                <tr>
            <th scope="row"><?= __('Nome') ?></th>
            <td><?= h($estado->nome) ?></td>
        </tr>
                                <tr>
            <th scope="row"><?= __('Sigla') ?></th>
            <td><?= h($estado->sigla) ?></td>
        </tr>
                                <tr>
            <th scope="row"><?= __('Pais') ?></th>
            <td><?= $estado->has('pais') ? $this->Html->link($estado->pais->id, ['controller' => 'Paises', 'action' => 'view', $estado->pais->id]) : '' ?></td>
        </tr>
                            </table>
</div>