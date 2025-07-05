<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-cash-register"></i>
                Ponto de Venda (PDV)
            </h1>
            <div>
                <a href="<?= BASE_URL ?>/pdv/dashboard" class="btn btn-outline-info me-2">
                    <i class="bi bi-graph-up"></i>
                    Dashboard
                </a>
                <a href="<?= BASE_URL ?>/pdv/vendas" class="btn btn-outline-primary">
                    <i class="bi bi-list-ul"></i>
                    Ver Vendas
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Área de Busca e Produtos -->
    <div class="col-md-8">
        <!-- Busca de Produtos -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-search"></i>
                    Buscar Produtos
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-list-ul"></i>
                            </span>
                            <select class="form-select" id="tabela-preco" aria-label="Tabela de Preço">
                                <option selected>Selecione uma Tabela</option>
                                <?php foreach ($tabela_preco as $tabela): ?>
                                    <option value="<?= $tabela['id'] ?>" >
                                        <?= htmlspecialchars($tabela['nome']) ?> 
                                    </option>
                                <?php endforeach; ?>
                                <!-- Opções serão preenchidas dinamicamente -->
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control" id="busca-produto" 
                                   placeholder="Digite o código ou nome do produto..." autocomplete="off">
                        </div>
                        <div id="resultados-busca" class="list-group mt-2" style="display: none;"></div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-upc-scan"></i>
                            </span>
                            <input type="text" class="form-control" id="codigo-barras" 
                                   placeholder="Código de barras" autocomplete="off">
                            <button class="btn btn-outline-secondary" type="button" onclick="buscarPorCodigo()">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Carrinho de Compras -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0">
                    <i class="bi bi-cart"></i>
                    Carrinho de Compras
                </h6>
                <button class="btn btn-outline-danger btn-sm" onclick="limparCarrinho()">
                    <i class="bi bi-trash"></i>
                    Limpar
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm" id="tabela-carrinho">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th width="100">Qtd</th>
                                <th width="120">Preço Unit.</th>
                                <th width="120">Subtotal</th>
                                <th width="50">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="itens-carrinho">
                            <tr id="carrinho-vazio">
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="bi bi-cart-x display-6"></i>
                                    <br>
                                    Carrinho vazio
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Área de Totais e Pagamento -->
    <div class="col-md-4">
        <!-- Resumo da Venda -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-calculator"></i>
                    Resumo da Venda
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span>
                    <span class="fw-bold" id="subtotal">R$ 0,00</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Desconto:</span>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">R$</span>
                        <input type="number" class="form-control" id="desconto" 
                               value="0" min="0" step="0.01" onchange="calcularTotais()">
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-3">
                    <span class="h5">Total:</span>
                    <span class="h5 text-primary fw-bold" id="total">R$ 0,00</span>
                </div>
                
                <!-- Forma de Pagamento -->
                <div class="mb-3">
                    <label class="form-label">Forma de Pagamento *</label>
                    <select class="form-select" id="forma-pagamento" onchange="alterarFormaPagamento()">
                        <option value="">Selecione...</option>
                        <option value="dinheiro">Dinheiro</option>
                        <option value="cartao_debito">Cartão de Débito</option>
                        <option value="cartao_credito">Cartão de Crédito</option>
                        <option value="pix">PIX</option>
                    </select>
                </div>
                
                <!-- Área de Dinheiro -->
                <div id="area-dinheiro" style="display: none;">
                    <div class="mb-3">
                        <label class="form-label">Valor Pago</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="number" class="form-control" id="valor-pago" 
                                   step="0.01" min="0" onchange="calcularTroco()">
                        </div>
                    </div>
                    <div class="alert alert-info" id="info-troco" style="display: none;">
                        <strong>Troco: <span id="valor-troco">R$ 0,00</span></strong>
                    </div>
                </div>
                
                <!-- Botão Finalizar -->
                <div class="d-grid">
                    <button class="btn btn-success btn-lg" id="btn-finalizar" 
                            onclick="finalizarVenda()" disabled>
                        <i class="bi bi-check-circle"></i>
                        Finalizar Venda
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Dados do Cliente (Opcional) -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-person"></i>
                    Cliente (Opcional)
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <input type="text" class="form-control form-control-sm" 
                           id="cliente-nome" placeholder="Nome do cliente">
                </div>
                <div class="mb-3">
                    <input type="tel" class="form-control form-control-sm" 
                           id="cliente-telefone" placeholder="Telefone">
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control form-control-sm" 
                           id="cliente-email" placeholder="Email">
                </div>
                <div class="mb-3">
                    <textarea class="form-control form-control-sm" 
                              id="observacoes" rows="2" placeholder="Observações"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Sucesso -->
