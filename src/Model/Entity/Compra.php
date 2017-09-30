<?php
namespace App\Model\Entity;

use App\Model\Entity;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

;

/**
 * Compra Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenDate $data_compra
 * @property float $valor_liquido
 * @property float $descontos
 * @property float $valor_total
 * @property float $entrada
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

    public function fecharCompra() {
        dd($this);
        /*=========== Entrada de estoque ==========*/
        foreach ($this->item_compras as $itemCompra) {
            if (empty($itemCompra->lote_compras)) { // Não possui lote, baixa de estoque direto no produto
                $produtosTable = TableRegistry::get('Produtos');
                $produto = $produtosTable->get($itemCompra->produto_id);
                $produto->qtde_estoque += $itemCompra->quantidade;
                $produtosTable->save($produto);
            } else { // Possui lotes
                foreach ($itemCompra->lote_compras as $loteCompra) { // Atualizar a qtdeEstoque de cada lote
                    $lotesTable = TableRegistry::get('Lotes');
                    // TODO: Verificar o que acontece se o lote já existir (não foi criado junto com o itemCompra)
                    $lote = $loteCompra->lote;
                    $lote->qtde_estoque += $loteCompra->quantidade;
                    $lotesTable->save($lote);
                }
            }
        }

        /*========== Contas a pagar =========*/
        $formaPagamentosTable = TableRegistry::get('FormaPagamentos');
        $formaPagamento = $formaPagamentosTable->get($this->forma_pagamento_id);

        // Criar o contas a pagar e setar os valores da compra nele
        $contaPagarsTable = TableRegistry::get('ContaPagars');
        $contaPagar = $contaPagarsTable->newEntity();
        $contaPagar->descricao = 'Compra #' . (int) $this->id;
        $contaPagar->valor = $this->valor_total;
        $contaPagar->data_cadastro = Time::now();
        $contaPagar->pago = false;

        $numParcelas = $formaPagamento->num_parcelas;
        // Se possuir entrada, incrementar a parcela em 1
        if ($this->entrada > 0) {
            $numParcelas++;
        }
        $contaPagar->num_parcelas = $numParcelas;
        $contaPagar->fornecedor_id = $this->fornecedor_id;
        $contaPagar->compra_id = $this->id;
        $contaPagar->forma_pagamento_id = $this->forma_pagamento_id;

        // Gravar o contas a pagar
        $contaPagarsTable->save($contaPagar);

        // Gerar parcelas
        $parcelaContaPagarsTable = TableRegistry::get('ParcelaContaPagars');
        $dataParcela = Time::now();
        // Se tiver entrada, gravar uma parcela para a data atual
        if ($this->entrada > 0) {
            $parcelaContaPagars = $parcelaContaPagarsTable->newEntity();
            $parcelaContaPagars->nome = 'Entrada';
            $parcelaContaPagars->valor = $this->entrada;
            $parcelaContaPagars->data_vencimento = $dataParcela;
            $parcelaContaPagars->pago = false;
            $parcelaContaPagars->conta_pagar_id = $contaPagar->id;
            $parcelaContaPagarsTable->save($parcelaContaPagars);
            $numParcelas--;
        }

        if ($numParcelas > 0) {
            // Valor de cada uma das parcelas
            $valorParcela = round($this->valor_total / $numParcelas, 2);

            // Gravar as parcelas restantes
            for ($i = 0; $i < $numParcelas; $i++) {
                // FIXO: Intervalo entre parcelas é de um mês
                $dataParcela = $dataParcela->addMonth(1);

                $parcelaContaPagars = $parcelaContaPagarsTable->newEntity();
                $parcelaContaPagars->nome = sprintf("Parcela %d de %d", ($i+1), $numParcelas);
                $parcelaContaPagars->valor = $valorParcela;
                $parcelaContaPagars->data_vencimento = $dataParcela;
                $parcelaContaPagars->pago = false;
                $parcelaContaPagars->conta_pagar_id = $contaPagar->id;
                $parcelaContaPagarsTable->save($parcelaContaPagars);
            }
        }

        return true;
    }
}
