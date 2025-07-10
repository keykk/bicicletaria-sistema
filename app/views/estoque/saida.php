<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-box-arrow-right"></i>
                Saída de Estoque
            </h1>
            <div>
                <a href="<?=BASE_URL?>/estoque" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Voltar ao Estoque
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Informações da Saída -->
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-info-circle"></i>
                    Dados da Saída
                </h6>
            </div>
            <div class="card-body">
                <form id="form-saida-info">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tipo-saida" class="form-label">Tipo de Saída *</label>
                            <select class="form-select" id="tipo-saida" name="tipo_saida" required>
                                <option value="">Selecione...</option>
                                <option value="venda">Venda</option>
                                <option value="transferencia">Transferência</option>
                                <option value="devolucao">Devolução ao Fornecedor</option>
                                <option value="perda">Perda/Avaria</option>
                                <option value="uso_interno">Uso Interno</option>
                                <option value="outros">Outros</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="documento-saida" class="form-label">Documento/Referência</label>
                            <input type="text" class="form-control" id="documento-saida" name="documento" 
                                   placeholder="Ex: Nota Fiscal, Pedido, etc.">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="destinatario" class="form-label">Destinatário</label>
                            <input type="text" class="form-control" id="destinatario" name="destinatario" 
                                   placeholder="Nome do cliente, fornecedor, etc.">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="data-saida" class="form-label">Data da Saída *</label>
                            <input type="datetime-local" class="form-control" id="data-saida" name="data_saida" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="observacoes-saida" class="form-label">Observações</label>
                        <textarea class="form-control" id="observacoes-saida" name="observacoes" 
                                  rows="2" placeholder="Informações adicionais sobre a saída..."></textarea>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Resumo da Saída -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-calculator"></i>
                    Resumo da Saída
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Total de Itens:</span>
                    <span class="fw-bold" id="total-itens">0</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Valor Total:</span>
                    <span class="fw-bold text-primary" id="valor-total">R$ 0,00</span>
                </div>
                <hr>
                <div class="d-grid">
                    <button class="btn btn-success" id="btn-finalizar-saida" onclick="finalizarSaida()" disabled>
                        <i class="bi bi-check-circle"></i>
                        Finalizar Saída
                    </button>
                </div>
                
                <div class="alert alert-warning mt-3">
                    <h6 class="alert-heading">
                        <i class="bi bi-exclamation-triangle"></i>
                        Atenção
                    </h6>
                    <ul class="mb-0 small">
                        <li>Verifique todos os dados antes de finalizar</li>
                        <li>A saída será registrada permanentemente</li>
                        <li>O estoque será atualizado automaticamente</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Busca e Adição de Produtos -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-search"></i>
                    Adicionar Produtos à Saída
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control" id="busca-produto" 
                                   placeholder="Digite o código ou nome do produto..." autocomplete="off">
                        </div>
                        <div id="resultados-busca" class="list-group mt-2" style="display: none;"></div>
                    </div>
                    <div class="col-md-4">
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
    </div>
</div>

<!-- Lista de Produtos da Saída -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0">
                    <i class="bi bi-list-ul"></i>
                    Produtos da Saída
                </h6>
                <button class="btn btn-outline-danger btn-sm" onclick="limparLista()">
                    <i class="bi bi-trash"></i>
                    Limpar Lista
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="tabela-produtos">
                        <thead class="table-light">
                            <tr>
                                <th>Produto</th>
                                <th width="120">Estoque Atual</th>
                                <th width="120">Quantidade</th>
                                <th width="120">Preço Unit.</th>
                                <th width="120">Subtotal</th>
                                <th width="80">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="lista-produtos">
                            <tr id="lista-vazia">
                                <td colspan="6" class="text-center py-4">
                                    <i class="bi bi-inbox display-6 text-muted"></i>
                                    <br>
                                    <span class="text-muted">Nenhum produto adicionado</span>
                                    <br>
                                    <small class="text-muted">Use a busca acima para adicionar produtos</small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação -->
