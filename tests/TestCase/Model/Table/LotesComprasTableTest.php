<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LotesComprasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LotesComprasTable Test Case
 */
class LotesComprasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LotesComprasTable
     */
    public $LotesCompras;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.lotes_compras',
        'app.item_compras',
        'app.lotes',
        'app.produtos',
        'app.tipo_produtos',
        'app.item_comandas',
        'app.item_orcamentos',
        'app.item_pedido_compras',
        'app.baixa_produtos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('LotesCompras') ? [] : ['className' => LotesComprasTable::class];
        $this->LotesCompras = TableRegistry::get('LotesCompras', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LotesCompras);

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
