<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ItemComprasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ItemComprasTable Test Case
 */
class ItemComprasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ItemComprasTable
     */
    public $ItemCompras;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.item_compras',
        'app.produtos',
        'app.tipo_produtos',
        'app.item_comandas',
        'app.item_orcamentos',
        'app.item_pedido_compras',
        'app.lotes',
        'app.baixa_produtos',
        'app.compras',
        'app.pedido_compras',
        'app.forma_pagamentos',
        'app.conta_pagars',
        'app.conta_recebers',
        'app.fornecedores',
        'app.pessoas',
        'app.cidades',
        'app.estados',
        'app.paises',
        'app.funcionarios',
        'app.caixa',
        'app.comandas',
        'app.lancamento_horas',
        'app.orcamentos',
        'app.lotes_compras'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ItemCompras') ? [] : ['className' => ItemComprasTable::class];
        $this->ItemCompras = TableRegistry::get('ItemCompras', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ItemCompras);

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
