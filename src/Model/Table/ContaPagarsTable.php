<?php
namespace App\Model\Table;

use App\Model\Entity\ContaPagar;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Search\Manager;

/**
 * ContaPagars Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Fornecedores
 * @property \Cake\ORM\Association\BelongsTo $Compras
 * @property \Cake\ORM\Association\BelongsTo $FormaPagamentos
 * @property \Cake\ORM\Association\HasMany $ParcelaContaPagars
 *
 * @method \App\Model\Entity\ContaPagar get($primaryKey, $options = [])
 * @method \App\Model\Entity\ContaPagar newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ContaPagar[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ContaPagar|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ContaPagar patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ContaPagar[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ContaPagar findOrCreate($search, callable $callback = null, $options = [])
 */
class ContaPagarsTable extends Table
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

        $this->setTable('conta_pagars');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Fornecedores', [
            'foreignKey' => 'fornecedor_id'
        ]);
        $this->belongsTo('Compras', [
            'foreignKey' => 'compra_id'
        ]);
        $this->belongsTo('FormaPagamentos', [
            'foreignKey' => 'forma_pagamento_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('ParcelaContaPagars', [
            'foreignKey' => 'conta_pagar_id',
            'dependent' => true,
            'cascadeCallbacks' => true
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
            ->requirePresence('descricao', 'create')
            ->notEmpty('descricao');

        $validator
            ->decimal('valor')
            ->requirePresence('valor', 'create')
            ->notEmpty('valor');

        $validator
            ->dateTime('data_cadastro', 'dmy')
            ->allowEmpty('data_cadastro');

        $validator
            ->dateTime('data_pagamento', 'dmy')
            ->allowEmpty('data_pagamento');

        $validator
            ->boolean('pago')
            ->allowEmpty('data_cadastro');

        $validator
            ->integer('num_parcelas')
            ->allowEmpty('num_parcelas');

        $validator
            ->allowEmpty('comentarios');

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
        $rules->add($rules->existsIn(['fornecedor_id'], 'Fornecedores'));
        $rules->add($rules->existsIn(['compra_id'], 'Compras'));
        $rules->add($rules->existsIn(['forma_pagamento_id'], 'FormaPagamentos'));

        $rules->addDelete(function ($entity, $options) {
            return empty($entity->compra_id); // Permite excluir apenas se não houver compra_id
        }, 'validaContaPagar', [
            'errorField' => 'status',
            'message' => 'Não é possível excluir uma conta a pagar gerada a partir de uma compra!'
        ]);

        // TODO: Validar excluir com uma ou mais parcelas pagas
        $rules->addDelete(function ($entity, $options) {
             $parcelasTable = TableRegistry::get('ParcelaContaPagars');
             $parcelasPagas = $parcelasTable->find('parcelasPagas', [
                'conta_pagar_id' => $entity->id,
             ]);
             return ($parcelasPagas->count() <= 0);
        }, 'validaContaPagar', [
            'errorField' => 'status',
            'message' => 'Não é possível excluir uma conta que possui uma ou mais parcelas pagas!'
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
            ->like('descricao', [
                'before' => true,
                'after' => true,
            ])
            ->value('valor')
            ->value('pago')
            ->value('fornecedor_id')
            ->value('forma_pagamento_id')
            ->value('status');
        return $search;
    }

    public function beforeSave(Event $event, ContaPagar $entity, \ArrayObject $options) {
        if ($entity->isNew()) {
            $entity->data_cadastro = Time::now();
        }
        if (empty($entity->num_parcelas) && !empty($entity->forma_pagamento_id)) {
            $formaPagamentosTable = TableRegistry::get('FormaPagamentos');
            $formaPagamento = $formaPagamentosTable->findById($entity->forma_pagamento_id)->first();

            $entity->num_parcelas = $formaPagamento->num_parcelas;
        }
        return true;
    }

}
