<?php
namespace App\Model\Entity;

use App\Model\Entity;;

/**
 * Pessoa Entity
 *
 * @property int $id
 * @property string $tipo_pessoa
 * @property string $nome_razaosocial
 * @property string $sobrenome_nomefantasia
 * @property string $cpfcnpj
 * @property string $rua
 * @property string $numero
 * @property string $bairro
 * @property string $cep
 * @property string $telefone_1
 * @property string $telefone_2
 * @property string $email
 * @property int $cidade_id
 * @property int $fornecedor_pertencente_id
 *
 * @property \App\Model\Entity\Cidade $cidade
 * @property \App\Model\Entity\Fornecedor[] $fornecedores
 * @property \App\Model\Entity\ContaReceber[] $conta_recebers
 * @property \App\Model\Entity\Funcionario[] $funcionarios
 */
class Pessoa extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
