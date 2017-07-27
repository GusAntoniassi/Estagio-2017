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
use Cake\Utility\Inflector;

$fields = collection($fields)
    ->filter(function($field) use ($schema) {
        return $schema->columnType($field) !== 'binary';
    });

if (isset($modelObject) && $modelObject->hasBehavior('Tree')) {
    $fields = $fields->reject(function ($field) {
        return $field === 'lft' || $field === 'rght';
    });
}

$fields = $fields->toArray();
uasort($fields, function($a, $b) {
    return ($b == 'status');
});
%>
<div class="<%= $pluralVar %> form <%= $type %> row card-panel">
    <?= $this->element('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php $this->assign('title', '<%= ($type == "add" ? "Cadastro" : "Edição") %> de <%= Inflector::humanize(Inflector::singularize($pluralVar)); %>'); ?>

    <?= $this->Gus->create($<%= $singularVar %>, ['class' => 'row']) ?>
    <?php
<%
    foreach ($fields as $field) {
        if (in_array($field, $primaryKey)) {
            continue;
        }
        if (isset($keyFields[$field])) {
            $fieldData = $schema->column($field);
            if (!empty($fieldData['null'])) {
%>
        echo $this->Gus->control('<%= $field %>', ['div' => 'col s12 input-field select2-field', 'label' => ['text' => '<%= Inflector::humanize($field) %>', 'class' => 'active'], 'options' => $<%= $keyFields[$field] %>, 'empty' => true, 'data-select-2']);
<%
            } else {
%>
        echo $this->Gus->control('<%= $field %>', ['div' => 'col s12 input-field select2-field', 'label' => ['text' => '<%= Inflector::humanize($field) %>', 'class' => 'active'], 'options' => $<%= $keyFields[$field] %>, 'data-select-2']);
<%
            }
            continue;
        }
        if (!in_array($field, ['created', 'modified', 'updated'])) {
            $fieldData = $schema->column($field);
            if (in_array($fieldData['type'], ['date', 'datetime', 'time'])) {
%>
        echo $this->Gus->control('<%= $field %>', ['div' => 'col s12 input-field', 'label' => '<%= Inflector::humanize($field) %>', 'type' => 'text', 'data-type' => '<%= $fieldData["type"] %>']);
<%
            } else {
                if ($field == 'status' && $type == 'add') {
%>
                    echo $this->Gus->control('<%= $field %>', ['div' => 'col s12 input-field', 'label' => '<%= Inflector::humanize($field) %>', 'checked' => 'checked']);
<%
                } else {
%>
                    echo $this->Gus->control('<%= $field %>', ['div' => 'col s12 input-field', 'label' => '<%= Inflector::humanize($field) %>']);
<%              }
            }
        }
    }
    if (!empty($associations['BelongsToMany'])) {
        foreach ($associations['BelongsToMany'] as $assocName => $assocData) {
%>
        echo $this->Gus->control('<%= $assocData['property'] %>._ids', ['div' => 'col s12 input-field required', 'label' => '<%= Inflector::humanize($field) %>', 'options' => $<%= $assocData['variable'] %>]);
<%
        }
    }
%>
    ?>
    <?= $this->Gus->button('Enviar', ['div' => 'input-field col s2 right', 'class' => 'btn right waves-effect waves-light']) ?>
    <?= $this->Gus->end() ?>
</div>