<div class="modal fade" id="modalSucesso" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bi bi-check-circle"></i>
                    Venda Realizada com Sucesso!
                </h5>
            </div>
            <div class="modal-body text-center">
                <div class="mb-3">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                </div>
                <h4>Venda #<span id="numero-venda"></span></h4>
                <p class="mb-3">Total: <strong id="total-venda"></strong></p>
                <div id="info-troco-modal" style="display: none;">
                    <div class="alert alert-warning">
                        <strong>Troco: <span id="troco-venda"></span></strong>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" onclick="imprimirCupom()">
                    <i class="bi bi-printer"></i>
                    Imprimir Cupom
                </button>
                <button type="button" class="btn btn-success" onclick="novaVenda()">
                    <i class="bi bi-plus"></i>
                    Nova Venda
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Variáveis globais
let carrinho = [];
let vendaAtual = null;

// Busca de produtos
document.getElementById('busca-produto').addEventListener('input', function() {
    const termo = this.value.trim();
    tabela = document.getElementById('tabela-preco');
    idtab = tabela.value.trim();
    
    if (termo.length < 1 || idtab == "" || tabela.selectedIndex === 0) {
        document.getElementById('resultados-busca').style.display = 'none';
        return;
    }
    
    fetch(`<?= BASE_URL ?>/pdv/buscarProdutos?termo=${encodeURIComponent(termo)}&tab=${encodeURIComponent(idtab)}`)
        .then(response => response.json())
        .then(data => {
            mostrarResultadosBusca(data.produtos);
        })
        .catch(error => {
            console.error('Erro na busca:', error);
        });
});

// Mostrar resultados da busca
function mostrarResultadosBusca(produtos) {
    const container = document.getElementById('resultados-busca');
    tabela = document.getElementById('tabela-preco');
    idtab = tabela.value.trim();
    
    if (produtos.length === 0) {
        container.style.display = 'none';
        return;
    }
    
    let html = '';
    produtos.forEach(produto => {
        const estoque = produto.estoque_disponivel || 0;
        const disponivel = estoque > 0;
        
        html += `
            <div class="list-group-item list-group-item-action ${!disponivel ? 'disabled' : ''}" 
                 onclick="${disponivel ? `adicionarProduto(${produto.id}, '${produto.nome}', ${produto.preco_venda}, '${produto.id}', '${idtab}')` : ''}">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>${produto.nome}</strong>
                        <br>
                        <small class="text-muted">Código: ${produto.id}</small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-primary">R$ ${parseFloat(produto.preco_venda).toFixed(2)}</span>
                        <br>
                        <small class="${disponivel ? 'text-success' : 'text-danger'}">
                            Estoque: ${estoque}
                        </small>
                    </div>
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
    container.style.display = 'block';
}

// Buscar por código de barras
function buscarPorCodigo() {
    const codigo = document.getElementById('codigo-barras').value.trim();
    tabela = document.getElementById('tabela-preco');
    idtab = tabela.value.trim();
    if (!codigo) {
        alert('Digite um código de barras');
        return;
    }
    
    fetch(`<?= BASE_URL ?>/pdv/buscarPorCodigo?codigo=${encodeURIComponent(codigo)}&tab=${encodeURIComponent(idtab)}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const produto = data.produto;
                if (produto.estoque_disponivel > 0) {
                    adicionarProduto(produto.id, produto.nome, produto.preco_venda, produto.id, idtab);
                    document.getElementById('codigo-barras').value = '';
                } else {
                    alert('Produto sem estoque disponível '+produto.nome + ' Qtd: '+produto.estoque_disponivel);
                }
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao buscar produto');
        });
}

