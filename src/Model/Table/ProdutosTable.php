<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Manager;

/**
 * Produtos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $TipoProdutos
 * @property \Cake\ORM\Association\HasMany $ItemComandas
 * @property \Cake\ORM\Association\HasMany $ItemCompras
 * @property \Cake\ORM\Association\HasMany $ItemOrcamentos
 * @property \Cake\ORM\Association\HasMany $ItemPedidoCompras
 * @property \Cake\ORM\Association\HasMany $Lotes
 *
 * @method \App\Model\Entity\Produto get($primaryKey, $options = [])
 * @method \App\Model\Entity\Produto newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Produto[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Produto|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Produto patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Produto[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Produto findOrCreate($search, callable $callback = null, $options = [])
 */
class ProdutosTable extends Table
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

        $this->setTable('produtos');
        $this->setDisplayField('nome');
        $this->setPrimaryKey('id');

        $this->belongsTo('TipoProdutos', [
            'foreignKey' => 'tipo_produto_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('ItemComandas', [
            'foreignKey' => 'produto_id'
        ]);
        $this->hasMany('ItemCompras', [
            'foreignKey' => 'produto_id'
        ]);
        $this->hasMany('ItemOrcamentos', [
            'foreignKey' => 'produto_id'
        ]);
        $this->hasMany('ItemPedidoCompras', [
            'foreignKey' => 'produto_id'
        ]);
        $this->hasMany('Lotes', [
            'foreignKey' => 'produto_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);

        $this->addBehavior('Search.Search');

        $this->addBehavior('Proffer.Proffer', [
            'foto' => [
                'dir' => 'foto_dir',
                'thumbnailSizes' => [
                    'thumb' => [
                        'w' => 45,
                        'h' => 45,
                        'fit' => true
                    ]
                ]
            ]
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
            ->requirePresence('nome', 'create')
            ->notEmpty('nome');

        $validator
            ->boolean('produto_acabado')
            ->requirePresence('produto_acabado', 'create')
            ->notEmpty('produto_acabado');

        $validator
            ->boolean('reduz_estoque')
            ->requirePresence('reduz_estoque', 'create')
            ->notEmpty('reduz_estoque');

        $validator
            ->boolean('possui_lote')
            ->requirePresence('possui_lote', 'create')
            ->notEmpty('possui_lote');

        $validator
            ->integer('qtde_estoque')
            ->allowEmpty('qtde_estoque');

        $validator
            ->decimal('preco')
            ->allowEmpty('preco');

        $validator
            ->decimal('custo')
            ->allowEmpty('custo');

        $validator
            ->requirePresence('foto', 'create')
            ->allowEmpty('foto', 'update');

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
        $rules->add($rules->existsIn(['tipo_produto_id'], 'TipoProdutos'));

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
