<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-activity"></i>
                Minhas Atividades
            </h1>
            <div>
                <button class="btn btn-outline-primary me-2" onclick="exportarAtividades()">
                    <i class="bi bi-download"></i>
                    Exportar
                </button>
                <a href="/perfil" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Voltar
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label for="data_inicio" class="form-label">Data Início</label>
                        <input type="date" class="form-control" id="data_inicio" name="data_inicio" 
                               value="<?= htmlspecialchars($_GET['data_inicio'] ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="data_fim" class="form-label">Data Fim</label>
                        <input type="date" class="form-control" id="data_fim" name="data_fim" 
                               value="<?= htmlspecialchars($_GET['data_fim'] ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="tipo" class="form-label">Tipo de Atividade</label>
                        <select class="form-select" id="tipo" name="tipo">
                            <option value="">Todos os tipos</option>
                            <option value="login" <?= ($_GET['tipo'] ?? '') === 'login' ? 'selected' : '' ?>>Login</option>
                            <option value="logout" <?= ($_GET['tipo'] ?? '') === 'logout' ? 'selected' : '' ?>>Logout</option>
                            <option value="perfil_atualizado" <?= ($_GET['tipo'] ?? '') === 'perfil_atualizado' ? 'selected' : '' ?>>Perfil Atualizado</option>
                            <option value="senha_alterada" <?= ($_GET['tipo'] ?? '') === 'senha_alterada' ? 'selected' : '' ?>>Senha Alterada</option>
                            <option value="orcamento_criado" <?= ($_GET['tipo'] ?? '') === 'orcamento_criado' ? 'selected' : '' ?>>Orçamento Criado</option>
                            <option value="produto_cadastrado" <?= ($_GET['tipo'] ?? '') === 'produto_cadastrado' ? 'selected' : '' ?>>Produto Cadastrado</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-search"></i>
                            Filtrar
                        </button>
                        <a href="/perfil/atividades" class="btn btn-outline-secondary">
                            <i class="bi bi-x"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Resumo das Atividades -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-primary">
            <div class="card-body text-center">
                <h4 class="text-primary"><?= count($atividades) ?></h4>
                <p class="card-text">Atividades Hoje</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-success">
            <div class="card-body text-center">
                <h4 class="text-success">
                    <?= count(array_filter($atividades, function($a) { 
                        return date('Y-m-d', strtotime($a['data_criacao'])) === date('Y-m-d', strtotime('-7 days')); 
                    })) ?>
                </h4>
                <p class="card-text">Esta Semana</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-info">
            <div class="card-body text-center">
                <h4 class="text-info">
                    <?= count(array_filter($atividades, function($a) { 
                        return date('Y-m', strtotime($a['data_criacao'])) === date('Y-m'); 
                    })) ?>
                </h4>
                <p class="card-text">Este Mês</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-warning">
            <div class="card-body text-center">
                <h4 class="text-warning"><?= count($atividades) ?></h4>
                <p class="card-text">Total</p>
            </div>
        </div>
    </div>
</div>

