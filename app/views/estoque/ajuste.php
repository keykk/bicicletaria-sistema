<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-tools"></i>
                Ajuste de Estoque
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

<!-- Busca de Produto -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-search"></i>
                    Buscar Produto para Ajuste
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
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Formulário de Ajuste -->
<div class="row" id="area-ajuste" style="display: none;">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-gear"></i>
                    Dados do Ajuste
                </h6>
            </div>
            <div class="card-body">
                <form id="form-ajuste">
                    <input type="hidden" id="produto-id" name="produto_id">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="produto-nome" class="form-label">Produto</label>
                            <input type="text" class="form-control" id="produto-nome" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="produto-codigo" class="form-label">Código</label>
                            <input type="text" class="form-control" id="produto-codigo" readonly>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="estoque-atual" class="form-label">Estoque Atual</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="estoque-atual" readonly>
                                <span class="input-group-text" id="unidade-produto">UN</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="tipo-ajuste" class="form-label">Tipo de Ajuste *</label>
                            <select class="form-select" id="tipo-ajuste" name="tipo_ajuste" required onchange="alterarTipoAjuste()">
                                <option value="">Selecione...</option>
                                <option value="entrada">Entrada (+)</option>
                                <option value="saida">Saída (-)</option>
                                <option value="correcao">Correção (Definir Quantidade)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="quantidade-ajuste" class="form-label">Quantidade *</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="quantidade-ajuste" 
                                       name="quantidade" step="0.001" min="0" required onchange="calcularNovoEstoque()">
                                <span class="input-group-text" id="unidade-ajuste">UN</span>
                            </div>
                            <div class="form-text" id="help-quantidade"></div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="motivo-ajuste" class="form-label">Motivo do Ajuste *</label>
                            <select class="form-select" id="motivo-ajuste" name="motivo" required>
                                <option value="">Selecione...</option>
                                <option value="inventario">Inventário/Contagem</option>
                                <option value="avaria">Produto Avariado</option>
                                <option value="vencimento">Produto Vencido</option>
                                <option value="perda">Perda/Roubo</option>
                                <option value="devolucao">Devolução de Cliente</option>
                                <option value="transferencia">Transferência</option>
                                <option value="erro_sistema">Correção de Erro do Sistema</option>
                                <option value="outros">Outros</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="novo-estoque" class="form-label">Novo Estoque</label>
                            <div class="input-group">
                                <input type="number" class="form-control bg-light" id="novo-estoque" readonly>
                                <span class="input-group-text" id="unidade-novo">UN</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="observacoes-ajuste" class="form-label">Observações</label>
                        <textarea class="form-control" id="observacoes-ajuste" name="observacoes" 
                                  rows="3" placeholder="Descreva detalhes sobre o ajuste..."></textarea>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" onclick="limparFormulario()">
                            <i class="bi bi-x"></i>
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i>
                            Confirmar Ajuste
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Resumo do Ajuste -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-info-circle"></i>
                    Resumo do Ajuste
                </h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info" id="resumo-ajuste" style="display: none;">
                    <h6 class="alert-heading">Confirmação</h6>
                    <p class="mb-1"><strong>Produto:</strong> <span id="resumo-produto"></span></p>
                    <p class="mb-1"><strong>Estoque Atual:</strong> <span id="resumo-atual"></span></p>
                    <p class="mb-1"><strong>Tipo:</strong> <span id="resumo-tipo"></span></p>
                    <p class="mb-1"><strong>Quantidade:</strong> <span id="resumo-quantidade"></span></p>
                    <hr>
                    <p class="mb-0"><strong>Novo Estoque:</strong> <span id="resumo-novo" class="fw-bold"></span></p>
                </div>
                
                <div class="alert alert-warning">
                    <h6 class="alert-heading">
                        <i class="bi bi-exclamation-triangle"></i>
                        Atenção
                    </h6>
                    <ul class="mb-0">
                        <li>Ajustes de estoque são permanentes</li>
                        <li>Registre sempre o motivo correto</li>
                        <li>Verifique os dados antes de confirmar</li>
                        <li>O histórico ficará registrado no sistema</li>
                    </ul>
                </div>
                
                <!-- Histórico Recente -->
                <div class="mt-3" id="historico-produto" style="display: none;">
                    <h6>Últimos Ajustes</h6>
                    <div id="lista-historico" class="small">
                        <!-- Será preenchido via JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Histórico de Ajustes -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0">
                    <i class="bi bi-clock-history"></i>
                    Histórico de Ajustes Recentes
                </h6>
                <button class="btn btn-outline-info btn-sm" onclick="atualizarHistorico()">
                    <i class="bi bi-arrow-clockwise"></i>
                    Atualizar
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="tabela-historico">
                        <thead class="table-light">
                            <tr>
                                <th>Data/Hora</th>
                                <th>Produto</th>
                                <th>Tipo</th>
                                <th>Quantidade</th>
                                <th>Estoque Anterior</th>
                                <th>Estoque Atual</th>
                                <th>Motivo</th>
                                <th>Usuário</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-historico">
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="bi bi-hourglass-split"></i>
                                    Carregando histórico...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let produtoSelecionado = null;

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
        html += `
            <div class="list-group-item list-group-item-action" 
                 onclick="selecionarProduto(${produto.id}, '${produto.text}', '${produto.id}', ${produto.estoque_atual || 0}, '${produto.unidade || 'UN'}')">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>${produto.text}</strong>
                        <br>
                        <small class="text-muted">Código: ${produto.id}</small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-info">Estoque: ${produto.estoque_atual || 0} ${produto.unidade || 'UN'}</span>
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
    
    fetch(`<?=BASE_URL?>/produto/api3/${encodeURIComponent(codigo)}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.produto) {
                const produto = data.produto;
                selecionarProduto(produto.id, produto.nome, produto.id, produto.quantidade || 0, produto.unidade_medida || 'UN');
                document.getElementById('codigo-barras').value = '';
            } else {
                alert(data.message || 'Produto não encontrado');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao buscar produto');
        });
}