// Adicionar produto ao carrinho
function adicionarProduto(id, nome, preco, codigo, idtab) {
    // Verificar se o produto já está no carrinho
    const itemExistente = carrinho.find(item => item.id === id);
    
    if (itemExistente) {
        itemExistente.quantidade += 1;
        itemExistente.subtotal = itemExistente.quantidade * itemExistente.preco_unitario;
    } else {
        carrinho.push({
            id: id,
            nome: nome,
            codigo: codigo,
            quantidade: 1,
            preco_unitario: parseFloat(preco),
            subtotal: parseFloat(preco),
            tabela_preco_id: idtab
        });
    }
    
    atualizarCarrinho();
    document.getElementById('busca-produto').value = '';
    document.getElementById('resultados-busca').style.display = 'none';
}

// Atualizar exibição do carrinho
function atualizarCarrinho() {
    const tbody = document.getElementById('itens-carrinho');
    const carrinhoVazio = document.getElementById('carrinho-vazio');
    
    if (carrinho.length === 0) {
        trDentro = tbody.getElementsByTagName('tr')[0]; // Pega a primeira TR
        trDentro.style.display = 'table-row';
        tbody.innerHTML = '<tr id="carrinho-vazio"><td colspan="5" class="text-center text-muted py-4"><i class="bi bi-cart-x display-6"></i><br>Carrinho vazio</td></tr>';
  
    } else {
        let html = '';
        carrinho.forEach((item, index) => {
            html += `
                <tr>
                    <td>
                        <strong>${item.nome}</strong>
                        <br>
                        <small class="text-muted">Cód: ${item.id}</small>
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm" 
                               value="${item.quantidade}" min="1" step="1"
                               onchange="alterarQuantidade(${index}, this.value)">
                    </td>
                    <td>R$ ${item.preco_unitario.toFixed(2)}</td>
                    <td>R$ ${item.subtotal.toFixed(2)}</td>
                    <td>
                        <button class="btn btn-outline-danger btn-sm" 
                                onclick="removerItem(${index})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
        tbody.innerHTML = html;
    }
    
    calcularTotais();
}

// Alterar quantidade do item
function alterarQuantidade(index, novaQuantidade) {
    const quantidade = parseInt(novaQuantidade);
    
    if (quantidade <= 0) {
        removerItem(index);
        return;
    }
    
    carrinho[index].quantidade = quantidade;
    carrinho[index].subtotal = quantidade * carrinho[index].preco_unitario;
    
    atualizarCarrinho();
}

// Remover item do carrinho
function removerItem(index) {
    carrinho.splice(index, 1);
    atualizarCarrinho();
}

// Limpar carrinho
function limparCarrinho() {
    if (carrinho.length > 0 && confirm('Deseja limpar todo o carrinho?')) {
        carrinho = [];
        atualizarCarrinho();
    }
}

// Calcular totais
function calcularTotais() {
    const subtotal = carrinho.reduce((total, item) => total + item.subtotal, 0);
    const desconto = parseFloat(document.getElementById('desconto').value) || 0;
    const total = subtotal - desconto;
    
    document.getElementById('subtotal').textContent = `R$ ${subtotal.toFixed(2)}`;
    document.getElementById('total').textContent = `R$ ${total.toFixed(2)}`;
    
    // Verificar se pode finalizar
    const formaPagamento = document.getElementById('forma-pagamento').value;
    const btnFinalizar = document.getElementById('btn-finalizar');
    
    btnFinalizar.disabled = carrinho.length === 0 || !formaPagamento || total <= 0;
    
    // Calcular troco se for dinheiro
    if (formaPagamento === 'dinheiro') {
        calcularTroco();
    }
}

// Alterar forma de pagamento
function alterarFormaPagamento() {
    const formaPagamento = document.getElementById('forma-pagamento').value;
    const areaDinheiro = document.getElementById('area-dinheiro');
    
    if (formaPagamento === 'dinheiro') {
        areaDinheiro.style.display = 'block';
        document.getElementById('valor-pago').focus();
    } else {
        areaDinheiro.style.display = 'none';
        document.getElementById('info-troco').style.display = 'none';
    }
    
    calcularTotais();
}

// Calcular troco
function calcularTroco() {
    const total = carrinho.reduce((total, item) => total + item.subtotal, 0) - 
                  (parseFloat(document.getElementById('desconto').value) || 0);
    const valorPago = parseFloat(document.getElementById('valor-pago').value) || 0;
    
    const infoTroco = document.getElementById('info-troco');
    const valorTroco = document.getElementById('valor-troco');
    
    if (valorPago >= total && valorPago > 0) {
        const troco = valorPago - total;
        valorTroco.textContent = `R$ ${troco.toFixed(2)}`;
        infoTroco.style.display = 'block';
        infoTroco.className = 'alert alert-success';
    } else if (valorPago > 0) {
        const falta = total - valorPago;
        valorTroco.textContent = `Falta: R$ ${falta.toFixed(2)}`;
        infoTroco.style.display = 'block';
        infoTroco.className = 'alert alert-warning';
    } else {
        infoTroco.style.display = 'none';
    }
}

// Finalizar venda
function finalizarVenda() {
    if (carrinho.length === 0) {
        alert('Adicione produtos ao carrinho');
        return;
    }
    
    const formaPagamento = document.getElementById('forma-pagamento').value;
    if (!formaPagamento) {
        alert('Selecione a forma de pagamento');
        return;
    }
    
    const subtotal = carrinho.reduce((total, item) => total + item.subtotal, 0);
    const desconto = parseFloat(document.getElementById('desconto').value) || 0;
    const total = subtotal - desconto;
    
    let valorPago = null;
    if (formaPagamento === 'dinheiro') {
        valorPago = parseFloat(document.getElementById('valor-pago').value) || 0;
        if (valorPago < total) {
            alert('Valor pago é menor que o total da venda');
            return;
        }
    }
    
    const dadosVenda = {
        itens: carrinho,
        forma_pagamento: formaPagamento,
        valor_pago: valorPago,
        desconto: desconto,
        cliente_nome: document.getElementById('cliente-nome').value,
        cliente_telefone: document.getElementById('cliente-telefone').value,
        cliente_email: document.getElementById('cliente-email').value,
        observacoes: document.getElementById('observacoes').value
    };
    
    // Desabilitar botão
    const btnFinalizar = document.getElementById('btn-finalizar');
    btnFinalizar.disabled = true;
    btnFinalizar.innerHTML = '<i class="bi bi-hourglass-split"></i> Processando...';
    
    fetch('<?= BASE_URL ?>/pdv/processarVenda', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify(dadosVenda)
})
.then(response => {
    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }
    return response.text().then(text => {
        try {
            return JSON.parse(text);
        } catch (err) {
            console.error('Resposta não é JSON válido:', text);
            throw new Error('Resposta do servidor não é JSON válido');
        }
    });
})
.then(data => {
    if (data.success) {
        vendaAtual = data;
        mostrarSucesso(data);
    } else {
        alert('Erro: ' + data.message);
    }
})
.catch(error => {
    console.error('Erro detalhado:', error);
    alert('Erro ao processar venda: ' + error.message);
})
.finally(() => {
    btnFinalizar.disabled = false;
    btnFinalizar.innerHTML = '<i class="bi bi-check-circle"></i> Finalizar Venda';
});
}

// Mostrar modal de sucesso
function mostrarSucesso(data) {
    document.getElementById('numero-venda').textContent = data.venda_id;
    document.getElementById('total-venda').textContent = `R$ ${data.total.toFixed(2)}`;
    
    const infoTrocoModal = document.getElementById('info-troco-modal');
    if (data.troco > 0) {
        document.getElementById('troco-venda').textContent = `R$ ${data.troco.toFixed(2)}`;
        infoTrocoModal.style.display = 'block';
    } else {
        infoTrocoModal.style.display = 'none';
    }
    
    const modal = new bootstrap.Modal(document.getElementById('modalSucesso'));
    modal.show();
}

// Nova venda
function novaVenda() {
    carrinho = [];
    vendaAtual = null;
    
    // Limpar formulário
    document.getElementById('forma-pagamento').value = '';
    document.getElementById('desconto').value = '0';
    document.getElementById('valor-pago').value = '';
    document.getElementById('cliente-nome').value = '';
    document.getElementById('cliente-telefone').value = '';
    document.getElementById('cliente-email').value = '';
    document.getElementById('observacoes').value = '';
    
    // Ocultar área de dinheiro
    document.getElementById('area-dinheiro').style.display = 'none';
    document.getElementById('info-troco').style.display = 'none';
    
    atualizarCarrinho();
    
    // Fechar modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('modalSucesso'));
    modal.hide();
    
    // Focar na busca
    document.getElementById('busca-produto').focus();
}

// Imprimir cupom
function imprimirCupom() {
    if (vendaAtual) {
        window.open(`<?= BASE_URL ?>/pdv/cupom/${vendaAtual.venda_id}`, '_blank');
    }
}

// Eventos de teclado
document.addEventListener('keydown', function(e) {
    // F2 - Focar na busca
    if (e.key === 'F2') {
        e.preventDefault();
        document.getElementById('busca-produto').focus();
    }
    
    // F3 - Focar no código de barras
    if (e.key === 'F3') {
        e.preventDefault();
        document.getElementById('codigo-barras').focus();
    }
    
    // F9 - Finalizar venda
    if (e.key === 'F9') {
        e.preventDefault();
        if (!document.getElementById('btn-finalizar').disabled) {
            finalizarVenda();
        }
    }
    
    // ESC - Limpar busca ou carrinho
    if (e.key === 'Escape') {
        const busca = document.getElementById('busca-produto');
        if (busca.value) {
            busca.value = '';
            document.getElementById('resultados-busca').style.display = 'none';
        } else {
            limparCarrinho();
        }
    }
});

// Focar na busca ao carregar a página
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('busca-produto').focus();
});

// Máscara para telefone
document.getElementById('cliente-telefone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length <= 10) {
        value = value.replace(/^(\d{2})(\d)/, '($1) $2');
        value = value.replace(/(\d{4})(\d)/, '$1-$2');
    } else {
        value = value.replace(/^(\d{2})(\d)/, '($1) $2');
        value = value.replace(/(\d{5})(\d)/, '$1-$2');
    }
    e.target.value = value;
});
</script>

<style>
.list-group-item:hover {
    background-color: #f8f9fa;
}

#resultados-busca {
    position: absolute;
    z-index: 1000;
    max-height: 300px;
    overflow-y: auto;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.table-responsive {
    max-height: 400px;
    overflow-y: auto;
}

#area-dinheiro {
    border: 2px dashed #28a745;
    border-radius: 8px;
    padding: 15px;
    background-color: #f8fff9;
}

.btn-lg {
    font-size: 1.1rem;
    padding: 12px 20px;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.input-group-sm .form-control {
    font-size: 0.875rem;
}

@media (max-width: 768px) {
    .col-md-8, .col-md-4 {
        margin-bottom: 1rem;
    }
    
    #resultados-busca {
        position: relative;
        box-shadow: none;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
    }
}
</style>

