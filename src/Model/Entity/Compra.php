<?php
namespace App\Model\Entity;

use App\Model\Entity;;

/**
 * Compra Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenDate $data_compra
 * @property float $valor_liquido
 * @property float $descontos
 * @property float $valor_total
 * @property string $comentarios
 * @property bool $status
 * @property int $pedido_compra_id
 * @property int $forma_pagamento_id
 * @property int $fornecedor_id
 *
 * @property \App\Model\Entity\PedidoCompra $pedido_compra
 * @property \App\Model\Entity\FormaPagamento $forma_pagamento
 * @property \App\Model\Entity\Fornecedor $fornecedor
 * @property \App\Model\Entity\ContaPagar[] $conta_pagars
 * @property \App\Model\Entity\ItemCompra[] $item_compras
 */
class Compra extends Entity
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
