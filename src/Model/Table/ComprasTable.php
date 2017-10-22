<?php
namespace App\Model\Table;

use Cake\I18n\Date;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Manager;

/**
 * Compras Model
 *
 * @property \Cake\ORM\Association\BelongsTo $PedidoCompras
 * @property \Cake\ORM\Association\BelongsTo $FormaPagamentos
 * @property \Cake\ORM\Association\BelongsTo $Fornecedores
 * @property \Cake\ORM\Association\HasMany $ContaPagars
 * @property \Cake\ORM\Association\HasMany $ItemCompras
 *
 * @method \App\Model\Entity\Compra get($primaryKey, $options = [])
 * @method \App\Model\Entity\Compra newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Compra[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Compra|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Compra patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Compra[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Compra findOrCreate($search, callable $callback = null, $options = [])
 */
class ComprasTable extends Table
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

        $this->setTable('compras');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('PedidoCompras', [
            'foreignKey' => 'pedido_compra_id'
        ]);
        $this->belongsTo('FormaPagamentos', [
            'foreignKey' => 'forma_pagamento_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Fornecedores', [
            'foreignKey' => 'fornecedor_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('ContaPagars', [
            'foreignKey' => 'compra_id'
        ]);
        $this->hasMany('ItemCompras', [
            'foreignKey' => 'compra_id',
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
            ->date('data_compra', 'dmy')
            ->requirePresence('data_compra', 'create')
            ->notEmpty('data_compra')
            ->add('data_compra', 'validaDataFutura',  [
                'rule' => function ($valor, $contexto) {
                    $date = Date::createFromFormat('d/m/Y', $valor);
                    return (!$date->isFuture());
                },
                'message' => 'Data não pode ser futura!'
            ]);

        $validator
            ->decimal('valor_liquido')
            ->requirePresence('valor_liquido', 'create')
            ->notEmpty('valor_liquido');

        $validator
            ->decimal('descontos')
            ->requirePresence('descontos', 'create')
            ->notEmpty('descontos')
            ->add('descontos', 'menorQueValorLiquido', [
                'rule' => 'validaMenorQueValorLiquido',
                'message' => 'Desconto não pode ser maior que o valor líquido!',
                'provider' => 'table',
            ]);

        $validator
            ->decimal('valor_total')
            ->requirePresence('valor_total', 'create')
            ->notEmpty('valor_total');

        $validator
            ->decimal('entrada')
            ->allowEmpty('entrada')
            ->add('entrada', 'menorQueValorTotal', [
                'rule' => 'validaMenorQueValorTotal',
                'message' => 'Entrada não pode ser maior que o valor total!',
                'provider' => 'table',
            ]);

        $validator
            ->allowEmpty('comentarios');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->allowEmpty('status', 'update');

        return $validator;
    }

    public function validaMenorQueValorLiquido($valor, $table) {
        return ($this->getFloat($valor) <= $this->getFloat($table['data']['valor_liquido']));
    }
    public function validaMenorQueValorTotal($valor, $table) {
        return ($this->getFloat($valor) <= $this->getFloat($table['data']['valor_total']));
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
        $rules->add($rules->existsIn(['pedido_compra_id'], 'PedidoCompras'));
        $rules->add($rules->existsIn(['forma_pagamento_id'], 'FormaPagamentos'));
        $rules->add($rules->existsIn(['fornecedor_id'], 'Fornecedores'));

        $rules->addDelete(function ($entity, $options) {
            return !$entity->status;
        }, 'validaCompraFechada', [
            'errorField' => 'status',
            'message' => 'Não é possível excluir uma compra que já foi fechada!'
        ]);

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
            ->value('status')
            ->value('forma_pagamento_id')
            ->value('fornecedor_id');
        return $search;
    }

    private function getFloat($str) {
        if(strstr($str, ",")) {
            $str = str_replace(".", "", $str); // replace dots (thousand seps) with blancs
            $str = str_replace(",", ".", $str); // replace ',' with '.'
        }

        if(preg_match("#([0-9\.]+)#", $str, $match)) { // search for number that may contain '.'
            return floatval($match[0]);
        } else {
            return floatval($str); // take some last chances with floatval
        }
    }
}
