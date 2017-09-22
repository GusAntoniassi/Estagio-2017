<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ItemCompras Model
 *
 * @property \App\Model\Table\ProdutosTable|\Cake\ORM\Association\BelongsTo $Produtos
 * @property \App\Model\Table\ComprasTable|\Cake\ORM\Association\BelongsTo $Compras
 * @property \App\Model\Table\LotesComprasTable|\Cake\ORM\Association\HasMany $LotesCompras
 *
 * @method \App\Model\Entity\ItemCompra get($primaryKey, $options = [])
 * @method \App\Model\Entity\ItemCompra newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ItemCompra[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ItemCompra|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ItemCompra patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ItemCompra[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ItemCompra findOrCreate($search, callable $callback = null, $options = [])
 */
class ItemComprasTable extends Table
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

        $this->setTable('item_compras');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Compras', [
            'foreignKey' => 'compra_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('LotesCompras', [
            'foreignKey' => 'item_compra_id'
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

        $validator
            ->decimal('valor_unitario')
            ->requirePresence('valor_unitario', 'create')
            ->notEmpty('valor_unitario');

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
        $rules->add($rules->existsIn(['compra_id'], 'Compras'));

        return $rules;
    }
}
