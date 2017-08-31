<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Manager;

/**
 * TipoProdutos Model
 *
 * @property \Cake\ORM\Association\HasMany $Produtos
 *
 * @method \App\Model\Entity\TipoProduto get($primaryKey, $options = [])
 * @method \App\Model\Entity\TipoProduto newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TipoProduto[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TipoProduto|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoProduto patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TipoProduto[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TipoProduto findOrCreate($search, callable $callback = null, $options = [])
 */
class TipoProdutosTable extends Table
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

        $this->setTable('tipo_produtos');
        $this->setDisplayField('nome');
        $this->setPrimaryKey('id');

        $this->hasMany('Produtos', [
            'foreignKey' => 'tipo_produto_id'
        ]);

        $this->addBehavior('Search.Search');

        $this->addBehavior('Proffer.Proffer', [
            'nome' => [
                'dir' => 'nome_dir',
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
            ->like('sigla', [
                'after' => true,
            ])
            ->value('status');
        return $search;
    }
}
