<tr class="lote" data-linha-id="<?= $linhaTabelaLote; ?>" data-produto-id="<?= $produtoId; ?>">
    <td colspan="4">
        <div class="input-field input-small col s3">
        <?php if ($lote->id) { ?>
        <input type="hidden" name="compras[itemcompras][<?= $linhaTabela ?>][lotes][<?= $linhaTabelaLote ?>][id]" />
        <?php } ?>
        <input type="text" id="cod_lote" name="compras[itemcompras][<?= $linhaTabela ?>][lotes][<?= $linhaTabelaLote ?>][num_lote]" value="<?= $lote->num_lote ?>" />
        <label for="cod_lote">Código do lote</label>
    </div>
    <div class="input-field input-small col s3">
        <input type="text" id="data_lote" name="compras[itemcompras][<?= $linhaTabela ?>][lotes][<?= $linhaTabelaLote ?>][data_vencimento]" value="<?= $lote->data_vencimento ?>" data-type="date" />
        <label for="data_lote">Data do vencimento</label>
    </div>
    <div class="input-field input-small col s2">
        <input type="number" min="1" id="qtde_lote" class="quantidade-lote" name="compras[itemcompras][<?= $linhaTabela ?>][lotes][<?= $linhaTabelaLote ?>][quantidade]" value="<?= $lote->qtde_estoque ?>" />
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