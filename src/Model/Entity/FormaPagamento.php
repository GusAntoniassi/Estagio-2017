<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FormaPagamento Entity
 *
 * @property int $id
 * @property string $nome
 * @property int $num_parcelas
 * @property int $dias_carencia_primeira_parcela
 * @property float $entrada
 * @property bool $status
 *
 * @property \App\Model\Entity\Compra[] $compras
 * @property \App\Model\Entity\ContaPagar[] $conta_pagars
 * @property \App\Model\Entity\ContaReceber[] $conta_recebers
 * @property \App\Model\Entity\PedidoCompra[] $pedido_compras
 */
class FormaPagamento extends Entity
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
