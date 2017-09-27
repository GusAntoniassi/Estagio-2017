<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Manager;

/**
 * ParcelaContaPagars Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ContaPagars
 * @property \Cake\ORM\Association\HasMany $Pagamentos
 *
 * @method \App\Model\Entity\ParcelaContaPagar get($primaryKey, $options = [])
 * @method \App\Model\Entity\ParcelaContaPagar newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ParcelaContaPagar[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ParcelaContaPagar|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ParcelaContaPagar patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ParcelaContaPagar[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ParcelaContaPagar findOrCreate($search, callable $callback = null, $options = [])
 */
class ParcelaContaPagarsTable extends Table
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

        $this->setTable('parcela_conta_pagars');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('ContaPagars', [
            'foreignKey' => 'conta_pagar_id',
            'joinType' => 'INNER'
        ]);
        $this->hasOne('Pagamentos', [
            'foreignKey' => 'parcela_conta_pagar_id'
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
            ->decimal('valor')
            ->requirePresence('valor', 'create')
            ->notEmpty('valor');

        $validator
            ->date('data_vencimento', 'dmy')
            ->requirePresence('data_vencimento', 'create')
            ->notEmpty('data_vencimento');

        $validator
            ->boolean('pago')
            ->requirePresence('pago', 'create')
            ->notEmpty('pago');

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
        $rules->add($rules->existsIn(['conta_pagar_id'], 'ContaPagars'));

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
