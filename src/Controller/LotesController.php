<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use \Cake\Datasource\Exception\RecordNotFoundException;
use \Cake\Datasource\ConnectionManager;
use Cake\View\CellTrait;

/**
 * Lotes Controller
 *
 * @property \App\Model\Table\LotesTable $Lotes
 *
 * @method \App\Model\Entity\Lote[] paginate($object = null, array $settings = [])
 */
class LotesController extends AppController
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
            'Lotes' => Router::url(['action' => 'index'])
        ];
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {

        $query = $this->Lotes
            ->find('search', ['search' => $this->request->getQueryParams()])
            ->contain(['Produtos']);

        $conditions['id'] = 0;
        if (!empty($this->request->getQuery('produto_id'))) {
            $conditions['id'] = $this->request->getQuery('produto_id');
        }

        $produtos = $this->Lotes->Produtos->find('list', [
            'valueField' => 'nome',
            'conditions' => $conditions,
        ]);

        $this->paginate = ['limit' => 20];
        $lotes = $this->paginate($query);

        $this->set(compact('lotes', 'produtos'));
        $this->set('_serialize', ['lotes']);

        $this->set('crumbs', $this->_crumbs);
    }

    /**
     * View method
     *
     * @param string|null $id Lote id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $lote = $this->Lotes->get($id, [
            'contain' => ['Produtos', 'BaixaProdutos']
        ]);

        $this->set('lote', $lote);
        $this->set('_serialize', ['lote']);

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
        $lote = $this->Lotes->newEntity();
        if ($this->request->is('post')) {
            $lote = $this->Lotes->patchEntity($lote, $this->request->getData());
            if ($this->Lotes->save($lote)) {
                if (!empty($this->request->getQuery('extends'))) {
                    $this->_fechaExtends();
                }
                $this->Flash->success(__('Registro salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Erro ao salvar o registro. Por favor tente novamente.'));
        }
        $produtos = $this->Lotes->Produtos->find('list', ['limit' => 200]);
        $this->set(compact('lote', 'produtos'));
        $this->set('_serialize', ['lote']);

        $this->_crumbs['Cadastro'] = Router::url(['action' => 'add']);
        $this->set('crumbs', $this->_crumbs);
    }

    /**
     * Edit method
     *
     * @param string|null $id Lote id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $lote = $this->Lotes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lote = $this->Lotes->patchEntity($lote, $this->request->getData());
            if ($this->Lotes->save($lote)) {
                if (!empty($this->request->getQuery('extends'))) {
                    $this->_fechaExtends();
                }
                $this->Flash->success(__('Registro salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Erro ao salvar o registro. Por favor tente novamente.'));
        }
        $produtos = $this->Lotes->Produtos->find('list', ['limit' => 200]);
        $this->set(compact('lote', 'produtos'));
        $this->set('_serialize', ['lote']);

        $this->_crumbs['Edição'] = Router::url(['action' => 'edit']);
        $this->set('crumbs', $this->_crumbs);
    }

    /**
     * Delete method
     *
     * @param string|null $id Lote id.
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
     * @param int|array $ids Lotes ids.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Quando o registro não é encontrado.
     */
    private function _handleDelete($ids)
    {
        if (!is_array($ids)) {
            $ids = [$ids];
        }

        $conn = ConnectionManager::get($this->Lotes->defaultConnectionName());
        $conn->begin();
        try {
            foreach ($ids as $id) {
                $lote = $this->Lotes->get($id);
                if (!$this->Lotes->delete($lote)) {
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

    // Action usada apenas para criar novas linhas (via ajax)
    use CellTrait;
    public function getLinhaTabela() {
        $linha = '';
        $produtoId = $this->request->getQuery('produtoId');
        if (!empty($produtoId)) {
            $linhaAtual = ($this->request->getQuery('linhaAtual') ? $this->request->getQuery('linhaAtual') : 0);
            $linhaAtualLote = ($this->request->getQuery('linhaAtualLote') ? $this->request->getQuery('linhaAtualLote') : 0);
            $linha = $this->cell('LinhaTabela::lote', [null, $linhaAtual, $linhaAtualLote, $produtoId]);
        }

        echo $linha;
        die();
    }
}
