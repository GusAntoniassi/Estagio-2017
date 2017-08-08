<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FormaPagamentos Model
 *
 * @property \App\Model\Table\ComprasTable|\Cake\ORM\Association\HasMany $Compras
 * @property \App\Model\Table\ContaPagarsTable|\Cake\ORM\Association\HasMany $ContaPagars
 * @property \App\Model\Table\ContaRecebersTable|\Cake\ORM\Association\HasMany $ContaRecebers
 * @property \App\Model\Table\PedidoComprasTable|\Cake\ORM\Association\HasMany $PedidoCompras
 *
 * @method \App\Model\Entity\FormaPagamento get($primaryKey, $options = [])
 * @method \App\Model\Entity\FormaPagamento newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FormaPagamento[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FormaPagamento|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FormaPagamento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FormaPagamento[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FormaPagamento findOrCreate($search, callable $callback = null, $options = [])
 */
class FormaPagamentosTable extends Table
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

        $this->setTable('forma_pagamentos');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Compras', [
            'foreignKey' => 'forma_pagamento_id'
        ]);
        $this->hasMany('ContaPagars', [
            'foreignKey' => 'forma_pagamento_id'
        ]);
        $this->hasMany('ContaRecebers', [
            'foreignKey' => 'forma_pagamento_id'
        ]);
        $this->hasMany('PedidoCompras', [
            'foreignKey' => 'forma_pagamento_id'
        ]);
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
            ->allowEmpty('nome');

        $validator
            ->integer('num_parcelas')
            ->requirePresence('num_parcelas', 'create')
            ->notEmpty('num_parcelas');

        $validator
            ->integer('dias_carencia_primeira_parcela')
            ->requirePresence('dias_carencia_primeira_parcela', 'create')
            ->notEmpty('dias_carencia_primeira_parcela');

        $validator
            ->decimal('entrada')
            ->allowEmpty('entrada');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }
}