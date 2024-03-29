<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Manager;

/**
 * GrupoUsuarios Model
 *
 * @property \Cake\ORM\Association\HasMany $Usuarios
 *
 * @method \App\Model\Entity\GrupoUsuario get($primaryKey, $options = [])
 * @method \App\Model\Entity\GrupoUsuario newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\GrupoUsuario[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GrupoUsuario|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GrupoUsuario patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\GrupoUsuario[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\GrupoUsuario findOrCreate($search, callable $callback = null, $options = [])
 */
class GrupoUsuariosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('grupo_usuarios');
        $this->setDisplayField('nome');
        $this->setPrimaryKey('id');

        $this->hasMany('Usuarios', [
            'foreignKey' => 'grupo_usuario_id'
        ]);

        $this->addBehavior('Search.Search');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('nome', 'create')
            ->notEmpty('nome');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }


    /**
     * Configuração dos campos utilizados pelo plugin Search
     *
     * @return \Search\Manager
     */
    public function searchConfiguration() {
        $search = new Manager($this);
        $search
            ->value('id')
            ->like('nome', [
                'before' => true,
                'after' => true,
            ])
            ->value('status');
        return $search;
    }
}
