<%
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
%>
<?php
use Cake\Routing\Router;
/**
  * @var \<%= $namespace %>\View\AppView $this
  */
?>
<%
use Cake\Utility\Inflector;

$fields = collection($fields)
    ->filter(function($field) use ($schema) {
        return !in_array($schema->columnType($field), ['binary', 'text']);
    });

if (isset($modelObject) && $modelObject->behaviors()->has('Tree')) {
    $fields = $fields->reject(function ($field) {
        return $field === 'lft' || $field === 'rght';
    });
}

if (!empty($indexColumns)) {
    $fields = $fields->take($indexColumns);
}

%>
<div class="<%= $pluralVar %> index list row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', '<%= Inflector::humanize(Inflector::singularize($pluralVar)); %>'); ?>
    <div class="row filtros">
        <div class="col s12">
            <ul class="collapsible" data-collapsible="accordion">
                <li>
                    <div class="collapsible-header"><?= $this->Gus->materialIcon('filter_list'); ?> Filtros</div>
                    <div class="collapsible-body">
                        <div class="row">
                            <?= $this->Gus->create(); ?>
                            <% foreach ($fields as $field): %>
                            <% if ($field == 'status') { %>
                            <?= $this->Gus->control('<%= $field %>', ['type' => 'select', 'data-material-select', 'div' => 'col s2 m1 l1', 'label' => '<%= Inflector::humanize($field) %>', 'options' => $this->Gus->getStatusOptions()]); ?>
                            <?= $this->Gus->control('<%= $field %>', ['div' => 'col s2 m1 l1', 'label' => '<%= Inflector::humanize($field) %>']); ?>
                            <% } else { %>
                            <?= $this->Gus->control('<%= $field %>', ['div' => 'col s2 m1 l1', 'label' => '<%= Inflector::humanize($field) %>']); ?>
                            <% } %>
                            <% endforeach; %>
                            <?= $this->Gus->control('Filtrar', ['div' => 'col s12 m2 l2 right', 'type' => 'submit', 'class' => 'btn waves-effect waves-light']); ?>
                            <?= $this->Gus->end(); ?>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <?= $this->Gus->create('<%= Inflector::humanize($singularVar) %>', [
        'url' => ['controller' => '<%= $pluralVar %>', 'action' => 'delete'],
        'method' => 'post',
        'class' => 'hide',
        'id' => 'form-delete',
    ]); ?>
    <?php // <input name="ids[]" type="hidden" value="1" /> ?>
    <?= $this->Gus->end(); ?>

    <table class="responsive-table index highlight">
        <thead>
        <tr>
            <th scope="col">
                <input type="checkbox" class="filled-in" id="check-all" /><label for="check-all">&nbsp;</label>
            </th>
            <% foreach ($fields as $field): %>
            <th scope="col"><?= $this->Paginator->sort('<%= $field %>') ?></th>
            <% endforeach; %>
            <th scope="col" class="actions"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($<%= $pluralVar %> as $<%= $singularVar %>): ?>
            <tr>
<%        foreach ($fields as $field) {
            $isKey = false;
            if (!empty($associations['BelongsTo'])) {
                foreach ($associations['BelongsTo'] as $alias => $details) {
                    if ($field === $details['foreignKey']) {
                        $isKey = true;
%>
                <td><?= $<%= $singularVar %>->has('<%= $details['property'] %>') ? $this->Html->link($<%= $singularVar %>-><%= $details['property'] %>->displayField, ['controller' => '<%= $details['controller'] %>', 'action' => 'view', $<%= $singularVar %>-><%= $details['property'] %>-><%= $details['primaryKey'][0] %>]) : '' ?></td>
<%
                        break;
                    }
                }
            }
            if ($isKey !== true) {
                if ($schema->columnType($field) == 'boolean') {
%>
                <td><?= $this->Gus->formataStatus($<%= $singularVar %>-><%= $field %>) ?></td>
<%
                } else if (!in_array($schema->columnType($field), ['integer', 'biginteger', 'decimal', 'float'])) {
%>
                <td><?= h($<%= $singularVar %>-><%= $field %>) ?></td>
<%
                } else {
%>
                <td><input type="checkbox" id="check<?= $<%= $singularVar %>-><%= $field %> ?>" class="filled-in" name="data[ids][<?= $<%= $singularVar %>-><%= $field %> ?>]" value="<?= $<%= $singularVar %>-><%= $field %> ?>" /><label for="check<?= $<%= $singularVar %>-><%= $field %> ?>">&nbsp;</label></td>
                <td><?= $this->Number->format($<%= $singularVar %>-><%= $field %>) ?></td>
<%
                }
            }
        }

        $pk = '$' . $singularVar . '->' . $primaryKey[0];
%>
                <td class="actions">
                    <?= $this->Html->link($this->Gus->materialIcon('edit'), ['action' => 'edit', $<%= $singularVar %>-><%= $primaryKey[0] %>], ['escape' => false, 'class' => 'btn btn-floating btn-sm waves-effect waves-light edit']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="paginator">
        <ul class="pagination">
            <?= $this->Gus->paginatorControls(); ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
<script>
    var addLink = '<?= Router::url(['controller' => '<%= $pluralVar %>', 'action' => 'add'], true); ?>';
    var editLink = '<?= Router::url(['controller' => '<%= $pluralVar %>', 'action' => 'edit', '--id--'], true); ?>';
    var viewLink = '<?= Router::url(['controller' => '<%= $pluralVar %>', 'action' => 'view', '--id--'], true); ?>';
    var deleteLink = '<?= Router::url(['controller' => '<%= $pluralVar %>', 'action' => 'delete'], true); ?>';
</script>
<?= $this->element('botao_fixo', ['controller' => $this->request->getParam('controller')]) ?>