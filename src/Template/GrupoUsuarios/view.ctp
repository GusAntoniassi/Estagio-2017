<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="grupoUsuarios view card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?= $this->assign('title', h($grupoUsuario->displayField)); ?>
    <table class="bordered highlight">
                                <tr>
            <th scope="row"><?= __('Nome') ?></th>
            <td><?= h($grupoUsuario->nome) ?></td>
        </tr>
                            </table>
</div>