// Selecionar produto
function selecionarProduto(id, nome, codigo, estoqueAtual, unidade) {
    produtoSelecionado = {
        id: id,
        nome: nome,
        codigo: codigo,
        estoque_atual: estoqueAtual,
        unidade: unidade
    };
    
    // Preencher formulário
    document.getElementById('produto-id').value = id;
    document.getElementById('produto-nome').value = nome;
    document.getElementById('produto-codigo').value = codigo;
    document.getElementById('estoque-atual').value = estoqueAtual;
    
    // Atualizar unidades
    document.getElementById('unidade-produto').textContent = unidade;
    document.getElementById('unidade-ajuste').textContent = unidade;
    document.getElementById('unidade-novo').textContent = unidade;
    
    // Mostrar área de ajuste
    document.getElementById('area-ajuste').style.display = 'block';
    
    // Limpar busca
    document.getElementById('busca-produto').value = '';
    document.getElementById('resultados-busca').style.display = 'none';
    
    // Carregar histórico do produto
    carregarHistoricoProduto(id);
    
    // Focar no tipo de ajuste
    document.getElementById('tipo-ajuste').focus();
}

// Alterar tipo de ajuste
function alterarTipoAjuste() {
    const tipo = document.getElementById('tipo-ajuste').value;
    const helpText = document.getElementById('help-quantidade');
    const quantidadeInput = document.getElementById('quantidade-ajuste');
    
    quantidadeInput.value = '';
    document.getElementById('novo-estoque').value = '';
    
    switch(tipo) {
        case 'entrada':
            helpText.textContent = 'Quantidade a ser adicionada ao estoque';
            quantidadeInput.placeholder = 'Ex: 10';
            break;
        case 'saida':
            helpText.textContent = 'Quantidade a ser removida do estoque';
            quantidadeInput.placeholder = 'Ex: 5';
            break;
        case 'correcao':
            helpText.textContent = 'Quantidade correta que deve ficar no estoque';
            quantidadeInput.placeholder = 'Ex: 25';
            break;
        default:
            helpText.textContent = '';
            quantidadeInput.placeholder = '';
    }
    
    calcularNovoEstoque();
}

// Calcular novo estoque
function calcularNovoEstoque() {
    const tipo = document.getElementById('tipo-ajuste').value;
    const quantidade = parseFloat(document.getElementById('quantidade-ajuste').value) || 0;
    const estoqueAtual = parseFloat(document.getElementById('estoque-atual').value) || 0;
    
    let novoEstoque = estoqueAtual;
    
    switch(tipo) {
        case 'entrada':
            novoEstoque = estoqueAtual + quantidade;
            break;
        case 'saida':
            novoEstoque = estoqueAtual - quantidade;
            break;
        case 'correcao':
            novoEstoque = quantidade;
            break;
    }
    
    document.getElementById('novo-estoque').value = novoEstoque.toFixed(3);
    
    // Atualizar resumo
    atualizarResumo();
}

// Atualizar resumo
function atualizarResumo() {
    const tipo = document.getElementById('tipo-ajuste').value;
    const quantidade = document.getElementById('quantidade-ajuste').value;
    const novoEstoque = document.getElementById('novo-estoque').value;
    
    if (!produtoSelecionado || !tipo || !quantidade) {
        document.getElementById('resumo-ajuste').style.display = 'none';
        return;
    }
    
    const tiposTexto = {
        'entrada': 'Entrada (+)',
        'saida': 'Saída (-)',
        'correcao': 'Correção'
    };
    
    document.getElementById('resumo-produto').textContent = produtoSelecionado.nome;
    document.getElementById('resumo-atual').textContent = `${produtoSelecionado.estoque_atual} ${produtoSelecionado.unidade}`;
    document.getElementById('resumo-tipo').textContent = tiposTexto[tipo];
    document.getElementById('resumo-quantidade').textContent = `${quantidade} ${produtoSelecionado.unidade}`;
    document.getElementById('resumo-novo').textContent = `${novoEstoque} ${produtoSelecionado.unidade}`;
    
    document.getElementById('resumo-ajuste').style.display = 'block';
}

