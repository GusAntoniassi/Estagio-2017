<?php
namespace App\Model\Entity;

use App\Model\Entity;;

/**
 * Produto Entity
 *
 * @property int $id
 * @property string $nome
 * @property bool $produto_acabado
 * @property bool $reduz_estoque
 * @property bool $possui_lote
 * @property int $qtde_estoque
 * @property float $preco
 * @property float $custo
 * @property bool $status
 * @property int $tipo_produto_id
 *
 * @property \App\Model\Entity\TipoProduto $tipo_produto
 * @property \App\Model\Entity\ItemComanda[] $item_comandas
 * @property \App\Model\Entity\ItemCompra[] $item_compras
 * @property \App\Model\Entity\ItemOrcamento[] $item_orcamentos
 * @property \App\Model\Entity\ItemPedidoCompra[] $item_pedido_compras
 * @property \App\Model\Entity\Lote[] $lotes
 */
class Produto extends Entity
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
