<?php
namespace App\Model\Entity;

use App\Model\Entity;;

/**
 * ParcelaContaPagar Entity
 *
 * @property int $id
 * @property float $valor
 * @property \Cake\I18n\FrozenDate $data_vencimento
 * @property bool $pago
 * @property int $conta_pagar_id
 *
 * @property \App\Model\Entity\ContaPagar $conta_pagar
 */
class ParcelaContaPagar extends Entity
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
