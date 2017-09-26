<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ContaPagarsFixture
 *
 */
class ContaPagarsFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'conta_pagars';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'descricao' => ['type' => 'string', 'length' => 80, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'valor' => ['type' => 'decimal', 'length' => 10, 'precision' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'data_cadastro' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'data_pagamento' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'pago' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'num_parcelas' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'comentarios' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'fornecedor_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'compra_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'forma_pagamento_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_contas_a_pagars_fornecedores1_idx' => ['type' => 'index', 'columns' => ['fornecedor_id'], 'length' => []],
            'fk_contas_a_pagars_compras1_idx' => ['type' => 'index', 'columns' => ['compra_id'], 'length' => []],
            'fk_conta_pagars_forma_pagamentos1_idx' => ['type' => 'index', 'columns' => ['forma_pagamento_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_conta_pagars_forma_pagamentos1' => ['type' => 'foreign', 'columns' => ['forma_pagamento_id'], 'references' => ['forma_pagamentos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_contas_a_pagars_compras1' => ['type' => 'foreign', 'columns' => ['compra_id'], 'references' => ['compras', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_contas_a_pagars_fornecedores1' => ['type' => 'foreign', 'columns' => ['fornecedor_id'], 'references' => ['fornecedores', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'descricao' => 'Lorem ipsum dolor sit amet',
            'valor' => 1.5,
            'data_cadastro' => '2017-09-25 22:51:33',
            'data_pagamento' => '2017-09-25 22:51:33',
            'pago' => 1,
            'num_parcelas' => 1,
            'comentarios' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'fornecedor_id' => 1,
            'compra_id' => 1,
            'forma_pagamento_id' => 1
        ],
    ];
}
