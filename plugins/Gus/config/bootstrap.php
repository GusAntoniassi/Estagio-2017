<?php

use Cake\Core\Configure;
use Cake\Routing\Router;


Configure::write('paginas', [
    'Cadastros' => [
        ['nome' => 'Produtos', 'controller' => 'produtos'],
        ['nome' => 'Lotes', 'controller' => 'lotes'],
        ['nome' => 'Tipos de produto', 'controller' => 'tipo_produtos'],
        ['nome' => 'Fornecedores', 'controller' => 'fornecedores'],
        ['nome' => 'Funcionários', 'controller' => 'funcionarios'],
        ['nome' => 'Formas de pagamento', 'controller' => 'forma_pagamentos'],
        ['nome' => 'Usuários', 'controller' => 'usuarios'],
        ['nome' => 'Grupos de usuário', 'controller' => 'grupo_usuarios'],
        ['nome' => 'Estados', 'controller' => 'estados'],
        ['nome' => 'Cidades', 'controller' => 'cidades'],
    ],
    'Movimentações' => [
        ['nome' => 'Compras', 'controller' => 'compras'],
        ['nome' => 'Pedidos de compra', 'controller' => 'pedido_compras'],
        ['nome' => 'Orçamentos', 'controller' => 'orcamentos'],
        ['nome' => 'Caixas', 'controller' => 'caixas'],
        ['nome' => 'Contas a pagar', 'controller' => 'conta_pagars'],
    ],
    'Relatórios' => [
        ['nome' => 'Histórico de caixa', 'controller' => ''],
        ['nome' => 'Entradas e saídas', 'controller' => ''],
        ['nome' => 'Contas a pagar', 'controller' => ''],
        ['nome' => 'Produtos vendidos', 'controller' => ''],
        ['nome' => 'Horas trabalhadas', 'controller' => ''],
        ['nome' => 'Produtos por lote/vencimento', 'controller' => ''],
        ['nome' => 'Vendas por produto', 'controller' => ''],
        ['nome' => 'Lucro por produto', 'controller' => ''],
        ['nome' => 'Atendimentos por funcionário', 'controller' => ''],
    ],
]);