<?php
namespace App\Model\Entity;

use App\Model\Entity;;

/**
 * Funcionario Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenDate $data_nascimento
 * @property bool $horista
 * @property float $valor_hora
 * @property bool $status
 * @property int $pessoa_id
 *
 * @property \App\Model\Entity\Pessoa $pessoa
 * @property \App\Model\Entity\Caixa[] $caixa
 * @property \App\Model\Entity\Comanda[] $comandas
 * @property \App\Model\Entity\LancamentoHora[] $lancamento_horas
 */
class Funcionario extends Entity
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
