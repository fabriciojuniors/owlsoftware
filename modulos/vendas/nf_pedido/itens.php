<div class="table-responsive" style="margin-top: 1%; margin-left: 1%; margin-right: 1%; max-height:300px; overflow-y: auto">
    <table  class="table table-hover table-sm">
        <thead>
            <th style="width: 35%">Produto</th>
            <th>Qtd. Pedido</th>
            <th>Qtd. Saldo</th>
            <th>Est. Disp.</th>
            <th>Vlr. Unitário</th>
            <th>Desconto Unitário</th>
            <th>Vlr. Total</th>
            <th style="width: 7%">Qtd. Faturar</th>
            <th style="margin: auto"><input type="checkbox" name="marcartodos" onclick="marcarTodos(this.checked)" id="marcartodos"></th>
        </thead>
        <tbody id="tbItens">
        </tbody>
    </table>
</div>
<div class="row" style="float: right; margin: 1%">
    <button class="btn btn-square btn-success" onclick="adicionarItens()" id="adicionarItens">Adicionar</button>
</div>
<div class="table-responsive" style="margin-top: 1%; margin-left: 1%; margin-right: 1%; max-height:300px; overflow-y: auto">
    <table id="itensAddedT" class="table table-hover table-sm">
        <thead>
            <th style="width: 60%">Produto</th>
            <th>Qtd. Faturar</th>
            <th>Vlr. Unitário</th>
            <th>Vlr. Total</th>
            <th style="margin: auto"><a onclick="excluirTodos()"><i style="color: blue;" class="fas fa-trash-alt"></i></a></th>
        </thead>
        <tbody id="itensAdded">
        </tbody>
    </table>
</div>
