<tr class="lote" data-linha-id="<?= $linhaTabelaLote; ?>" data-produto-id="<?= $produtoId; ?>">
    <td colspan="4">
        <div class="input-field input-small col s3">
        <?php if ($lote->id) { ?>
        <input type="hidden" name="item_compras[<?= $linhaTabela ?>][lote_compras][<?= $linhaTabelaLote ?>][lote][id]" />
        <?php } ?>
        <input type="hidden" name="item_compras[<?= $linhaTabela ?>][lote_compras][<?= $linhaTabelaLote ?>][lote][status]" value="1" />
        <!-- Quantidade em estoque vai ser usada apenas para novos lotes, o valor real vai ser definido no fechamento da compra -->
        <input type="hidden" name="item_compras[<?= $linhaTabela ?>][lote_compras][<?= $linhaTabelaLote ?>][lote][qtde_estoque]" value="0" />
        <input type="hidden" name="item_compras[<?= $linhaTabela ?>][lote_compras][<?= $linhaTabelaLote ?>][lote][produto_id]" value="<?= $produtoId; ?>" />
        <input type="text" id="cod_lote" name="item_compras[<?= $linhaTabela ?>][lote_compras][<?= $linhaTabelaLote ?>][lote][num_lote]" value="<?= $lote->num_lote ?>" />
        <label for="cod_lote">Código do lote</label>
    </div>
    <div class="input-field input-small col s3">
        <input type="text" id="data_lote" name="item_compras[<?= $linhaTabela ?>][lote_compras][<?= $linhaTabelaLote ?>][lote][data_vencimento]" value="<?= $lote->data_vencimento ?>" data-type="date" />
        <label for="data_lote">Data do vencimento</label>
    </div>
    <div class="input-field input-small col s2">
        <input type="number" min="1" id="qtde_lote" class="quantidade-lote" name="item_compras[<?= $linhaTabela ?>][lote_compras][<?= $linhaTabelaLote ?>][quantidade]" value="<?= $lote->qtde_estoque ?>" />
        <label for="qtde_lote">Quantidade</label>
    </div>
    </td>
    <td class="right-align wrapper-adicionar">
        <a class="adicionar-lote"><i class="material-icons">add</i></a>
    </td>
    <td class="center-align wrapper-remover" style="width: 1px">
        <a class="remover-lote"><i class="material-icons">close</i></a>
   </td>
</tr>