<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-boxes"></i>
                Controle de Estoque
            </h1>
        </div>
    </div>
</div>

<!-- Alertas de estoque baixo -->
<?php if (!empty($estoque_baixo)): ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-warning border-start-warning" role="alert">
            <h6 class="alert-heading">
                <i class="bi bi-exclamation-triangle"></i>
                Atenção: Produtos com Estoque Baixo
            </h6>
            <p class="mb-2">Os seguintes produtos estão com estoque baixo (≤ 5 unidades):</p>
            <div class="row">
                <?php foreach ($estoque_baixo as $item): ?>
                    <div class="col-md-6 col-lg-4 mb-2">
                        <div class="d-flex align-items-center">
                            <span class="badge bg-danger me-2"><?= $item['quantidade'] ?></span>
                            <span class="text-truncate"><?= htmlspecialchars($item['nome']) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <hr>
            <div class="mb-0">
                <a href="<?php echo BASE_URL; ?>/estoque/entrada" class="btn btn-warning btn-sm">
                    <i class="bi bi-plus-circle"></i>
                    Fazer Entrada de Estoque
                </a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Relatório de estoque -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-list"></i>
                        Relatório de Estoque
                    </h6>
                    <div class="input-group" style="width: 300px;">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control search-input" 
                               data-target="#estoque-table" placeholder="Buscar produto...">
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <?php if (empty($relatorio)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                        <h5 class="mt-3">Nenhum produto cadastrado</h5>
                        <p class="text-muted">Cadastre produtos para visualizar o relatório de estoque.</p>
                        <a href="<?php echo BASE_URL; ?>/produto/novo" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i>
                            Cadastrar Produto
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="estoque-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Produto</th>
                                    <th>Categoria</th>
                                    <th>Preço Unitário</th>
                                    <th>Quantidade</th>
                                    <th>Status</th>
                                    <th>Valor Total</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $valorTotalGeral = 0;
                                foreach ($relatorio as $item): 
                                    $valorTotalGeral += $item['valor_total_estoque'];
                                    $quantidade = $item['quantidade'];
                                    
                                    // Definir status e classe
                                    if ($quantidade == 0) {
                                        $status = 'Sem Estoque';
                                        $statusClass = 'bg-danger';
                                        $rowClass = 'table-danger';
                                    } elseif ($quantidade <= 5) {
                                        $status = 'Estoque Baixo';
                                        $statusClass = 'bg-warning';
                                        $rowClass = 'table-warning';
                                    } elseif ($quantidade <= 10) {
                                        $status = 'Estoque Médio';
                                        $statusClass = 'bg-info';
                                        $rowClass = '';
                                    } else {
                                        $status = 'Estoque OK';
                                        $statusClass = 'bg-success';
                                        $rowClass = '';
                                    }
                                ?>
                                    <tr class="<?= $rowClass ?>">
                                        <td>
                                            <span class="badge bg-secondary">#<?= $item['id'] ?></span>
                                        </td>
                                        <td>
                                            <strong><?= htmlspecialchars($item['nome']) ?></strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">
                                                <?= htmlspecialchars($item['categoria']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <strong>R$ <?= number_format($item['preco_venda'], 2, ',', '.') ?></strong>
                                        </td>
                                        <td>
                                            <span class="fs-5 fw-bold"><?= $quantidade ?></span>
                                            <?php if ($quantidade <= 5 && $quantidade > 0): ?>
                                                <i class="bi bi-exclamation-triangle text-warning ms-1" 
                                                   data-bs-toggle="tooltip" title="Estoque baixo"></i>
                                            <?php elseif ($quantidade == 0): ?>
                                                <i class="bi bi-x-circle text-danger ms-1" 
                                                   data-bs-toggle="tooltip" title="Sem estoque"></i>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge <?= $statusClass ?>"><?= $status ?></span>
                                        </td>
                                        <td>
                                            <strong class="text-success">
                                                R$ <?= number_format($item['valor_total_estoque'], 2, ',', '.') ?>
                                            </strong>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#ajuste_estoque" title="Ajustar" data-id="<?=$item['id']?>">
                                                    <i class="bi bi-gear"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="6" class="text-end">Total Geral do Estoque:</th>
                                    <th>
                                        <strong class="text-success fs-5">
                                            R$ <?= number_format($valorTotalGeral, 2, ',', '.') ?>
                                        </strong>
                                    </th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Resumo estatístico -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card text-center border-start-primary">
            <div class="card-body">
                <h5 class="card-title text-primary"><?= count($relatorio) ?></h5>
                <p class="card-text">Total de Produtos</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-start-success">
            <div class="card-body">
                <h5 class="card-title text-success">
                    <?= count(array_filter($relatorio, function($item) { return $item['quantidade'] > 10; })) ?>
                </h5>
                <p class="card-text">Com Estoque OK</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-start-warning">
            <div class="card-body">
                <h5 class="card-title text-warning">
                    <?= count(array_filter($relatorio, function($item) { return $item['quantidade'] > 0 && $item['quantidade'] <= 10; })) ?>
                </h5>
                <p class="card-text">Estoque Baixo/Médio</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-start-danger">
            <div class="card-body">
                <h5 class="card-title text-danger">
                    <?= count(array_filter($relatorio, function($item) { return $item['quantidade'] == 0; })) ?>
                </h5>
                <p class="card-text">Sem Estoque</p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ajuste_estoque" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-gear"></i>
                    <span id="modal_titulo">Ajuste de Estoque</span>
                </h6>
        
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        <form id="form-ajuste">
            <div class="modal-body">
                
                    <div class="row mb-3">
                        
                        <div class="col-md-6">
                            <label for="tipo-ajuste" class="form-label">Tipo de Ajuste *</label>
                            <select class="form-select" id="tipo-ajuste" name="tipo_ajuste" required onchange="alterarTipoAjuste()">
                                <option value="">Selecione...</option>
                                <option value="entrada">Entrada (+)</option>
                                <option value="saida">Saída (-)</option>
                                <option value="correcao">Correção (Definir Quantidade)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
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
                            <label for="estoque-atual" class="form-label">Estoque Atual</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="estoque-atual" readonly>
                                <span class="input-group-text" id="unidade-produto">UN</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="novo-estoque" class="form-label">Novo Estoque</label>
                            <div class="input-group">
                                <input type="number" class="form-control bg-light" id="novo-estoque" readonly>
                                <span class="input-group-text" id="unidade-novo">UN</span>
                            </div>
                        </div>
                    </div>

                
            </div>
            <div class="modal-footer">
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

<script>
let produtoSelecionado = null;
const modal = document.getElementById('ajuste_estoque');
modal.addEventListener('show.bs.modal', function (event) {
    
  const button = event.relatedTarget;
  const codigo = button.getAttribute('data-id').trim();
  
  fetch(`<?=BASE_URL?>/produto/api3/${encodeURIComponent(codigo)}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.produto) {
                const produto = data.produto;
                selecionarProduto(produto.id, produto.nome, produto.id, produto.quantidade || 0, produto.unidade_medida || 'UN');
            } else {
                alert(data.message || 'Produto não encontrado');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao buscar produto');
        });

});

function selecionarProduto(id, nome, codigo, estoqueAtual, unidade) {
    produtoSelecionado = {
        id: id,
        nome: nome,
        codigo: codigo,
        estoque_atual: estoqueAtual,
        unidade: unidade
    };
    
    document.getElementById('estoque-atual').value = estoqueAtual;
    
    // Atualizar unidades
    document.getElementById('unidade-produto').textContent = unidade;
    document.getElementById('unidade-ajuste').textContent = unidade;
    document.getElementById('unidade-novo').textContent = unidade;
    document.getElementById('modal_titulo').textContent = nome;
    
    // Focar no tipo de ajuste
    document.getElementById('tipo-ajuste').focus();
}

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
    
}

function limparFormulario() {
    produtoSelecionado = null;
    document.getElementById('form-ajuste').reset();
    document.getElementById('tipo-ajuste').focus();
    bootstrap.Modal.getInstance(modal).hide();
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
    
    dados.produto_id = produtoSelecionado.id;

    // Validações
    if (!dados.tipo_ajuste || !dados.quantidade) {
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
    
    fetch('<?=BASE_URL?>/estoque/ajustar', {
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
</script>