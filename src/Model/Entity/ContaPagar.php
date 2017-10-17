<?php
namespace App\Model\Entity;

use App\Model\Entity;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

;

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

    public function geraParcelas($entrada = 0, $dias_carencia = 0, $dataCadastro = null) {
        $numParcelas = $this->num_parcelas;
        $valorConta = $this->valor;

        // Gerar parcelas
        $parcelaContaPagarsTable = TableRegistry::get('ParcelaContaPagars');
        if (empty($dataCadastro)) {
            $dataCadastro = Time::now();
        }

        // Se tiver entrada, gravar uma parcela para a data atual
        if ($entrada > 0) {
            $parcelaContaPagars = $parcelaContaPagarsTable->newEntity();
            $parcelaContaPagars->nome = 'Entrada';
            $parcelaContaPagars->valor = $entrada;
            $parcelaContaPagars->data_vencimento = $dataCadastro;
            $parcelaContaPagars->pago = false;
            $parcelaContaPagars->conta_pagar_id = $this->id;
            $parcelaContaPagarsTable->save($parcelaContaPagars);
            $numParcelas--;
            $valorConta -= $entrada;
        }

        // Adicionar a carência necessária
        if ($dias_carencia > 0) {
            $dataCadastro = $dataCadastro->addDays($dias_carencia);
        }

        if ($numParcelas > 0) {
            // Valor de cada uma das parcelas, ignorar casas decimais após as 2 primeiras
            $valorParcela = bcdiv(number_format($valorConta, 2, '.', ''), (string)$numParcelas, '2');

            // Gravar as parcelas restantes
            for ($i = 1; $i <= $numParcelas; $i++) {
                $parcelaContaPagars = $parcelaContaPagarsTable->newEntity();
                if ($numParcelas == 1) {
                    $parcelaContaPagars->nome = 'Parcela única';
                } else {
                    $parcelaContaPagars->nome = sprintf("Parcela %d de %d", $i, $numParcelas);
                }
                if ($i == $numParcelas) { // Se for a última parcela, acrescentar o que sobrou da divisão
                    $sobra = ($valorConta - ($valorParcela * $numParcelas));
                    $parcelaContaPagars->valor = $valorParcela + $sobra;
                } else {
                    $parcelaContaPagars->valor = $valorParcela;
                }
                $parcelaContaPagars->data_vencimento = $dataCadastro;
                $parcelaContaPagars->pago = false;
                $parcelaContaPagars->conta_pagar_id = $this->id;
                $parcelaContaPagarsTable->save($parcelaContaPagars);

                // FIXO: Intervalo entre parcelas é de um mês
                $dataCadastro = $dataCadastro->addMonth(1);
            }
        }

        return true;
    }
}
