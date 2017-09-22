<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ItemCompra Entity
 *
 * @property int $id
 * @property int $produto_id
 * @property int $compra_id
 * @property int $quantidade
 * @property float $valor_unitario
 *
 * @property \App\Model\Entity\Produto $produto
 * @property \App\Model\Entity\Compra $compra
 * @property \App\Model\Entity\LotesCompra[] $lotes_compras
 */
class ItemCompra extends Entity
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
