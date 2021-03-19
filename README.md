## Projeto Owlsoftware

**_Implementações já realizadas_**

- [x] Módulo de cadastros (Cidade, clientes, condição de pagamento, conta bancária, estado/UF, forma de pagamento, grupo de produto, marca, origem de movimentação de estoque, país, portador, produto, tamanho, tipo de movimento de estoque, tipo de produto e tipo de venda);
- [x] Movimentação de estoque via Ajuste (Entrada e saída)
- [x] Acompanhamento das movimentações de estoque (Kardex);
- [x] Gerenciamento financeiro (contas a receber e a pagar);
- [x] Acompanhamento de saldo de conta;

**_Implentações a serem realizadas_**

- [ ] Controle de vendas (emissão de pedido, documento condicional, venda);
- [ ] Conferência bancária;
- [ ] Entrada de nota fiscal (XML);
- [ ] Agendamento de serviços;

> Obs: Todas informações poderão sofrer alteração durante o processo de desenvolvimento, sendo consideradas ideias que podem ser aprimoradas.


> Para utilização do projeto, criar uma base de dados chamada "owlsoftware" e rodar o script presente dentro da pasta "BD" na raiz do projeto. 

**_Atualizações pós liberação (estável 1.0)_**

- [ ] Adicionar passo a passo e vídeo explicando processos (acesso dentro do sistema);
- [ ] Adicionar chat com acesso via sistema (suporte);
- [ ] Adicionar relatório mãe;
- [ ] Correção quanto a apresentação de informações tipo Date;
- [ ] Correção das casas decimais (Select, insert, update e visualização em tela);
- [ ] Implementação do modal de consulta na tela de Kardex;
- [ ] Impressão do ajuste de estoque;
- [ ] Emissão de relatório para controle de estoque (Entrada e saída de mercadoria);
- [ ] Emissão de arquivo remessa CNAB;
- [ ] Leitura de arquivo de retorno CNAB;
- [ ] Emissão de boleto PDF

**_A fazer com a OR_**

- [x] Adicionar status 
- [x] Adicionar possibilidade de liquidação 
- [x] Adicionar liquidação parcial
- [x] Atualizar status da parcela quando liquidadar
- [x] Atualizar status da OR quando liquidadar parcelas
- [x] Adicionar exclusão da liquidação
- [x] Bloquear campo de valor no cadastro da OR quando liquidado parcial
- [x] Adicionar cancelamento 
- [x] Fazer tela de consulta 

**_Alterações necessárias no sistemas para ser capacitado_**

- [x] Criação do cadastro de status (Abortamos, feito direto no banco)
- [x] Adição do campo “saldo” na conta bancária (Estou repensando este funcionamento) -- Descartado
- [x] Adição do campos “saldo” na OR e Parcela
