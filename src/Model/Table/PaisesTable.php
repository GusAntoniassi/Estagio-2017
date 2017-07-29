<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Paises Model
 *
 * @property \Cake\ORM\Association\HasMany $Estados
 *
 * @method \App\Model\Entity\Pais get($primaryKey, $options = [])
 * @method \App\Model\Entity\Pais newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Pais[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Pais|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pais patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Pais[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Pais findOrCreate($search, callable $callback = null, $options = [])
 */
class PaisesTable extends Table
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

        $this->setTable('paises');
        $this->setDisplayField('nome');
        $this->setPrimaryKey('id');

        $this->hasMany('Estados', [
            'foreignKey' => 'pais_id'
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
            ->allowEmpty('sigla');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }
}
