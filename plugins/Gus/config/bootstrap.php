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
        ['nome' => 'Países', 'controller' => 'paises'],
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
        ['nome' => 'Histórico de caixa', 'controller' => 'cidades'],
        ['nome' => 'Entradas e saídas', 'controller' => 'cidades'],
        ['nome' => 'Contas a pagar', 'controller' => 'cidades'],
        ['nome' => 'Produtos vendidos', 'controller' => 'cidades'],
        ['nome' => 'Horas trabalhadas', 'controller' => 'cidades'],
        ['nome' => 'Produtos por lote/vencimento', 'controller' => 'cidades'],
        ['nome' => 'Vendas por produto', 'controller' => 'cidades'],
        ['nome' => 'Lucro por produto', 'controller' => 'cidades'],
        ['nome' => 'Atendimentos por funcionário', 'controller' => 'cidades'],
    ],
]);