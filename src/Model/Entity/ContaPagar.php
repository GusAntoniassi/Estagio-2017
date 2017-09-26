<?php
namespace App\Model\Entity;

use App\Model\Entity;;

/**
 * ContaPagar Entity
 *
 * @property int $id
 * @property string $descricao
 * @property float $valor
 * @property \Cake\I18n\FrozenTime $data_cadastro
 * @property \Cake\I18n\FrozenTime $data_pagamento
 * @property bool $pago
 * @property int $num_parcelas
 * @property string $comentarios
 * @property int $fornecedor_id
 * @property int $compra_id
 * @property int $forma_pagamento_id
 *
 * @property \App\Model\Entity\Fornecedor $fornecedor
 * @property \App\Model\Entity\Compra $compra
 * @property \App\Model\Entity\FormaPagamento $forma_pagamento
 * @property \App\Model\Entity\ParcelaContaPagar[] $parcela_conta_pagars
 */
class ContaPagar extends Entity
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