// Carregar histórico do produto
function carregarHistoricoProduto(produtoId) {
    fetch(`/estoque/historico-produto/${produtoId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.historico.length > 0) {
                let html = '';
                data.historico.slice(0, 3).forEach(item => {
                    html += `
                        <div class="border-bottom pb-1 mb-1">
                            <div class="d-flex justify-content-between">
                                <span>${item.tipo}</span>
                                <span>${item.quantidade}</span>
                            </div>
                            <small class="text-muted">${item.data} - ${item.motivo}</small>
                        </div>
                    `;
                });
                document.getElementById('lista-historico').innerHTML = html;
                document.getElementById('historico-produto').style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Erro ao carregar histórico:', error);
        });
}

// Limpar formulário
function limparFormulario() {
    produtoSelecionado = null;
    document.getElementById('form-ajuste').reset();
    document.getElementById('area-ajuste').style.display = 'none';
    document.getElementById('resumo-ajuste').style.display = 'none';
    document.getElementById('historico-produto').style.display = 'none';
    document.getElementById('busca-produto').focus();
}

// Submeter formulário
document.getElementById('form-ajuste').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (!produtoSelecionado) {
        alert('Selecione um produto');
        return;
    }
    
    const formData = new FormData(this);
    const dados = Object.fromEntries(formData);
    
    // Validações
    if (!dados.tipo_ajuste || !dados.quantidade || !dados.motivo) {
        alert('Preencha todos os campos obrigatórios');
        return;
    }
    
    const quantidade = parseFloat(dados.quantidade);
    if (quantidade <= 0) {
        alert('Quantidade deve ser maior que zero');
        return;
    }
    
    if (dados.tipo_ajuste === 'saida' && quantidade > produtoSelecionado.estoque_atual) {
        if (!confirm('A quantidade de saída é maior que o estoque atual. Deseja continuar?')) {
            return;
        }
    }
    
    // Enviar dados
    const btnSubmit = this.querySelector('button[type="submit"]');
    btnSubmit.disabled = true;
    btnSubmit.innerHTML = '<i class="bi bi-hourglass-split"></i> Processando...';
    
    fetch('/estoque/ajustar', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(dados)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Ajuste realizado com sucesso!');
            limparFormulario();
            atualizarHistorico();
        } else {
            alert('Erro: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao processar ajuste');
    })
    .finally(() => {
        btnSubmit.disabled = false;
        btnSubmit.innerHTML = '<i class="bi bi-check-circle"></i> Confirmar Ajuste';
    });
});

// Atualizar histórico
function atualizarHistorico() {
    fetch('/estoque/historico-ajustes')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('tbody-historico');
            
            if (data.success && data.historico.length > 0) {
                let html = '';
                data.historico.forEach(item => {
                    const tipoClass = item.tipo === 'entrada' ? 'text-success' : 
                                     item.tipo === 'saida' ? 'text-danger' : 'text-warning';
                    
                    html += `
                        <tr>
                            <td>${item.data_formatada}</td>
                            <td>
                                <strong>${item.produto_nome}</strong>
                                <br>
                                <small class="text-muted">Cód: ${item.produto_codigo}</small>
                            </td>
                            <td>
                                <span class="badge bg-secondary ${tipoClass}">
                                    ${item.tipo.charAt(0).toUpperCase() + item.tipo.slice(1)}
                                </span>
                            </td>
                            <td>${item.quantidade} ${item.unidade}</td>
                            <td>${item.estoque_anterior} ${item.unidade}</td>
                            <td>${item.estoque_atual} ${item.unidade}</td>
                            <td>${item.motivo}</td>
                            <td>${item.usuario_nome}</td>
                        </tr>
                    `;
                });
                tbody.innerHTML = html;
            } else {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <i class="bi bi-inbox"></i>
                            Nenhum ajuste encontrado
                        </td>
                    </tr>
                `;
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            document.getElementById('tbody-historico').innerHTML = `
                <tr>
                    <td colspan="8" class="text-center py-4 text-danger">
                        <i class="bi bi-exclamation-triangle"></i>
                        Erro ao carregar histórico
                    </td>
                </tr>
            `;
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
    
    // ESC - Limpar formulário
    if (e.key === 'Escape') {
        limparFormulario();
    }
});

// Carregar histórico ao inicializar
document.addEventListener('DOMContentLoaded', function() {
    atualizarHistorico();
    document.getElementById('busca-produto').focus();
});

// Atualizar campos quando quantidade ou tipo mudar
document.getElementById('quantidade-ajuste').addEventListener('input', calcularNovoEstoque);
document.getElementById('tipo-ajuste').addEventListener('change', atualizarResumo);
document.getElementById('motivo-ajuste').addEventListener('change', atualizarResumo);
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

#area-ajuste {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.table-responsive {
    max-height: 400px;
    overflow-y: auto;
}

.alert {
    border-left: 4px solid;
}

.alert-info {
    border-left-color: #0dcaf0;
}

.alert-warning {
    border-left-color: #ffc107;
}

@media (max-width: 768px) {
    #resultados-busca {
        position: relative;
        box-shadow: none;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
    }
    
    .col-md-8, .col-md-4, .col-md-6 {
        margin-bottom: 1rem;
    }
}
</style>

