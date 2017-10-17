<?php

namespace App\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Search\Manager;

/**
 * Lotes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Produtos
 * @property \Cake\ORM\Association\HasMany $BaixaProdutos
 *
 * @method \App\Model\Entity\Lote get($primaryKey, $options = [])
 * @method \App\Model\Entity\Lote newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Lote[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Lote|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Lote patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Lote[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Lote findOrCreate($search, callable $callback = null, $options = [])
 */
class LotesTable extends Table
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

        $this->setTable('lotes');
        $this->setDisplayField('num_lote');
        $this->setPrimaryKey('id');

        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('BaixaProdutos', [
            'foreignKey' => 'lote_id',
            'dependent' => true
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
            ->requirePresence('num_lote', 'create')
            ->notEmpty('num_lote');

        // TODO: Tirar validação, deixar default 0
        $validator
            ->integer('qtde_estoque')
            ->allowEmpty('qtde_estoque');

        $validator
            ->date('data_vencimento', 'dmy')
            ->requirePresence('data_vencimento', 'create')
            ->notEmpty('data_vencimento');

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
        $rules->add($rules->existsIn(['produto_id'], 'Produtos'));

        return $rules;
    }

    /**
     * Configuração dos campos utilizados pelo plugin Search
     *
     * @return \Search\Manager
     */
    public function searchConfiguration()
    {
        $search = new Manager($this);
        $search
            ->value('id')
            ->like('num_lote', [
                'before' => true,
                'after' => true,
            ])
            ->value('data_vencimento')
            ->value('status');
        return $search;
    }

    public function beforeSave(Event $event, EntityInterface $entity, \ArrayObject $options) {
        if (!isset($entity->id)) {
            $loteIgual = $this->findByNumLote($entity->num_lote)->first();
            if (!empty($loteIgual)) {
                if ($loteIgual->produto_id != $entity->produto_id) {
                    throw new \Exception; // TODO: Verificar, lançar uma exception melhor
                }

                // Se já existir um lote com aquele código, apenas atualizar os valores do lote
                $loteIgual->qtde_estoque += $entity->qtde_estoque;
                $loteIgual->data_vencimento = $entity->data_vencimento;
                $loteIgual->status = $entity->status;

                $this->save($loteIgual);
                $event->stopPropagation();
                return $loteIgual;
            }

        }
    }

}
