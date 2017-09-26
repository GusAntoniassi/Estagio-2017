<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ParcelaContaPagarsFixture
 *
 */
class ParcelaContaPagarsFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'parcela_conta_pagars';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'valor' => ['type' => 'decimal', 'length' => 10, 'precision' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'data_vencimento' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'pago' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'Se foi pago ou não', 'precision' => null],
        'conta_pagar_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_parcela_conta_pagars_conta_pagars1_idx' => ['type' => 'index', 'columns' => ['conta_pagar_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_parcela_conta_pagars_conta_pagars1' => ['type' => 'foreign', 'columns' => ['conta_pagar_id'], 'references' => ['conta_pagars', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'valor' => 1.5,
            'data_vencimento' => '2017-09-25',
            'pago' => 1,
            'conta_pagar_id' => 1
        ],
    ];
}
