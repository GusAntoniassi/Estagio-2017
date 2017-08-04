<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="usuarios view card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', 'Visualizar Usuário'); ?>
    <table class="bordered highlight">
        <tr>
            <th scope="row"><?= __('Login') ?></th>
            <td><?= h($usuario->login) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Grupo de Usuários') ?></th>
            <td><?= $usuario->has('grupo_usuario') ? $this->Html->link($usuario->grupo_usuario->nome, ['controller' => 'GrupoUsuarios', 'action' => 'view', $usuario->grupo_usuario->id]) : '' ?></td>
        </tr>
    </table>
</div>