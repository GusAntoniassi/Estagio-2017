<%
/**
 * Controller bake template file
 *
 * Allows templating of Controllers generated from bake.
 *
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

$defaultModel = $name;
%>
<?php
namespace <%= $namespace %>\Controller<%= $prefix %>;

use <%= $namespace %>\Controller\AppController;
use Cake\Routing\Router;
use \Cake\Datasource\Exception\RecordNotFoundException;
use \Cake\Datasource\ConnectionManager;

/**
 * <%= $name %> Controller
 *
 * @property \<%= $namespace %>\Model\Table\<%= $defaultModel %>Table $<%= $defaultModel %>
<%
foreach ($components as $component):
    $classInfo = $this->Bake->classInfo($component, 'Controller/Component', 'Component');
%>
 * @property <%= $classInfo['fqn'] %> $<%= $classInfo['name'] %>
<% endforeach; %>
<% if (in_array('index', $actions)): %>
 *
 * @method \<%= $namespace %>\Model\Entity\<%= $entityClassName %>[] paginate($object = null, array $settings = [])
<% endif; %>
 */
class <%= $name %>Controller extends AppController {
    private $_crumbs;
    public function initialize() {
        parent::initialize();
        $this->loadComponent('Search.Prg', [
            'actions' => 'index',
        ]);

        $this->_crumbs = [
            'Painel' => Router::url(['controller' => 'usuarios', 'action' => 'dashboard'], true),
            '<%= $name %>' => Router::url(['action' => 'index'])
        ];
    }
<%
echo $this->Bake->arrayProperty('helpers', $helpers, ['indent' => false]);
echo $this->Bake->arrayProperty('components', $components, ['indent' => false]);
foreach($actions as $action) {
    echo $this->element('Controller/' . $action);
}
%>
    /**
     * Handle delete method
     *
     * @param int|array $ids <%= $name %> ids.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Quando o registro não é encontrado.
     */
    private function _handleDelete($ids) {
        if (!is_array($ids)) {
            $ids = [$ids];
        }

        $conn = ConnectionManager::get($this-><%= $name %>->defaultConnectionName());
        $conn->begin();
        try {
            foreach ($ids as $id) {
                $<%= $singularName %> = $this-><%= $currentModelName %>->get($id);
                if (!$this-><%= $currentModelName; %>->delete($<%= $singularName %>)) {
                    throw new \Exception();
                }
            }
            $conn->commit();
            $this->Flash->success(__('Registro(s) excluído com sucesso.'));
        } catch (\PDOException $e) {
            $conn->rollback();
            $this->Flash->error(__('Não foi possível excluir pois um dos registros selecionados já está relacionado a outro registro.'));
        } catch (\Exception $e) {
            $conn->rollback();
            $this->Flash->error(__('Erro ao excluir o(s) registro(s)! Por favor tente novamente.'));
        }
    }
}
