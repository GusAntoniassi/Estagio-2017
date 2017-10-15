<?php
namespace App\Model\Table;

use App\Model\Entity\Fornecedor;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Search\Manager;

/**
 * Fornecedores Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Pessoas
 * @property \Cake\ORM\Association\HasMany $Compras
 * @property \Cake\ORM\Association\HasMany $ContaPagars
 * @property \Cake\ORM\Association\HasMany $Orcamentos
 * @property \Cake\ORM\Association\HasMany $PedidoCompras
 *
 * @method \App\Model\Entity\Fornecedor get($primaryKey, $options = [])
 * @method \App\Model\Entity\Fornecedor newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Fornecedor[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Fornecedor|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Fornecedor patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Fornecedor[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Fornecedor findOrCreate($search, callable $callback = null, $options = [])
 */
class FornecedoresTable extends Table
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

        $this->setTable('fornecedores');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Pessoas', [
            'foreignKey' => 'pessoa_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Compras', [
            'foreignKey' => 'fornecedor_id'
        ]);
        $this->hasMany('ContaPagars', [
            'foreignKey' => 'fornecedor_id'
        ]);
        $this->hasMany('Orcamentos', [
            'foreignKey' => 'fornecedor_id'
        ]);
        $this->hasMany('PedidoCompras', [
            'foreignKey' => 'fornecedor_id'
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
            ->boolean('status')
            ->notEmpty('status');

        $validator
            ->allowEmpty('comentarios');

        $validator
            ->boolean('dia_semana_visita')
            ->allowEmpty('dia_semana_visita');

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
        $rules->add($rules->existsIn(['pessoa_id'], 'Pessoas'));

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
            ->like('Pessoas.cpfcnpj', [
                'before' => true,
                'after' => true,
            ])
            ->like('Pessoas.nome_razaosocial', [
                'before' => true,
                'after' => true,
            ])
            ->like('Pessoas.sobrenome_nomefantasia', [
                'before' => true,
                'after' => true,
            ])
            ->value('status');
        return $search;
    }
}
