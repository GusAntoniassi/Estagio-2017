<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Manager;

/**
 * ContaPagars Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Fornecedores
 * @property \Cake\ORM\Association\BelongsTo $Compras
 * @property \Cake\ORM\Association\BelongsTo $FormaPagamentos
 * @property \Cake\ORM\Association\HasMany $ParcelaContaPagars
 *
 * @method \App\Model\Entity\ContaPagar get($primaryKey, $options = [])
 * @method \App\Model\Entity\ContaPagar newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ContaPagar[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ContaPagar|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ContaPagar patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ContaPagar[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ContaPagar findOrCreate($search, callable $callback = null, $options = [])
 */
class ContaPagarsTable extends Table
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

        $this->setTable('conta_pagars');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Fornecedores', [
            'foreignKey' => 'fornecedor_id'
        ]);
        $this->belongsTo('Compras', [
            'foreignKey' => 'compra_id'
        ]);
        $this->belongsTo('FormaPagamentos', [
            'foreignKey' => 'forma_pagamento_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('ParcelaContaPagars', [
            'foreignKey' => 'conta_pagar_id',
            'dependent' => true,
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
            ->requirePresence('descricao', 'create')
            ->notEmpty('descricao');

        $validator
            ->decimal('valor')
            ->requirePresence('valor', 'create')
            ->notEmpty('valor');

        $validator
            ->dateTime('data_cadastro', 'dmy')
            ->requirePresence('data_cadastro', 'create')
            ->notEmpty('data_cadastro');

        $validator
            ->dateTime('data_pagamento', 'dmy')
            ->allowEmpty('data_pagamento');

        $validator
            ->boolean('pago')
            ->requirePresence('pago', 'create')
            ->notEmpty('pago');

        $validator
            ->integer('num_parcelas')
            ->requirePresence('num_parcelas', 'create')
            ->notEmpty('num_parcelas');

        $validator
            ->allowEmpty('comentarios');

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
        $rules->add($rules->existsIn(['fornecedor_id'], 'Fornecedores'));
        $rules->add($rules->existsIn(['compra_id'], 'Compras'));
        $rules->add($rules->existsIn(['forma_pagamento_id'], 'FormaPagamentos'));

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
            ->value('status');
        return $search;
    }

}
