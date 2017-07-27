<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="paises view card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Visualizar Pais'); ?>
    <table class="bordered highlight">
                                <tr>
            <th scope="row"><?= __('Nome') ?></th>
            <td><?= h($pais->nome) ?></td>
        </tr>
                                <tr>
            <th scope="row"><?= __('Sigla') ?></th>
            <td><?= h($pais->sigla) ?></td>
        </tr>
                            </table>
</div>