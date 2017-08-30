<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Manager;

use Cake\Localized\Validation\BrValidation;

/**
 * Pessoas Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Cidades
 * @property \Cake\ORM\Association\BelongsTo $FornecedorPertencentes
 * @property \Cake\ORM\Association\HasMany $ContaRecebers
 * @property \Cake\ORM\Association\HasMany $Fornecedores
 * @property \Cake\ORM\Association\HasMany $Funcionarios
 *
 * @method \App\Model\Entity\Pessoa get($primaryKey, $options = [])
 * @method \App\Model\Entity\Pessoa newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Pessoa[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Pessoa|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pessoa patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Pessoa[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Pessoa findOrCreate($search, callable $callback = null, $options = [])
 */
class PessoasTable extends Table
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

        $this->setTable('pessoas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Cidades', [
            'foreignKey' => 'cidade_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Fornecedores', [
            'foreignKey' => 'fornecedor_pertencente_id'
        ]);
        $this->hasMany('ContaRecebers', [
            'foreignKey' => 'pessoa_id'
        ]);
        $this->hasMany('Fornecedores', [
            'foreignKey' => 'pessoa_id'
        ]);
        $this->hasMany('Funcionarios', [
            'foreignKey' => 'pessoa_id'
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
            ->requirePresence('tipo_pessoa', 'create')
            ->notEmpty('tipo_pessoa');

        $validator
            ->requirePresence('nome_razaosocial', 'create')
            ->notEmpty('nome_razaosocial');

        $validator
            ->requirePresence('sobrenome_nomefantasia', 'create')
            ->notEmpty('sobrenome_nomefantasia');

        $validator
            ->setProvider('br', BrValidation::class)
            ->requirePresence('cpfcnpj', 'create')
            ->notEmpty('cpfcnpj')
            ->add('cpfcnpj', 'validaCPFCNPJ', [
                'rule' => 'personId',
                'message' => 'CPF/CNPJ inválido!',
                'provider' => 'br',
            ]);

        $validator
            ->requirePresence('rua', 'create')
            ->notEmpty('rua');

        $validator
            ->allowEmpty('numero');

        $validator
            ->allowEmpty('bairro');

        $validator
            ->notEmpty('cep');

        $validator
            ->requirePresence('telefone_1', 'create')
            ->notEmpty('telefone_1');

        $validator
            ->allowEmpty('telefone_2');

        $validator
            ->email('email')
            ->notEmpty('email');

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
        $rules->add($rules->isUnique(['cpfcnpj']));
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['cidade_id'], 'Cidades'));
        $rules->add($rules->existsIn(['fornecedor_pertencente_id'], 'Fornecedores'));

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
