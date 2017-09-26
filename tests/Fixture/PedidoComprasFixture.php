<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PedidoComprasFixture
 *
 */
class PedidoComprasFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'pedido_compras';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'data_pedido' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'data_entrega' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'valor_liquido' => ['type' => 'decimal', 'length' => 10, 'precision' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'descontos' => ['type' => 'decimal', 'length' => 10, 'precision' => 4, 'unsigned' => false, 'null' => false, 'default' => '0.0000', 'comment' => ''],
        'valor_total' => ['type' => 'decimal', 'length' => 10, 'precision' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'comentarios' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'status' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'orcamento_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'forma_pagamento_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'fornecedor_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_pedido_compras_orcamentos1_idx' => ['type' => 'index', 'columns' => ['orcamento_id'], 'length' => []],
            'fk_pedido_compras_forma_pagamentos1_idx' => ['type' => 'index', 'columns' => ['forma_pagamento_id'], 'length' => []],
            'fk_pedido_compras_fornecedores1_idx' => ['type' => 'index', 'columns' => ['fornecedor_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_pedido_compras_forma_pagamentos1' => ['type' => 'foreign', 'columns' => ['forma_pagamento_id'], 'references' => ['forma_pagamentos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_pedido_compras_fornecedores1' => ['type' => 'foreign', 'columns' => ['fornecedor_id'], 'references' => ['fornecedores', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_pedido_compras_orcamentos1' => ['type' => 'foreign', 'columns' => ['orcamento_id'], 'references' => ['orcamentos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'data_pedido' => '2017-09-25',
            'data_entrega' => '2017-09-25',
            'valor_liquido' => 1.5,
            'descontos' => 1.5,
            'valor_total' => 1.5,
            'comentarios' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'status' => 1,
            'orcamento_id' => 1,
            'forma_pagamento_id' => 1,
            'fornecedor_id' => 1
        ],
    ];
}
