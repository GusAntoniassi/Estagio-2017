<?php
/**
 * @var \App\View\AppView $this
 */
use Cake\Routing\Router;
?>

<tr class="produto" data-produto-id="<?= $produto->id ?>" data-linha-id="<?= (int)$linhaTabela ?>">
    <td class="foto-produto" style="width: 1px; padding-right: 10px;">
        <input type="hidden" name="item_compras[<?= (int)$linhaTabela ?>][produto_id]" value="<?= $produto->id ?>" />
        <a href="<?= Router::url(['controller' => 'produtos', 'action' => 'view', $produto->id]); ?>">
            <img src="<?= $this->Proffer->getUploadUrl($produto, 'foto', ['thumb' => 'thumb']); ?>" class="circle" />
        </a>
    </td>
    <td class="left-align nome-produto">
        <a href="<?= Router::url(['controller' => 'produtos', 'action' => 'view', $produto->id]); ?>"><?= $produto->nome ?></a>
    </td>
    <td class="center-align quantidade">
        <div class="input-field center-align">
            <input type="number" name="item_compras[<?= (int)$linhaTabela ?>][quantidade]"
               min="1" value="<?= $this->Number->format($quantidade) ?>" class="center-align" style="max-width: 75px">
        </div>
    </td>
    <td class="right-align valor-unitario">
        <div class="input-field right-align">
            <input type="text" name="item_compras[<?= (int)$linhaTabela ?>][valor_unitario]"
               value="<?= $this->Number->precision($custo, 2) ?>" class="right-align" data-type="money" style="max-width: 100px">
        </div>
    </td>
    <td class="right-align valor-total"><?= $this->Number->currency($quantidade * $custo, 'BRL') ?></td>
    <td class="center-align remover" style="width: 1px">
        <a class="remover-item"><i class="material-icons">close</i></a>
    </td>
</tr>