<div class="modal fade" id="modalConfirmacao" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle"></i>
                    Confirmar Saída de Estoque
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Você está prestes a registrar uma saída de estoque com os seguintes dados:</strong></p>
                
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Tipo:</strong> <span id="conf-tipo"></span></p>
                        <p><strong>Destinatário:</strong> <span id="conf-destinatario"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Data:</strong> <span id="conf-data"></span></p>
                        <p><strong>Documento:</strong> <span id="conf-documento"></span></p>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody id="conf-produtos">
                        </tbody>
                    </table>
                </div>
                
                <div class="alert alert-warning">
                    <strong>Total de Itens:</strong> <span id="conf-total-itens"></span><br>
                    <strong>Valor Total:</strong> <span id="conf-valor-total"></span>
                </div>
                
                <p class="text-danger">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>Esta ação não pode ser desfeita!</strong> O estoque será atualizado permanentemente.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x"></i>
                    Cancelar
                </button>
                <button type="button" class="btn btn-warning" onclick="confirmarSaida()">
                    <i class="bi bi-check"></i>
                    Confirmar Saída
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let produtosSaida = [];

// Inicializar data atual
document.addEventListener('DOMContentLoaded', function() {
    const agora = new Date();
    agora.setMinutes(agora.getMinutes() - agora.getTimezoneOffset());
    document.getElementById('data-saida').value = agora.toISOString().slice(0, 16);
    
    document.getElementById('busca-produto').focus();
});

// Busca de produtos
document.getElementById('busca-produto').addEventListener('input', function() {
    const termo = this.value.trim();
    
    if (termo.length < 1) {
        document.getElementById('resultados-busca').style.display = 'none';
        return;
    }
    
    fetch(`<?=BASE_URL?>/produto/api2/1?termo=${encodeURIComponent(termo)}`)
        .then(response => response.json())
        .then(data => {
            mostrarResultadosBusca(data.produtos || []);
        })
        .catch(error => {
            console.error('Erro na busca:', error);
        });
});

// Mostrar resultados da busca
function mostrarResultadosBusca(produtos) {
    const container = document.getElementById('resultados-busca');
    
    if (produtos.length === 0) {
        container.style.display = 'none';
        return;
    }
    
    let html = '';
    produtos.forEach(produto => {
        const estoque = produto.estoque_atual || 0;
        const disponivel = estoque > 0;
        
        html += `
            <div class="list-group-item list-group-item-action ${!disponivel ? 'disabled' : ''}" 
                 onclick="${disponivel ? `adicionarProduto(${produto.id}, '${produto.text}', '${produto.id}', ${produto.preco || 0}, ${estoque}, '${produto.unidade || 'UN'}')` : ''}">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>${produto.text}</strong>
                        <br>
                        <small class="text-muted">Código: ${produto.id}</small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-primary">R$ ${parseFloat(produto.preco).toFixed(2)}</span>
                        <br>
                        <small class="${disponivel ? 'text-success' : 'text-danger'}">
                            Estoque: ${estoque} ${produto.unidade || 'UN'}
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
    
    if (!codigo) {
        alert('Digite um código de barras');
        return;
    }
    
    fetch(`/produtos/buscar-codigo?codigo=${encodeURIComponent(codigo)}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.produto) {
                const produto = data.produto;
                if (produto.estoque_atual > 0) {
                    adicionarProduto(produto.id, produto.nome, produto.codigo, produto.preco, produto.estoque_atual, produto.unidade || 'UN');
                    document.getElementById('codigo-barras').value = '';
                } else {
                    alert('Produto sem estoque disponível');
                }
            } else {
                alert(data.message || 'Produto não encontrado');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao buscar produto');
        });
}

// Adicionar produto à saída
function adicionarProduto(id, nome, codigo, preco, estoqueAtual, unidade) {
    // Verificar se o produto já está na lista
    const produtoExistente = produtosSaida.find(item => item.produto_id === id);
    
    if (produtoExistente) {
        produtoExistente.quantidade += 1;
        produtoExistente.subtotal = produtoExistente.quantidade * produtoExistente.preco_unitario;
    } else {
        produtosSaida.push({
            produto_id: id,
            nome: nome,
            codigo: codigo,
            quantidade: 1,
            preco_unitario: parseFloat(preco),
            subtotal: parseFloat(preco),
            estoque_atual: estoqueAtual,
            unidade: unidade
        });
    }
    
    atualizarListaProdutos();
    document.getElementById('busca-produto').value = '';
    document.getElementById('resultados-busca').style.display = 'none';
}