<!-- Lista de Atividades -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0">
                    <i class="bi bi-list"></i>
                    Histórico de Atividades
                </h6>
                <div class="btn-group btn-group-sm" role="group">
                    <button class="btn btn-outline-info" onclick="atualizarAtividades()">
                        <i class="bi bi-arrow-clockwise"></i>
                        Atualizar
                    </button>
                    <button class="btn btn-outline-danger" onclick="limparAtividades()">
                        <i class="bi bi-trash"></i>
                        Limpar Histórico
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <?php if (empty($atividades)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-activity display-1 text-muted"></i>
                        <h5 class="mt-3">Nenhuma atividade encontrada</h5>
                        <p class="text-muted">Suas atividades no sistema aparecerão aqui.</p>
                    </div>
                <?php else: ?>
                    <div class="timeline-container p-4">
                        <?php 
                        $data_anterior = '';
                        foreach ($atividades as $atividade): 
                            $data_atividade = date('Y-m-d', strtotime($atividade['data_criacao']));
                            
                            // Mostrar separador de data se mudou
                            if ($data_atividade !== $data_anterior):
                                $data_anterior = $data_atividade;
                        ?>
                            <div class="timeline-date">
                                <h6 class="text-muted">
                                    <?php
                                    $hoje = date('Y-m-d');
                                    $ontem = date('Y-m-d', strtotime('-1 day'));
                                    
                                    if ($data_atividade === $hoje) {
                                        echo 'Hoje';
                                    } elseif ($data_atividade === $ontem) {
                                        echo 'Ontem';
                                    } else {
                                        echo date('d/m/Y', strtotime($data_atividade));
                                    }
                                    ?>
                                </h6>
                            </div>
                        <?php endif; ?>
                        
                        <div class="timeline-item">
                            <div class="timeline-marker <?= getCorTipoAtividade($atividade['tipo']) ?>"></div>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="timeline-title">
                                            <?= getIconeTipoAtividade($atividade['tipo']) ?>
                                            <?= htmlspecialchars($atividade['descricao']) ?>
                                        </h6>
                                        <p class="timeline-text text-muted mb-1">
                                            <small>
                                                <i class="bi bi-clock"></i>
                                                <?= date('H:i:s', strtotime($atividade['data_criacao'])) ?>
                                            </small>
                                        </p>
                                        
                                        <?php if (!empty($atividade['dados_extras'])): ?>
                                            <div class="timeline-details">
                                                <small class="text-muted">
                                                    <?= formatarDadosExtras($atividade['dados_extras']) ?>
                                                </small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <span class="badge bg-<?= getCorTipoAtividade($atividade['tipo'], false) ?>">
                                            <?= getTipoAtividadeNome($atividade['tipo']) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Paginação -->
<?php if (!empty($atividades) && count($atividades) >= 20): ?>
<div class="row mt-3">
    <div class="col-12">
        <nav aria-label="Navegação das atividades">
            <ul class="pagination justify-content-center">
                <?php if ($pagina_atual > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?pagina=<?= $pagina_atual - 1 ?><?= http_build_query(array_filter($_GET, function($k) { return $k !== 'pagina'; }, ARRAY_FILTER_USE_KEY)) ? '&' . http_build_query(array_filter($_GET, function($k) { return $k !== 'pagina'; }, ARRAY_FILTER_USE_KEY)) : '' ?>">
                            <i class="bi bi-chevron-left"></i>
                            Anterior
                        </a>
                    </li>
                <?php endif; ?>
                
                <li class="page-item active">
                    <span class="page-link">Página <?= $pagina_atual ?></span>
                </li>
                
                <li class="page-item">
                    <a class="page-link" href="?pagina=<?= $pagina_atual + 1 ?><?= http_build_query(array_filter($_GET, function($k) { return $k !== 'pagina'; }, ARRAY_FILTER_USE_KEY)) ? '&' . http_build_query(array_filter($_GET, function($k) { return $k !== 'pagina'; }, ARRAY_FILTER_USE_KEY)) : '' ?>">
                        Próxima
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
<?php endif; ?>

<style>
.timeline-container {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 25px;
}

.timeline-marker {
    position: absolute;
    left: -35px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #007bff;
}

.timeline-container::before {
    content: '';
    position: absolute;
    left: -30px;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: #dee2e6;
}

.timeline-title {
    margin-bottom: 5px;
    font-size: 0.95rem;
}

.timeline-text {
    margin-bottom: 0;
    font-size: 0.85rem;
}

.timeline-date {
    margin: 30px 0 15px 0;
    padding-left: 15px;
    border-left: 3px solid #007bff;
}

.timeline-details {
    margin-top: 8px;
    padding: 8px 12px;
    background-color: #f8f9fa;
    border-radius: 4px;
    border-left: 3px solid #007bff;
}

.bg-login { background-color: #28a745 !important; }
.bg-logout { background-color: #6c757d !important; }
.bg-perfil_atualizado { background-color: #007bff !important; }
.bg-senha_alterada { background-color: #ffc107 !important; }
.bg-orcamento_criado { background-color: #17a2b8 !important; }
.bg-produto_cadastrado { background-color: #fd7e14 !important; }
</style>

<script>
function exportarAtividades() {
    const params = new URLSearchParams(window.location.search);
    params.set('exportar', 'csv');
    window.open('/perfil/atividades?' + params.toString(), '_blank');
}

function atualizarAtividades() {
    location.reload();
}

function limparAtividades() {
    if (confirm('Deseja limpar todo o histórico de atividades? Esta ação não pode ser desfeita.')) {
        if (confirm('Tem certeza absoluta? Todas as suas atividades registradas serão removidas!')) {
            fetch('/perfil/limpar-atividades', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Histórico de atividades limpo com sucesso!');
                    location.reload();
                } else {
                    alert('Erro ao limpar histórico: ' + data.message);
                }
            })
            .catch(error => {
                alert('Erro: ' + error.message);
            });
        }
    }
}

// Atualizar automaticamente a cada 2 minutos
setInterval(function() {
    // Verificar se há novas atividades
    fetch('/perfil/verificar-novas-atividades')
        .then(response => response.json())
        .then(data => {
            if (data.novas_atividades > 0) {
                // Mostrar notificação discreta
                const alert = document.createElement('div');
                alert.className = 'alert alert-info alert-dismissible fade show position-fixed';
                alert.style.cssText = 'top: 20px; right: 20px; z-index: 1050; max-width: 300px;';
                alert.innerHTML = `
                    <i class="bi bi-info-circle"></i>
                    ${data.novas_atividades} nova(s) atividade(s) registrada(s).
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.appendChild(alert);
                
                // Remover após 5 segundos
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 5000);
            }
        })
        .catch(error => {
            console.log('Erro ao verificar novas atividades:', error);
        });
}, 120000); // 2 minutos
</script>

<?php
// Funções auxiliares para formatação
function getCorTipoAtividade($tipo, $marker = true) {
    $cores = [
        'login' => $marker ? 'bg-success' : 'success',
        'logout' => $marker ? 'bg-secondary' : 'secondary',
        'perfil_atualizado' => $marker ? 'bg-primary' : 'primary',
        'senha_alterada' => $marker ? 'bg-warning' : 'warning',
        'orcamento_criado' => $marker ? 'bg-info' : 'info',
        'produto_cadastrado' => $marker ? 'bg-orange' : 'warning'
    ];
    
    return $cores[$tipo] ?? ($marker ? 'bg-secondary' : 'secondary');
}

function getIconeTipoAtividade($tipo) {
    $icones = [
        'login' => '<i class="bi bi-box-arrow-in-right text-success"></i>',
        'logout' => '<i class="bi bi-box-arrow-left text-secondary"></i>',
        'perfil_atualizado' => '<i class="bi bi-person-gear text-primary"></i>',
        'senha_alterada' => '<i class="bi bi-key text-warning"></i>',
        'orcamento_criado' => '<i class="bi bi-file-earmark-plus text-info"></i>',
        'produto_cadastrado' => '<i class="bi bi-box text-warning"></i>'
    ];
    
    return $icones[$tipo] ?? '<i class="bi bi-circle text-secondary"></i>';
}

function getTipoAtividadeNome($tipo) {
    $nomes = [
        'login' => 'Login',
        'logout' => 'Logout',
        'perfil_atualizado' => 'Perfil',
        'senha_alterada' => 'Senha',
        'orcamento_criado' => 'Orçamento',
        'produto_cadastrado' => 'Produto'
    ];
    
    return $nomes[$tipo] ?? ucfirst($tipo);
}

function formatarDadosExtras($dados_json) {
    if (empty($dados_json)) return '';
    
    $dados = json_decode($dados_json, true);
    if (!$dados) return '';
    
    $formatado = [];
    foreach ($dados as $chave => $valor) {
        $formatado[] = ucfirst($chave) . ': ' . $valor;
    }
    
    return implode(' | ', $formatado);
}
?>

