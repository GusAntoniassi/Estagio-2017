<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ParcelaContaPagarsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ParcelaContaPagarsTable Test Case
 */
class ParcelaContaPagarsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ParcelaContaPagarsTable
     */
    public $ParcelaContaPagars;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.parcela_conta_pagars',
        'app.conta_pagars',
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
        'app.compras',
        'app.pedido_compras',
        'app.orcamentos',
        'app.forma_pagamentos',
        'app.item_pedido_compras',
        'app.item_compras',
        'app.produtos',
        'app.tipo_produtos',
        'app.item_comandas',
        'app.item_orcamentos',
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
        $config = TableRegistry::exists('ParcelaContaPagars') ? [] : ['className' => ParcelaContaPagarsTable::class];
        $this->ParcelaContaPagars = TableRegistry::get('ParcelaContaPagars', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ParcelaContaPagars);

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
