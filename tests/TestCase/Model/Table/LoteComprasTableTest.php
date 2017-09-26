<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LoteComprasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LoteComprasTable Test Case
 */
class LoteComprasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LoteComprasTable
     */
    public $LoteCompras;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.lote_compras',
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
        $config = TableRegistry::exists('LoteCompras') ? [] : ['className' => LoteComprasTable::class];
        $this->LoteCompras = TableRegistry::get('LoteCompras', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LoteCompras);

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
