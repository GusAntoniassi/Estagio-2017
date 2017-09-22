<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ItemComprasFixture
 *
 */
class ItemComprasFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'item_compras';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'produto_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'compra_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'quantidade' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'valor_unitario' => ['type' => 'decimal', 'length' => 10, 'precision' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'fk_compras_produtos_compras1_idx' => ['type' => 'index', 'columns' => ['compra_id'], 'length' => []],
            'fk_compras_produtos_produtos1_idx' => ['type' => 'index', 'columns' => ['produto_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_compras_produtos_compras1' => ['type' => 'foreign', 'columns' => ['compra_id'], 'references' => ['compras', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_compras_produtos_produtos1' => ['type' => 'foreign', 'columns' => ['produto_id'], 'references' => ['produtos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'produto_id' => 1,
            'compra_id' => 1,
            'quantidade' => 1,
            'valor_unitario' => 1.5
        ],
    ];
}
