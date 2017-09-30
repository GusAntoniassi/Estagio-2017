<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Manager;

/**
 * FormaPagamentos Model
 *
 * @property \Cake\ORM\Association\HasMany $Compras
 * @property \Cake\ORM\Association\HasMany $ContaPagars
 * @property \Cake\ORM\Association\HasMany $ContaRecebers
 * @property \Cake\ORM\Association\HasMany $PedidoCompras
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
        $this->setDisplayField('nome');
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
            ->value('num_parcelas')
            ->value('status');
        return $search;
    }

}
