<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use \Cake\Datasource\Exception\RecordNotFoundException;
use \Cake\Datasource\ConnectionManager;

/**
 * ContaPagars Controller
 *
 * @property \App\Model\Table\ContaPagarsTable $ContaPagars
 *
 * @method \App\Model\Entity\ContaPagar[] paginate($object = null, array $settings = [])
 */
class ContaPagarsController extends AppController
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
            'Contas a Pagar' => Router::url(['action' => 'index'])
        ];
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $query = $this->ContaPagars
            ->find('search', ['search' => $this->request->getQueryParams()])
            ->contain(['Fornecedores', 'Fornecedores.Pessoas', 'Compras', 'FormaPagamentos']);

        $this->paginate = [
            'limit' => 20,
            'contain' => ['Fornecedores', 'Fornecedores.Pessoas', 'FormaPagamentos'],
            'sortWhitelist' => ['ContaPagars.id', 'ContaPagars.descricao', 'ContaPagars.valor',
                'ContaPagars.data_cadastro', 'ContaPagars.data_pagamento', 'ContaPagars.pago',
                'ContaPagars.data_pagamento', 'Pessoas.nome_razaosocial', 'FormaPagamentos.nome'
            ],
            'order' => ['ContaPagars.id' => 'DESC']
        ];

        $contaPagars = $this->paginate($query);

        $fornecedores = $this->ContaPagars->Fornecedores->find('list', [
            'limit' => 200,
            'contain' => ['Pessoas'],
            'valueField' => function ($fornecedor) {
                return $fornecedor->pessoa->nome_exibicao;
            }
        ]);
        $fornecedores = $this->Gus->getOptionsArray($fornecedores);

        $formaPagamentos = $this->Gus->getOptionsArray($this->ContaPagars->FormaPagamentos->find('list', ['limit' => 200]));

        $this->set(compact('contaPagars', 'fornecedores', 'formaPagamentos'));
        $this->set('_serialize', ['contaPagars']);

        $this->set('crumbs', $this->_crumbs);
    }

    /**
     * View method
     *
     * @param string|null $id Conta Pagar id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contaPagar = $this->ContaPagars->get($id, [
            'contain' => ['Fornecedores', 'Compras', 'FormaPagamentos', 'ParcelaContaPagars']
        ]);

        $this->set('contaPagar', $contaPagar);
        $this->set('_serialize', ['contaPagar']);

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
        $contaPagar = $this->ContaPagars->newEntity();
        if ($this->request->is('post')) {
            $contaPagar = $this->ContaPagars->patchEntity($contaPagar, $this->request->getData());
            if ($this->ContaPagars->save($contaPagar)) {
                if ($contaPagar->geraParcelas()) {
                    return $this->redirect(['action' => 'edit', $contaPagar->id]);
                }
            }
            $this->Flash->error(__('Erro ao salvar o registro. Por favor tente novamente.'));
        }
        $fornecedores = $this->ContaPagars->Fornecedores->find('list', [
            'limit' => 200,
            'contain' => ['Pessoas'],
            'valueField' => function ($fornecedor) {
                return $fornecedor->pessoa->nome_exibicao;
            }
        ]);
        $compras = $this->ContaPagars->Compras->find('list', ['limit' => 200]);
        $formaPagamentos = $this->ContaPagars->FormaPagamentos->find('list', ['limit' => 200]);
        $this->set(compact('contaPagar', 'fornecedores', 'compras', 'formaPagamentos'));
        $this->set('_serialize', ['contaPagar']);

        $this->_crumbs['Cadastro'] = Router::url(['action' => 'add']);
        $this->set('crumbs', $this->_crumbs);
    }

    /**
     * Edit method
     *
     * @param string|null $id Conta Pagar id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contaPagar = $this->ContaPagars->get($id, [
            'contain' => [
                'Fornecedores',
                'Fornecedores.Pessoas',
                'FormaPagamentos',
                'ParcelaContaPagars',
                'ParcelaContaPagars.Pagamentos']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contaPagar = $this->ContaPagars->patchEntity($contaPagar, $this->request->getData());
            if ($this->ContaPagars->save($contaPagar)) {
                if (!empty($this->request->getQuery('extends'))) {
                    $this->_fechaExtends();
                }
                $this->Flash->success(__('Registro salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Erro ao salvar o registro. Por favor tente novamente.'));
        }

        if (!empty($contaPagar)) {
            // Pegar o nome do fornecedor (da tabela de pessoas)
            $nomeFornecedor = $contaPagar->fornecedor->pessoa->get('nome_exibicao');
            $fornecedores = [$contaPagar->fornecedor_id => $nomeFornecedor];

            // Pegar o nome da compra ("Compra #id")
            if (!empty($contaPagar->compra_id)) {
                $compras = [$contaPagar->compra_id => 'Compra #' . $contaPagar->compra_id];
            } else {
                $compras = [];
            }

            // Pegar o nome da forma de pagamento
            $formaPagamentos = [$contaPagar->forma_pagamento_id => $contaPagar->forma_pagamento->nome];
        } else {
            $fornecedores = $this->ContaPagars->Fornecedores->find('list', ['limit' => 200]);
            $compras = $this->ContaPagars->Compras->find('list', ['limit' => 200]);
            $formaPagamentos = $this->ContaPagars->FormaPagamentos->find('list', ['limit' => 200]);
        }
        $this->set(compact('contaPagar', 'fornecedores', 'compras', 'formaPagamentos'));
        $this->set('_serialize', ['contaPagar']);

        $this->_crumbs['Edição'] = Router::url(['action' => 'edit']);
        $this->set('crumbs', $this->_crumbs);
    }

    /**
     * Delete method
     *
     * @param string|null $id Conta Pagar id.
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
     * @param int|array $ids ContaPagars ids.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Quando o registro não é encontrado.
     */
    private function _handleDelete($ids)
    {
        if (!is_array($ids)) {
            $ids = [$ids];
        }

        $conn = ConnectionManager::get($this->ContaPagars->defaultConnectionName());
        $conn->begin();
        try {
            foreach ($ids as $id) {
                $contaPagar = $this->ContaPagars->get($id);
                if (!$this->ContaPagars->delete($contaPagar)) {
                    $erros = $contaPagar->getErrors();
                    if (!empty($erros['status'])) {
                        throw new \Exception($erros['status']['validaContaPagar']);
                    } else {
                        throw new \Exception();
                    }
                }
            }
            $conn->commit();
            $this->Flash->success(__('Registro(s) excluído com sucesso.'));
        } catch (\PDOException $e) {
            $conn->rollback();
            $this->Flash->error(__('Não foi possível excluir pois um dos registros selecionados já está relacionado a outro registro.'));
        } catch (\Exception $e) {
            $conn->rollback();
            if (!empty($e->getMessage())) {
                $this->Flash->error($e->getMessage());
            } else {
                $this->Flash->error(__('Erro ao excluir o(s) registro(s)! Por favor tente novamente.'));
            }
        }
    }
}
