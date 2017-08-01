<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TipoProdutosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TipoProdutosTable Test Case
 */
class TipoProdutosTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TipoProdutosTable
     */
    public $TipoProdutos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.tipo_produtos',
        'app.produtos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('TipoProdutos') ? [] : ['className' => TipoProdutosTable::class];
        $this->TipoProdutos = TableRegistry::get('TipoProdutos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TipoProdutos);

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
}
