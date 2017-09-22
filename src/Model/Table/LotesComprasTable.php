<?php
namespace App\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * LotesCompras Model
 *
 * @property \App\Model\Table\ItemComprasTable|\Cake\ORM\Association\BelongsTo $ItemCompras
 * @property \App\Model\Table\LotesTable|\Cake\ORM\Association\BelongsTo $Lotes
 *
 * @method \App\Model\Entity\LotesCompra get($primaryKey, $options = [])
 * @method \App\Model\Entity\LotesCompra newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LotesCompra[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LotesCompra|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LotesCompra patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LotesCompra[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LotesCompra findOrCreate($search, callable $callback = null, $options = [])
 */
class LotesComprasTable extends Table
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

        $this->setTable('lotes_compras');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('ItemCompras', [
            'foreignKey' => 'item_compra_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Lotes', [
            'foreignKey' => 'lote_id',
            'joinType' => 'INNER'
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
            ->integer('quantidade')
            ->requirePresence('quantidade', 'create')
            ->notEmpty('quantidade');

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
        $rules->add($rules->existsIn(['item_compra_id'], 'ItemCompras'));
        $rules->add($rules->existsIn(['lote_id'], 'Lotes'));

        return $rules;
    }
}
