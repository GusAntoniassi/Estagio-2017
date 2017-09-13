<?php
namespace App\View\Cell;

use App\Model\Entity\Lote;
use App\Model\Entity\Produto;
use Cake\ORM\TableRegistry;
use Cake\View\Cell;

/**
 * LinhaTabela cell
 */
class LinhaTabelaCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    public $helpers = ['Number', 'Proffer.Proffer'];

    /**
     * Default display method.
     *
     * @return void
     */
    public function produto(Produto $produto, $linhaTabela = 0, $quantidade = 1, $custo = null) {
        if ($custo === null) {
            $custo = $produto->custo;
        }

        $this->set(compact('produto', 'linhaTabela', 'quantidade', 'custo'));
    }

    public function lote(Lote $lote = null, $linhaTabela = 0, $linhaTabelaLote = 0, $produtoId = 0) {
        if ($lote === null) {
            $lote = TableRegistry::get('Lotes')->newEntity();
        } else {
            $produtoId = $lote->produto->id;
        }

        $this->set(compact('lote', 'linhaTabela', 'linhaTabelaLote', 'produtoId'));
    }
}
