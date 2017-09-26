<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LoteComprasFixture
 *
 */
class LoteComprasFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'lote_compras';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'quantidade' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'Quantidade do lote que foi adquirida naquela compra', 'precision' => null, 'autoIncrement' => null],
        'item_compra_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'lote_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_lote_compras_item_compras1_idx' => ['type' => 'index', 'columns' => ['item_compra_id'], 'length' => []],
            'fk_lote_compras_lotes1_idx' => ['type' => 'index', 'columns' => ['lote_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_lote_compras_item_compras1' => ['type' => 'foreign', 'columns' => ['item_compra_id'], 'references' => ['item_compras', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_lote_compras_lotes1' => ['type' => 'foreign', 'columns' => ['lote_id'], 'references' => ['lotes', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'quantidade' => 1,
            'item_compra_id' => 1,
            'lote_id' => 1
        ],
    ];
}
