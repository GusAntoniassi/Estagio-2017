<?php
namespace App\Model\Entity;

use App\Model\Entity;;

/**
 * Fornecedor Entity
 *
 * @property int $id
 * @property bool $status
 * @property string $comentarios
 * @property bool $dia_semana_visita
 * @property int $pessoa_id
 *
 * @property \App\Model\Entity\Pessoa $pessoa
 * @property \App\Model\Entity\Compra[] $compras
 * @property \App\Model\Entity\ContaPagar[] $conta_pagars
 * @property \App\Model\Entity\Orcamento[] $orcamentos
 * @property \App\Model\Entity\PedidoCompra[] $pedido_compras
 */
class Fornecedor extends Entity
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
