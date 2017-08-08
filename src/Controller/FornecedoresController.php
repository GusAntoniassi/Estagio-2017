<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use \Cake\Datasource\Exception\RecordNotFoundException;
use \Cake\Datasource\ConnectionManager;

/**
 * Fornecedores Controller
 *
 * @property \App\Model\Table\FornecedoresTable $Fornecedores
 *
 * @method \App\Model\Entity\Fornecedor[] paginate($object = null, array $settings = [])
 */
class FornecedoresController extends AppController {
    private $_crumbs;
    public function initialize() {
        parent::initialize();
        $this->loadComponent('Search.Prg', [
            'actions' => 'index',
        ]);

        $this->_crumbs = [
            'Painel' => Router::url(['controller' => 'usuarios', 'action' => 'dashboard'], true),
            'Fornecedores' => Router::url(['action' => 'index'])
        ];
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {

        $query = $this->Fornecedores
            ->find('search', ['search' => $this->request->getQueryParams()])
                        ->contain(['Pessoas'])
            ;

        $this->paginate = ['limit' => 20];
        $fornecedores = $this->paginate($query);

        $this->set(compact('fornecedores'));
        $this->set('_serialize', ['fornecedores']);

        $this->set('crumbs', $this->_crumbs);
    }

    /**
     * View method
     *
     * @param string|null $id Fornecedor id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $fornecedor = $this->Fornecedores->get($id, [
            'contain' => ['Pessoas', 'Compras', 'ContaPagars', 'Orcamentos', 'PedidoCompras']
        ]);

        $this->set('fornecedor', $fornecedor);
        $this->set('_serialize', ['fornecedor']);

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
        $fornecedor = $this->Fornecedores->newEntity();
        if ($this->request->is('post')) {
            $fornecedor = $this->Fornecedores->patchEntity($fornecedor, $this->request->getData());
            if ($this->Fornecedores->save($fornecedor)) {
                if (!empty($this->request->getQuery('extends'))) {
                    $this->_fechaExtends();
                }
                $this->Flash->success(__('Registro salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Erro ao salvar o registro. Por favor tente novamente.'));
        }
        $pessoas = $this->Fornecedores->Pessoas->find('list', ['limit' => 200]);
        $this->set(compact('fornecedor', 'pessoas'));
        $this->set('_serialize', ['fornecedor']);

        $this->_crumbs['Cadastro'] = Router::url(['action' => 'add']);
        $this->set('crumbs', $this->_crumbs);
    }

    /**
     * Edit method
     *
     * @param string|null $id Fornecedor id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $fornecedor = $this->Fornecedores->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $fornecedor = $this->Fornecedores->patchEntity($fornecedor, $this->request->getData());
            if ($this->Fornecedores->save($fornecedor)) {
                if (!empty($this->request->getQuery('extends'))) {
                    $this->_fechaExtends();
                }
                $this->Flash->success(__('Registro salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Erro ao salvar o registro. Por favor tente novamente.'));
        }
        $pessoas = $this->Fornecedores->Pessoas->find('list', ['limit' => 200]);
        $this->set(compact('fornecedor', 'pessoas'));
        $this->set('_serialize', ['fornecedor']);

        $this->_crumbs['Edição'] = Router::url(['action' => 'edit']);
        $this->set('crumbs', $this->_crumbs);
    }

    /**
     * Delete method
     *
     * @param string|null $id Fornecedor id.
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
     * @param int|array $ids Fornecedores ids.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Quando o registro não é encontrado.
     */
    private function _handleDelete($ids) {
        if (!is_array($ids)) {
            $ids = [$ids];
        }

        $conn = ConnectionManager::get($this->Fornecedores->defaultConnectionName());
        $conn->begin();
        try {
            foreach ($ids as $id) {
                $fornecedor = $this->Fornecedores->get($id);
                if (!$this->Fornecedores->delete($fornecedor)) {
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