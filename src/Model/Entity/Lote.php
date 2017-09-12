<?php
namespace App\Model\Entity;

use App\Model\Entity;;

/**
 * Lote Entity
 *
 * @property int $id
 * @property string $num_lote
 * @property int $qtde_estoque
 * @property \Cake\I18n\FrozenDate $data_vencimento
 * @property bool $status
 * @property int $produto_id
 *
 * @property \App\Model\Entity\Produto $produto
 * @property \App\Model\Entity\BaixaProdutos[] $baixa_produto
 */
class Lote extends Entity
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
