<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use \Cake\Datasource\Exception\RecordNotFoundException;
use \Cake\Datasource\ConnectionManager;

/**
 * Produtos Controller
 *
 * @property \App\Model\Table\ProdutosTable $Produtos
 *
 * @method \App\Model\Entity\Produto[] paginate($object = null, array $settings = [])
 */
class ProdutosController extends AppController
{
    private $_crumbs;
    public $helpers = ['Proffer.Proffer'];

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Search.Prg', [
            'actions' => 'index',
        ]);

        $this->_crumbs = [
            'Painel' => Router::url(['controller' => 'usuarios', 'action' => 'dashboard'], true),
            'Produtos' => Router::url(['action' => 'index'])
        ];
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {

        $query = $this->Produtos
            ->find('search', ['search' => $this->request->getQueryParams()])
            ->contain(['TipoProdutos']);

        $this->paginate = ['limit' => 20];
        $produtos = $this->paginate($query);

        $tipoProdutos = $this->Gus->getOptionsArray($this->Produtos->TipoProdutos->find('list'));

        $this->set(compact('produtos', 'tipoProdutos'));
        $this->set('_serialize', ['produtos']);

        $this->set('crumbs', $this->_crumbs);
    }

    /**
     * View method
     *
     * @param string|null $id Produto id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $produto = $this->Produtos->get($id, [
            'contain' => ['TipoProdutos', 'ItemComandas', 'ItemCompras', 'ItemOrcamentos', 'ItemPedidoCompras', 'Lote']
        ]);

        $this->set('produto', $produto);
        $this->set('_serialize', ['produto']);

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
        $produto = $this->Produtos->newEntity();
        if ($this->request->is('post')) {
            $produto = $this->Produtos->patchEntity($produto, $this->request->getData());
            if ($this->Produtos->save($produto)) {
                if (!empty($this->request->getQuery('extends'))) {
                    $this->_fechaExtends();
                }
                $this->Flash->success(__('Registro salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Erro ao salvar o registro. Por favor tente novamente.'));
        }
        $tipoProdutos = $this->Produtos->TipoProdutos->find('list', ['limit' => 200]);
        $this->set(compact('produto', 'tipoProdutos'));
        $this->set('_serialize', ['produto']);

        $this->_crumbs['Cadastro'] = Router::url(['action' => 'add']);
        $this->set('crumbs', $this->_crumbs);
    }

    /**
     * Edit method
     *
     * @param string|null $id Produto id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $produto = $this->Produtos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $produto = $this->Produtos->patchEntity($produto, $this->request->getData());
            if ($this->Produtos->save($produto)) {
                if (!empty($this->request->getQuery('extends'))) {
                    $this->_fechaExtends();
                }
                $this->Flash->success(__('Registro salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Erro ao salvar o registro. Por favor tente novamente.'));
        }
        $tipoProdutos = $this->Produtos->TipoProdutos->find('list', ['limit' => 200]);
        $this->set(compact('produto', 'tipoProdutos'));
        $this->set('_serialize', ['produto']);

        $this->_crumbs['Edição'] = Router::url(['action' => 'edit']);
        $this->set('crumbs', $this->_crumbs);
    }

    /**
     * Delete method
     *
     * @param string|null $id Produto id.
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
     * @param int|array $ids Produtos ids.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Quando o registro não é encontrado.
     */
    private function _handleDelete($ids)
    {
        if (!is_array($ids)) {
            $ids = [$ids];
        }

        $conn = ConnectionManager::get($this->Produtos->defaultConnectionName());
        $conn->begin();
        try {
            foreach ($ids as $id) {
                $produto = $this->Produtos->get($id);
                if (!$this->Produtos->delete($produto)) {
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
