<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Manager;

/**
 * Estados Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Paises
 * @property \Cake\ORM\Association\HasMany $Cidades
 *
 * @method \App\Model\Entity\Estado get($primaryKey, $options = [])
 * @method \App\Model\Entity\Estado newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Estado[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Estado|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Estado patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Estado[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Estado findOrCreate($search, callable $callback = null, $options = [])
 */
class EstadosTable extends Table
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

        $this->setTable('estados');
        $this->setDisplayField('nome');
        $this->setPrimaryKey('id');

        $this->belongsTo('Paises', [
            'foreignKey' => 'pais_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Cidades', [
            'foreignKey' => 'estado_id'
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
            ->requirePresence('sigla', 'create')
            ->notEmpty('sigla');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['pais_id'], 'Paises'));

        return $rules;
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
            ->like('sigla', [
                'after' => true,
            ])
            ->value('pais_id')
            ->value('status');
        return $search;
    }
}
