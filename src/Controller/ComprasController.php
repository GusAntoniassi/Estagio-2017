<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use \Cake\Datasource\Exception\RecordNotFoundException;
use \Cake\Datasource\ConnectionManager;

/**
 * Compras Controller
 *
 * @property \App\Model\Table\ComprasTable $Compras
 *
 * @method \App\Model\Entity\Compra[] paginate($object = null, array $settings = [])
 */
class ComprasController extends AppController
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
            'Compras' => Router::url(['action' => 'index'])
        ];
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {

        $query = $this->Compras
            ->find('search', ['search' => $this->request->getQueryParams()])
            ->contain(['PedidoCompras', 'FormaPagamentos', 'Fornecedores', 'Fornecedores.Pessoas']);

        $this->paginate = ['limit' => 20, 'order' => ['Compras.id' => 'desc']];
        $compras = $this->paginate($query);

        $formaPagamentos = $this->Gus->getOptionsArray($this->Compras->FormaPagamentos->find('list', ['limit' => 200]));
        $fornecedores = $this->Compras->Fornecedores->find('list', [
            'limit' => 200,
            'contain' => ['Pessoas'],
            'valueField' => function($fornecedor) {
                return $fornecedor->pessoa->nome_exibicao;
            }
        ]);
        $fornecedores = $this->Gus->getOptionsArray($fornecedores);

        $this->set(compact('compras', 'formaPagamentos', 'fornecedores'));
        $this->set('_serialize', ['compras']);

        $this->set('crumbs', $this->_crumbs);
    }

    /**
     * View method
     *
     * @param string|null $id Compra id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $compra = $this->Compras->get($id, [
            'contain' => ['PedidoCompras', 'FormaPagamentos', 'Fornecedores', 'ContaPagars', 'ItemCompras']
        ]);

        $this->set('compra', $compra);
        $this->set('_serialize', ['compra']);

        $compra = $this->Compras->get($id, [
            'contain' => [
                'Fornecedores',
                'Fornecedores.Pessoas',
                'ItemCompras',
                'ItemCompras.LoteCompras',
                'ItemCompras.Produtos',
                'ItemCompras.LoteCompras.Lotes',
            ]
        ]);

        $formaPagamentos = $this->Compras->FormaPagamentos->find('list', ['limit' => 200]);
        $fornecedor = $compra->fornecedor->pessoa->nome_exibicao;

        $this->set(compact('compra', 'pedidoCompras', 'formaPagamentos', 'fornecedor'));
        $this->set('_serialize', ['compra']);

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
        $compra = $this->Compras->newEntity();
        if ($this->request->is('post')) {
            $compra = $this->Compras->patchEntity($compra, $this->request->getData(), [
                'associated' => [
                    'ItemCompras',
                    'ItemCompras.LoteCompras.Lotes',
                    'ItemCompras.LoteCompras',
                ]
            ]);

            $conn = ConnectionManager::get($this->Compras->defaultConnectionName());
            $conn->begin();

            try {
                $result = $this->Compras->save($compra);

                if (!$result) {
                    throw new \Exception;
                }

                // Se o status da compra for FECHADO (1), gerar as parcelas
                if ($compra->status) {
                    $compra->fecharCompra();
                    $conn->commit();

                    // Redirecionar para a edição do contas a pagar
                    $contaPagar = $this->Compras->ContaPagars->findByCompraId($compra->id)->first();
                    if (!empty($contaPagar)) {
                        $this->Flash->success(__('Compra salva com sucesso.'));
                        $this->redirect(['controller' => 'ContaPagars', 'action' => 'edit', $contaPagar->id]);
                    } else {
                        throw new \Exception;
                    }
                } else {
                    $conn->commit();
                    $this->Flash->success(__('Compra salva com sucesso.'));
                    $this->redirect(['controller' => 'compras']);
                }
            } catch (\Exception $e) {
                $this->Flash->error(__('Erro ao salvar a compra. Por favor tente novamente.'));
                $conn->rollback();
            }
        }

        $formaPagamentos = $this->Compras->FormaPagamentos->find('list', ['valueField' => 'nome']);

        $this->set(compact('compra', 'pedidoCompras', 'formaPagamentos', 'fornecedores'));
        $this->set('_serialize', ['compra']);

        $this->_crumbs['Cadastro'] = Router::url(['action' => 'add']);
        $this->set('crumbs', $this->_crumbs);
    }

    /**
     * Edit method
     *
     * @param string|null $id Compra id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $compra = $this->Compras->get($id, [
            'contain' => [
                'Fornecedores',
                'Fornecedores.Pessoas',
                'ItemCompras',
                'ItemCompras.LoteCompras',
                'ItemCompras.Produtos',
                'ItemCompras.LoteCompras.Lotes',
            ]
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $compra = $this->Compras->patchEntity($compra, $this->request->getData(), [
                'associated' => [
                    'ItemCompras',
                    'ItemCompras.LoteCompras.Lotes',
                    'ItemCompras.LoteCompras',
                ]
            ]);

            $conn = ConnectionManager::get($this->Compras->defaultConnectionName());
            $conn->begin();

            try {
                $result = $this->Compras->save($compra);

                if (!$result) {
                    throw new \Exception;
                }

                // Se o status da compra for FECHADO (1), gerar as parcelas
                if ($compra->status) {
                    $compra->fecharCompra();
                    $conn->commit();

                    // Redirecionar para a edição do contas a pagar
                    $contaPagar = $this->Compras->ContaPagars->findByCompraId($compra->id)->first();
                    if (!empty($contaPagar)) {
                        $this->Flash->success(__('Compra salva com sucesso.'));
                        $this->redirect(['controller' => 'ContaPagars', 'action' => 'edit', $contaPagar->id]);
                    } else {
                        throw new \Exception;
                    }
                } else {
                    $conn->commit();
                    $this->Flash->success(__('Compra salva com sucesso.'));
                    $this->redirect(['controller' => 'compras']);
                }
            } catch (\Exception $e) {
                $this->Flash->error(__('Erro ao salvar a compra. Por favor tente novamente.'));
                $conn->rollback();
            }
        }

        $formaPagamentos = $this->Compras->FormaPagamentos->find('list', ['limit' => 200]);
        $fornecedor = $compra->fornecedor->pessoa->nome_exibicao;

        $this->set(compact('compra', 'pedidoCompras', 'formaPagamentos', 'fornecedor'));
        $this->set('_serialize', ['compra']);

        $this->_crumbs['Edição'] = Router::url(['action' => 'edit']);
        $this->set('crumbs', $this->_crumbs);
    }

    /**
     * Delete method
     *
     * @param string|null $id Compra id.
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
     * @param int|array $ids Compras ids.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Quando o registro não é encontrado.
     */
    private function _handleDelete($ids)
    {
        if (!is_array($ids)) {
            $ids = [$ids];
        }

        $conn = ConnectionManager::get($this->Compras->defaultConnectionName());
        $conn->begin();
        try {
            foreach ($ids as $id) {
                $compra = $this->Compras->get($id);
                if (!$this->Compras->delete($compra)) {
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

    public function getProdutosCompraveis() {
        $produtos = $this->Compras->find('all')
            ->where(['status' => true]);

//        echo json_encode()
    }
}
