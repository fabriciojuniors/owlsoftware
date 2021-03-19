<div id="itensDevolvido" style="max-height: 350px; overflow-y: auto;">
    <table id="tItensDevolvido" class="table table-hover table-sm">
        <thead>
            <th style="width: 70%;">Produto</th>
            <th>Qtd. Faturada</th>
            <th>Qtd. Devolvida</th>
            <th>#</th>
        </thead>
        <tbody id="cItensDevolvido"></tbody>
    </table>
</div>
<div class="row" style="float: right; margin: 1%">
    <button class="btn btn-square btn-success" onclick="adicionarItens()" id="adicionarItens">Adicionar</button>
</div>

<div class="table-responsive" style="margin-top: 1%; margin-left: 1%; margin-right: 1%; max-height:300px; overflow-y: auto">
    <table id="tItensAdicionados" class="table table-hover table-sm">
        <thead>
            <th style="width: 70%;">Produto</th>
            <th>Qtd. Faturada</th>
            <th>Qtd. Devolvida</th>
            <th>#</th>
        </thead>
        <tbody id="bItensAdicionados"></tbody>
    </table>
</div>

<div class="row" style="float: right; margin: 1%">
    <button class="btn btn-square btn-primary" onclick="finalizarDevolucao()" id="finalizar">Finalizar</button>
</div>