// Atualizar lista de produtos
function atualizarListaProdutos() {
    const tbody = document.getElementById('lista-produtos');
    const listaVazia = document.getElementById('lista-vazia');
    
    if (produtosSaida.length === 0) {
        listaVazia.style.display = 'table-row';
        tbody.innerHTML = `
            <tr id="lista-vazia">
                <td colspan="6" class="text-center py-4">
                    <i class="bi bi-inbox display-6 text-muted"></i>
                    <br>
                    <span class="text-muted">Nenhum produto adicionado</span>
                    <br>
                    <small class="text-muted">Use a busca acima para adicionar produtos</small>
                </td>
            </tr>
        `;
    } else {
        let html = '';
        produtosSaida.forEach((item, index) => {
            html += `
                <tr>
                    <td>
                        <strong>${item.nome}</strong>
                        <br>
                        <small class="text-muted">Cód: ${item.codigo}</small>
                    </td>
                    <td>
                        <span class="badge bg-info">${item.estoque_atual} ${item.unidade}</span>
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm" 
                               value="${item.quantidade}" min="0.001" step="0.001" max="${item.estoque_atual}"
                               onchange="alterarQuantidade(${index}, this.value)">
                    </td>
                    <td>R$ ${item.preco_unitario.toFixed(2)}</td>
                    <td>R$ ${item.subtotal.toFixed(2)}</td>
                    <td>
                        <button class="btn btn-outline-danger btn-sm" 
                                onclick="removerProduto(${index})">
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

// Alterar quantidade
function alterarQuantidade(index, novaQuantidade) {
    const quantidade = parseFloat(novaQuantidade);
    
    if (quantidade <= 0) {
        removerProduto(index);
        return;
    }
    
    const produto = produtosSaida[index];
    
    if (quantidade > produto.estoque_atual) {
        alert(`Quantidade não pode ser maior que o estoque disponível (${produto.estoque_atual} ${produto.unidade})`);
        atualizarListaProdutos();
        return;
    }
    
    produto.quantidade = quantidade;
    produto.subtotal = quantidade * produto.preco_unitario;
    
    atualizarListaProdutos();
}

// Remover produto
function removerProduto(index) {
    produtosSaida.splice(index, 1);
    atualizarListaProdutos();
}

// Limpar lista
function limparLista() {
    if (produtosSaida.length > 0 && confirm('Deseja remover todos os produtos da lista?')) {
        produtosSaida = [];
        atualizarListaProdutos();
    }
}

// Calcular totais
function calcularTotais() {
    const totalItens = produtosSaida.reduce((total, item) => total + item.quantidade, 0);
    const valorTotal = produtosSaida.reduce((total, item) => total + item.subtotal, 0);
    
    document.getElementById('total-itens').textContent = totalItens.toFixed(3);
    document.getElementById('valor-total').textContent = `R$ ${valorTotal.toFixed(2)}`;
    
    // Habilitar/desabilitar botão de finalizar
    const btnFinalizar = document.getElementById('btn-finalizar-saida');
    const tipoSaida = document.getElementById('tipo-saida').value;
    const dataSaida = document.getElementById('data-saida').value;
    
    btnFinalizar.disabled = produtosSaida.length === 0 || !tipoSaida || !dataSaida;
}

// Finalizar saída
function finalizarSaida() {
    // Validações
    const tipoSaida = document.getElementById('tipo-saida').value;
    const dataSaida = document.getElementById('data-saida').value;
    
    if (!tipoSaida || !dataSaida) {
        alert('Preencha todos os campos obrigatórios');
        return;
    }
    
    if (produtosSaida.length === 0) {
        alert('Adicione pelo menos um produto à saída');
        return;
    }
    
    // Preencher modal de confirmação
    const tiposTexto = {
        'venda': 'Venda',
        'transferencia': 'Transferência',
        'devolucao': 'Devolução ao Fornecedor',
        'perda': 'Perda/Avaria',
        'uso_interno': 'Uso Interno',
        'outros': 'Outros'
    };
    
    document.getElementById('conf-tipo').textContent = tiposTexto[tipoSaida];
    document.getElementById('conf-destinatario').textContent = document.getElementById('destinatario').value || 'Não informado';
    document.getElementById('conf-data').textContent = new Date(dataSaida).toLocaleString('pt-BR');
    document.getElementById('conf-documento').textContent = document.getElementById('documento-saida').value || 'Não informado';
    
    // Preencher produtos
    let htmlProdutos = '';
    produtosSaida.forEach(item => {
        htmlProdutos += `
            <tr>
                <td>${item.nome}</td>
                <td>${item.quantidade} ${item.unidade}</td>
                <td>R$ ${item.subtotal.toFixed(2)}</td>
            </tr>
        `;
    });
    document.getElementById('conf-produtos').innerHTML = htmlProdutos;
    
    const totalItens = produtosSaida.reduce((total, item) => total + item.quantidade, 0);
    const valorTotal = produtosSaida.reduce((total, item) => total + item.subtotal, 0);
    
    document.getElementById('conf-total-itens').textContent = totalItens.toFixed(3);
    document.getElementById('conf-valor-total').textContent = `R$ ${valorTotal.toFixed(2)}`;
    
    // Mostrar modal
    const modal = new bootstrap.Modal(document.getElementById('modalConfirmacao'));
    modal.show();
}

// Confirmar saída
function confirmarSaida() {
    const formData = new FormData(document.getElementById('form-saida-info'));
    const dados = Object.fromEntries(formData);
    dados.produtos = produtosSaida;
    
    const btnConfirmar = document.querySelector('#modalConfirmacao .btn-warning');
    btnConfirmar.disabled = true;
    btnConfirmar.innerHTML = '<i class="bi bi-hourglass-split"></i> Processando...';
    
    fetch('/estoque/saida', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(dados)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Saída de estoque registrada com sucesso!');
            
            // Limpar formulário
            produtosSaida = [];
            document.getElementById('form-saida-info').reset();
            
            // Reinicializar data
            const agora = new Date();
            agora.setMinutes(agora.getMinutes() - agora.getTimezoneOffset());
            document.getElementById('data-saida').value = agora.toISOString().slice(0, 16);
            
            atualizarListaProdutos();
            
            // Fechar modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalConfirmacao'));
            modal.hide();
            
            // Focar na busca
            document.getElementById('busca-produto').focus();
        } else {
            alert('Erro: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao processar saída');
    })
    .finally(() => {
        btnConfirmar.disabled = false;
        btnConfirmar.innerHTML = '<i class="bi bi-check"></i> Confirmar Saída';
    });
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
    
    // F9 - Finalizar saída
    if (e.key === 'F9') {
        e.preventDefault();
        if (!document.getElementById('btn-finalizar-saida').disabled) {
            finalizarSaida();
        }
    }
    
    // ESC - Limpar busca
    if (e.key === 'Escape') {
        const busca = document.getElementById('busca-produto');
        if (busca.value) {
            busca.value = '';
            document.getElementById('resultados-busca').style.display = 'none';
        }
    }
});

// Atualizar totais quando campos obrigatórios mudarem
document.getElementById('tipo-saida').addEventListener('change', calcularTotais);
document.getElementById('data-saida').addEventListener('change', calcularTotais);
</script>

<style>
#resultados-busca {
    position: absolute;
    z-index: 1000;
    max-height: 300px;
    overflow-y: auto;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.list-group-item:hover {
    background-color: #f8f9fa;
}

.table-responsive {
    max-height: 500px;
    overflow-y: auto;
}

.alert {
    border-left: 4px solid;
}

.alert-warning {
    border-left-color: #ffc107;
}

.form-control-sm {
    font-size: 0.875rem;
}

@media (max-width: 768px) {
    #resultados-busca {
        position: relative;
        box-shadow: none;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
    }
    
    .col-md-8, .col-md-6, .col-md-4 {
        margin-bottom: 1rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
}
</style>

