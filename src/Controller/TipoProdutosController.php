<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use \Cake\Datasource\Exception\RecordNotFoundException;
use \Cake\Datasource\ConnectionManager;

/**
 * TipoProdutos Controller
 *
 * @property \App\Model\Table\TipoProdutosTable $TipoProdutos
 *
 * @method \App\Model\Entity\TipoProduto[] paginate($object = null, array $settings = [])
 */
class TipoProdutosController extends AppController {
    private $_crumbs;
    public function initialize() {
        parent::initialize();
        $this->loadComponent('Search.Prg', [
            'actions' => 'index',
        ]);

        $this->_crumbs = [
            'Painel' => Router::url(['controller' => 'usuarios', 'action' => 'dashboard'], true),
            'Tipos de Produtos' => Router::url(['action' => 'index'])
        ];
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {

        $query = $this->TipoProdutos
            ->find('search', ['search' => $this->request->getQueryParams()]);

        $this->paginate = ['limit' => 20];
        $tipoProdutos = $this->paginate($query);

        $this->set(compact('tipoProdutos'));
        $this->set('_serialize', ['tipoProdutos']);

        $this->set('crumbs', $this->_crumbs);
    }

    /**
     * View method
     *
     * @param string|null $id Tipo Produto id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tipoProduto = $this->TipoProdutos->get($id, [
            'contain' => ['Produtos']
        ]);

        $this->set('tipoProduto', $tipoProduto);
        $this->set('_serialize', ['tipoProduto']);

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
        $tipoProduto = $this->TipoProdutos->newEntity();
        if ($this->request->is('post')) {
            $tipoProduto = $this->TipoProdutos->patchEntity($tipoProduto, $this->request->getData());
            if ($this->TipoProdutos->save($tipoProduto)) {
                if (!empty($this->request->getQuery('extends'))) {
                    $this->_fechaExtends();
                }
                $this->Flash->success(__('Registro salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Erro ao salvar o registro. Por favor tente novamente.'));
        }
        $this->set(compact('tipoProduto'));
        $this->set('_serialize', ['tipoProduto']);

        $this->_crumbs['Cadastro'] = Router::url(['action' => 'add']);
        $this->set('crumbs', $this->_crumbs);
    }

    /**
     * Edit method
     *
     * @param string|null $id Tipo Produto id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tipoProduto = $this->TipoProdutos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tipoProduto = $this->TipoProdutos->patchEntity($tipoProduto, $this->request->getData());
            if ($this->TipoProdutos->save($tipoProduto)) {
                if (!empty($this->request->getQuery('extends'))) {
                    $this->_fechaExtends();
                }
                $this->Flash->success(__('Registro salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Erro ao salvar o registro. Por favor tente novamente.'));
        }
        $this->set(compact('tipoProduto'));
        $this->set('_serialize', ['tipoProduto']);

        $this->_crumbs['Edição'] = Router::url(['action' => 'edit']);
        $this->set('crumbs', $this->_crumbs);
    }

    /**
     * Delete method
     *
     * @param string|null $id Tipo Produto id.
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
     * @param int|array $ids TipoProdutos ids.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Quando o registro não é encontrado.
     */
    private function _handleDelete($ids) {
        if (!is_array($ids)) {
            $ids = [$ids];
        }

        $conn = ConnectionManager::get($this->TipoProdutos->defaultConnectionName());
        $conn->begin();
        try {
            foreach ($ids as $id) {
                $tipoProduto = $this->TipoProdutos->get($id);
                if (!$this->TipoProdutos->delete($tipoProduto)) {
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

    public function getAll() {
        $tipoProdutos = $this->TipoProdutos->find('list', ['valueField' => 'nome'])
            ->where(['status' => true])
            ->orderAsc('nome');

        echo json_encode($tipoProdutos);
        die();
    }
}
