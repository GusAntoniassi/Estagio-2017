<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PedidoComprasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PedidoComprasTable Test Case
 */
class PedidoComprasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PedidoComprasTable
     */
    public $PedidoCompras;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.pedido_compras',
        'app.orcamentos',
        'app.forma_pagamentos',
        'app.compras',
        'app.fornecedores',
        'app.pessoas',
        'app.cidades',
        'app.estados',
        'app.paises',
        'app.conta_recebers',
        'app.funcionarios',
        'app.caixa',
        'app.comandas',
        'app.lancamento_horas',
        'app.conta_pagars',
        'app.parcela_conta_pagars',
        'app.pagamentos',
        'app.item_compras',
        'app.produtos',
        'app.tipo_produtos',
        'app.item_comandas',
        'app.item_orcamentos',
        'app.item_pedido_compras',
        'app.lotes',
        'app.baixa_produtos',
        'app.lote_compras'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PedidoCompras') ? [] : ['className' => PedidoComprasTable::class];
        $this->PedidoCompras = TableRegistry::get('PedidoCompras', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PedidoCompras);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
