<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContaPagarsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContaPagarsTable Test Case
 */
class ContaPagarsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ContaPagarsTable
     */
    public $ContaPagars;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        'app.lote_compras',
        'app.parcela_conta_pagars'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ContaPagars') ? [] : ['className' => ContaPagarsTable::class];
        $this->ContaPagars = TableRegistry::get('ContaPagars', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ContaPagars);

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
