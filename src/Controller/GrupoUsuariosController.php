<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use \Cake\Datasource\Exception\RecordNotFoundException;
use \Cake\Datasource\ConnectionManager;

/**
 * GrupoUsuarios Controller
 *
 * @property \App\Model\Table\GrupoUsuariosTable $GrupoUsuarios
 *
 * @method \App\Model\Entity\GrupoUsuario[] paginate($object = null, array $settings = [])
 */
class GrupoUsuariosController extends AppController {
    private $_crumbs;
    public function initialize() {
        parent::initialize();
        $this->loadComponent('Search.Prg', [
            'actions' => 'index',
        ]);

        $this->_crumbs = [
            'Painel' => Router::url(['controller' => 'users', 'action' => 'dashboard'], true),
            'Grupos de Usuários' => Router::url(['action' => 'index'])
        ];
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {

        $query = $this->GrupoUsuarios
            ->find('search', ['search' => $this->request->getQueryParams()])
                        ;

        $this->paginate = ['limit' => 20];
        $grupoUsuarios = $this->paginate($query);

        $this->set(compact('grupoUsuarios'));
        $this->set('_serialize', ['grupoUsuarios']);

        $this->set('crumbs', $this->_crumbs);
    }

    /**
     * View method
     *
     * @param string|null $id Grupo Usuario id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $grupoUsuario = $this->GrupoUsuarios->get($id, [
            'contain' => ['Usuarios']
        ]);

        $this->set('grupoUsuario', $grupoUsuario);
        $this->set('_serialize', ['grupoUsuario']);

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
        $grupoUsuario = $this->GrupoUsuarios->newEntity();
        if ($this->request->is('post')) {
            $grupoUsuario = $this->GrupoUsuarios->patchEntity($grupoUsuario, $this->request->getData());
            if ($this->GrupoUsuarios->save($grupoUsuario)) {
                $this->Flash->success(__('Registro salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Erro ao salvar o registro. Por favor tente novamente.'));
        }
        $this->set(compact('grupoUsuario'));
        $this->set('_serialize', ['grupoUsuario']);

        $this->_crumbs['Cadastro'] = Router::url(['action' => 'add']);
        $this->set('crumbs', $this->_crumbs);
    }

    /**
     * Edit method
     *
     * @param string|null $id Grupo Usuario id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $grupoUsuario = $this->GrupoUsuarios->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $grupoUsuario = $this->GrupoUsuarios->patchEntity($grupoUsuario, $this->request->getData());
            if ($this->GrupoUsuarios->save($grupoUsuario)) {
                $this->Flash->success(__('Registro salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Erro ao salvar o registro. Por favor tente novamente.'));
        }
        $this->set(compact('grupoUsuario'));
        $this->set('_serialize', ['grupoUsuario']);

        $this->_crumbs['Edição'] = Router::url(['action' => 'edit']);
        $this->set('crumbs', $this->_crumbs);
    }

    /**
     * Delete method
     *
     * @param string|null $id Grupo Usuario id.
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
     * @param int|array $ids GrupoUsuarios ids.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException Quando o registro não é encontrado.
     */
    private function _handleDelete($ids) {
        if (!is_array($ids)) {
            $ids = [$ids];
        }

        $conn = ConnectionManager::get($this->GrupoUsuarios->defaultConnectionName());
        $conn->begin();
        try {
            foreach ($ids as $id) {
                $grupoUsuario = $this->GrupoUsuarios->get($id);
                if (!$this->GrupoUsuarios->delete($grupoUsuario)) {
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
