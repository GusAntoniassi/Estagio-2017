<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LotesCompra Entity
 *
 * @property int $id
 * @property int $quantidade
 * @property int $item_compra_id
 * @property int $lote_id
 *
 * @property \App\Model\Entity\ItemCompra $item_compra
 * @property \App\Model\Entity\Lote $lote
 */
class LotesCompra extends Entity
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
