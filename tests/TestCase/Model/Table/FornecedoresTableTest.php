<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FornecedoresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FornecedoresTable Test Case
 */
class FornecedoresTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FornecedoresTable
     */
    public $Fornecedores;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        'app.conta_pagars',
        'app.orcamentos',
        'app.pedido_compras'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Fornecedores') ? [] : ['className' => FornecedoresTable::class];
        $this->Fornecedores = TableRegistry::get('Fornecedores', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Fornecedores);

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

    /**
     * Test searchConfiguration method
     *
     * @return void
     */
    public function testSearchConfiguration()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
