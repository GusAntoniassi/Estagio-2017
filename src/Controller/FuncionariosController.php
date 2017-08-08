<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use \Cake\Datasource\Exception\RecordNotFoundException;
use \Cake\Datasource\ConnectionManager;

/**
 * Funcionarios Controller
 *
 * @property \App\Model\Table\FuncionariosTable $Funcionarios
 *
 * @method \App\Model\Entity\Funcionario[] paginate($object = null, array $settings = [])
 */
class FuncionariosController extends AppController
{
    private $_crumbs;

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Search.Prg', [
            'actions' => 'index',
        ]);

        $this->_crumbs = [
            'Painel' => Router::url(['controller' => 'usuarios', 'action' => 'dashboard'], true),
            'Funcionarios' => Router::url(['action' => 'index'])
        ];
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {

        $query = $this->Funcionarios
            ->find('search', ['search' => $this->request->getQueryParams()])
            ->contain(['Pessoas']);

        $this->paginate = ['limit' => 20];
        $funcionarios = $this->paginate($query);

        $this->set(compact('funcionarios'));
        $this->set('_serialize', ['funcionarios']);

        $this->set('crumbs', $this->_crumbs);
    }

    /**
     * View method
     *
     * @param string|null $id Funcionario id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $funcionario = $this->Funcionarios->get($id, [
            'contain' => ['Pessoas', 'Caixa', 'Comandas', 'LancamentoHoras']
        ]);

        $this->set('funcionario', $funcionario);
        $this->set('_serialize', ['funcionario']);

        $this->_crumbs['Visualização'] = Router::url(['action' => 'view']);
        $this->set('crumbs', $this->_crumbs);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $funcionario = $this->Funcionarios->newEntity();
        $pessoa = $this->Funcionarios->Pessoas->newEntity();
        if ($this->request->is('post')) {
            $pessoa = $this->Funcionarios->Pessoas->patchEntity($pessoa, $this->request->getdata());
            if ($this->Funcionarios->Pessoas->save($pessoa)) {
                debug($pessoa->id);
                debug($this->Funcionarios->Pessoas->getPrimaryKey());
                $data = $this->request->withData('pessoa_id', $pessoa->id);
                $funcionario = $this->Funcionarios->patchEntity($funcionario, $data);
                if ($this->Funcionarios->save($funcionario)) {
                    if (!empty($this->request->getQuery('extends'))) {
                        $this->_fechaExtends();
                    }
                    $this->Flash->success(__('Registro salvo com sucesso.'));

                    return $this->redirect(['action' => 'index']);
                }
            }
            debug($this->Funcionarios->getTable()->validationErrors);
            $this->Flash->error(__('Erro ao salvar o registro. Por favor tente novamente.'));
        }
        $cidades = $this->Funcionarios->Pessoas->Cidades->find('list');
        $fornecedores = $this->Funcionarios->Pessoas->Fornecedores->find('list');
        $this->set(compact('funcionario', 'pessoas', 'cidades', 'fornecedores'));
        $this->set('_serialize', ['funcionario']);

        $this->_crumbs['Cadastro'] = Router::url(['action' => 'add']);
        $this->set('crumbs', $this->_crumbs);
    }

    /**
     * Edit method
     *
     * @param string|null $id Funcionario id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $funcionario = $this->Funcionarios->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $funcionario = $this->Funcionarios->patchEntity($funcionario, $this->request->getData());
            if ($this->Funcionarios->save($funcionario)) {
                if (!empty($this->request->getQuery('extends'))) {
                    $this->_fechaExtends();
                }
                $this->Flash->success(__('Registro salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Erro ao salvar o registro. Por favor tente novamente.'));
        }
        $pessoas = $this->Funcionarios->Pessoas->find('list', ['limit' => 200]);
        $this->set(compact('funcionario', 'pessoas'));
        $this->set('_serialize', ['funcionario']);

        $this->_crumbs['Edição'] = Router::url(['action' => 'edit']);
        $this->set('crumbs', $this->_crumbs);
    }

    /**
     * Delete method
     *
     * @param string|null $id Funcionario id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        // Se for passado o $id
        if (!empty($id)) {
            $this->_handleDelete($id);
        } else {
            if ($this->request->getData('ids') !== null) {
                $this->_handleDelete($this->request->getData('ids'));
            } else {
                throw new RecordNotFoundException('Registro não encontrado!');
            }
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Handle delete method
     *
     * @param int|array $ids Funcionarios ids.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Quando o registro não é encontrado.
     */
    private function _handleDelete($ids)
    {
        if (!is_array($ids)) {
            $ids = [$ids];
        }

        $conn = ConnectionManager::get($this->Funcionarios->defaultConnectionName());
        $conn->begin();
        try {
            foreach ($ids as $id) {
                $funcionario = $this->Funcionarios->get($id);
                if (!$this->Funcionarios->delete($funcionario)) {
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
