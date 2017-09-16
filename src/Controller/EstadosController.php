<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\NotFoundException;
use Cake\Routing\Router;
use \Cake\Datasource\Exception\RecordNotFoundException;
use \Cake\Datasource\ConnectionManager;

/**
 * Estados Controller
 *
 * @property \App\Model\Table\EstadosTable $Estados
 *
 * @method \App\Model\Entity\Estado[] paginate($object = null, array $settings = [])
 */
class EstadosController extends AppController
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
            'Estados' => Router::url(['action' => 'index'])
        ];
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {

        $query = $this->Estados
            ->find('search', ['search' => $this->request->getQueryParams()])
            ->contain(['Paises']);

        $this->paginate = ['limit' => 20];
        $estados = $this->paginate($query);

        $paises = $this->Gus->getOptionsArray($this->Estados->Paises->find('list'));

        $this->set(compact('estados', 'paises'));
        $this->set('_serialize', ['estados']);

        $this->set('crumbs', $this->_crumbs);
    }

    /**
     * View method
     *
     * @param string|null $id Estado id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $estado = $this->Estados->get($id, [
            'contain' => ['Paises', 'Cidades']
        ]);

        $this->set('estado', $estado);
        $this->set('_serialize', ['estado']);

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
        $estado = $this->Estados->newEntity();
        if ($this->request->is('post')) {
            $estado = $this->Estados->patchEntity($estado, $this->request->getData());
            if ($this->Estados->save($estado)) {
                if (!empty($this->request->getQuery('extends'))) {
                    $this->_fechaExtends();
                }

                $this->Flash->success(__('Registro salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Erro ao salvar o registro. Por favor tente novamente.'));
        }
        $paises = $this->Estados->Paises->find('list', ['limit' => 200]);
        $this->set(compact('estado', 'paises'));
        $this->set('_serialize', ['estado']);

        $this->_crumbs['Cadastro'] = Router::url(['action' => 'add']);
        $this->set('crumbs', $this->_crumbs);
    }

    /**
     * Edit method
     *
     * @param string|null $id Estado id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $estado = $this->Estados->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $estado = $this->Estados->patchEntity($estado, $this->request->getData());
            if ($this->Estados->save($estado)) {
                if (!empty($this->request->getQuery('extends'))) {
                    $this->_fechaExtends();
                }

                $this->Flash->success(__('Registro salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Erro ao salvar o registro. Por favor tente novamente.'));
        }
        $paises = $this->Estados->Paises->find('list', ['limit' => 200]);
        $this->set(compact('estado', 'paises'));
        $this->set('_serialize', ['estado']);

        $this->_crumbs['Edição'] = Router::url(['action' => 'edit']);
        $this->set('crumbs', $this->_crumbs);
    }

    /**
     * Delete method
     *
     * @param string|null $id Estado id.
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
     * @param int|array $ids Estados ids.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Quando o registro não é encontrado.
     */
    private function _handleDelete($ids)
    {
        if (!is_array($ids)) {
            $ids = [$ids];
        }

        $conn = ConnectionManager::get($this->Estados->defaultConnectionName());
        $conn->begin();
        try {
            foreach ($ids as $id) {
                $estado = $this->Estados->get($id);
                if (!$this->Estados->delete($estado)) {
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

    public function getAll()
    {
        $conditions = ['status' => true];
        if (!empty($this->request->getQuery('ajax_id'))) {
            $conditions['id'] = $this->request->getQuery('ajax_id');
            $estado = $this->Estados->findById($this->request->getQuery('ajax_id'))->first();
            $estados = [$estado->id => $estado->estadoPais];
        } else {
            $conditions['pais_id'] = (!empty($this->request->getQuery('pais_id')) ? $this->request->getQuery('pais_id') : 0);
            $estados = $this->Estados->find('list', ['valueField' => 'nome'])
                ->where($conditions)
                ->orderAsc('nome');
        }
        echo json_encode($estados);
        die();
    }

    public function select2ajax() {
        $query = $this->request->getQuery('q');
        if (empty($query)) {
            die(json_encode([]));
        }

        $query = '%' . mb_strtolower($query) . '%';

        $estados = $this->Estados->find('list', [
            'contain' => ['Paises'],
            'valueField' => function($estado) {
                return $estado->nome . ', ' . $estado->pais->sigla;
            }
        ])->where(['Estados.nome LIKE ' => $query]);

        $resultados = [];
        foreach ($estados as $id => $estado) {
            $resultados[] = ['id' => $id, 'name' => $estado];
        }
        echo json_encode($resultados);
        die();
    }
}
