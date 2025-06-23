<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-info-circle"></i>
                Informações do Sistema
            </h1>
            <div>
                <button class="btn btn-outline-primary me-2" onclick="atualizarInformacoes()">
                    <i class="bi bi-arrow-clockwise"></i>
                    Atualizar
                </button>
                <a href="/configuracao" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Voltar
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Informações do Sistema -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-gear"></i>
                    Informações do Sistema
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Nome do Sistema:</strong></td>
                        <td>BikeSystem</td>
                    </tr>
                    <tr>
                        <td><strong>Versão:</strong></td>
                        <td>
                            <span class="badge bg-primary">v1.0.0</span>
                            <small class="text-muted">(Build 2024.01)</small>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Data de Instalação:</strong></td>
                        <td><?= date('d/m/Y H:i', $info_sistema['data_instalacao']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Última Atualização:</strong></td>
                        <td><?= date('d/m/Y H:i', $info_sistema['ultima_atualizacao']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Desenvolvedor:</strong></td>
                        <td>Manus AI Assistant</td>
                    </tr>
                    <tr>
                        <td><strong>Licença:</strong></td>
                        <td>
                            <span class="badge bg-success">Licenciado</span>
                            <small class="text-muted">Uso comercial autorizado</small>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-server"></i>
                    Informações do Servidor
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Sistema Operacional:</strong></td>
                        <td><?= php_uname('s') . ' ' . php_uname('r') ?></td>
                    </tr>
                    <tr>
                        <td><strong>Servidor Web:</strong></td>
                        <td><?= $_SERVER['SERVER_SOFTWARE'] ?? 'N/A' ?></td>
                    </tr>
                    <tr>
                        <td><strong>Versão PHP:</strong></td>
                        <td>
                            <span class="badge bg-info"><?= PHP_VERSION ?></span>
                            <?php if (version_compare(PHP_VERSION, '8.0.0', '>=')): ?>
                                <i class="bi bi-check-circle text-success" title="Versão recomendada"></i>
                            <?php else: ?>
                                <i class="bi bi-exclamation-triangle text-warning" title="Considere atualizar"></i>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Banco de Dados:</strong></td>
                        <td>
                            <?= $info_banco['tipo'] ?> 
                            <span class="badge bg-secondary"><?= $info_banco['versao'] ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Timezone:</strong></td>
                        <td><?= date_default_timezone_get() ?></td>
                    </tr>
                    <tr>
                        <td><strong>Uptime:</strong></td>
                        <td><?= $info_sistema['uptime'] ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Status dos Serviços -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-activity"></i>
                    Status dos Serviços
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center mb-3">
                            <div class="status-indicator bg-<?= $status_servicos['banco_dados'] ? 'success' : 'danger' ?> me-3"></div>
                            <div>
                                <strong>Banco de Dados</strong>
                                <br>
                                <small class="text-muted">
                                    <?= $status_servicos['banco_dados'] ? 'Conectado' : 'Desconectado' ?>
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="d-flex align-items-center mb-3">
                            <div class="status-indicator bg-<?= $status_servicos['email'] ? 'success' : 'warning' ?> me-3"></div>
                            <div>
                                <strong>Servidor Email</strong>
                                <br>
                                <small class="text-muted">
                                    <?= $status_servicos['email'] ? 'Configurado' : 'Não configurado' ?>
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="d-flex align-items-center mb-3">
                            <div class="status-indicator bg-<?= $status_servicos['backup'] ? 'success' : 'warning' ?> me-3"></div>
                            <div>
                                <strong>Backup Automático</strong>
                                <br>
                                <small class="text-muted">
                                    <?= $status_servicos['backup'] ? 'Ativo' : 'Inativo' ?>
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="d-flex align-items-center mb-3">
                            <div class="status-indicator bg-<?= $status_servicos['cache'] ? 'success' : 'info' ?> me-3"></div>
                            <div>
                                <strong>Sistema de Cache</strong>
                                <br>
                                <small class="text-muted">
                                    <?= $status_servicos['cache'] ? 'Ativo' : 'Desabilitado' ?>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estatísticas de Uso -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-database"></i>
                    Estatísticas do Banco
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td>Produtos cadastrados:</td>
                        <td><strong><?= number_format($estatisticas['produtos'], 0, ',', '.') ?></strong></td>
                    </tr>
                    <tr>
                        <td>Orçamentos criados:</td>
                        <td><strong><?= number_format($estatisticas['orcamentos'], 0, ',', '.') ?></strong></td>
                    </tr>
                    <tr>
                        <td>Usuários ativos:</td>
                        <td><strong><?= number_format($estatisticas['usuarios'], 0, ',', '.') ?></strong></td>
                    </tr>
                    <tr>
                        <td>Tabelas de preço:</td>
                        <td><strong><?= number_format($estatisticas['tabelas_preco'], 0, ',', '.') ?></strong></td>
                    </tr>
                    <tr>
                        <td>Tamanho do banco:</td>
                        <td><strong><?= formatBytes($estatisticas['tamanho_banco']) ?></strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-hdd"></i>
                    Uso de Disco
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Espaço Total:</span>
                        <strong><?= formatBytes($uso_disco['total']) ?></strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Espaço Usado:</span>
                        <strong><?= formatBytes($uso_disco['usado']) ?></strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Espaço Livre:</span>
                        <strong><?= formatBytes($uso_disco['livre']) ?></strong>
                    </div>
                </div>
                
                <div class="progress mb-2">
                    <div class="progress-bar <?= $uso_disco['percentual'] > 80 ? 'bg-danger' : ($uso_disco['percentual'] > 60 ? 'bg-warning' : 'bg-success') ?>" 
                         style="width: <?= $uso_disco['percentual'] ?>%"></div>
                </div>
                <small class="text-muted"><?= number_format($uso_disco['percentual'], 1) ?>% utilizado</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-cpu"></i>
                    Performance
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td>Memória PHP:</td>
                        <td><strong><?= ini_get('memory_limit') ?></strong></td>
                    </tr>
                    <tr>
                        <td>Tempo limite:</td>
                        <td><strong><?= ini_get('max_execution_time') ?>s</strong></td>
                    </tr>
                    <tr>
                        <td>Upload máximo:</td>
                        <td><strong><?= ini_get('upload_max_filesize') ?></strong></td>
                    </tr>
                    <tr>
                        <td>Sessões ativas:</td>
                        <td><strong><?= $performance['sessoes_ativas'] ?></strong></td>
                    </tr>
                    <tr>
                        <td>Tempo resposta médio:</td>
                        <td><strong><?= $performance['tempo_resposta'] ?>ms</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Logs do Sistema -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0">
                    <i class="bi bi-file-text"></i>
                    Logs Recentes do Sistema
                </h6>
                <div>
                    <button class="btn btn-outline-primary btn-sm" onclick="baixarLogs()">
                        <i class="bi bi-download"></i>
                        Baixar Logs
                    </button>
                    <button class="btn btn-outline-warning btn-sm" onclick="limparLogs()">
                        <i class="bi bi-trash"></i>
                        Limpar Logs
                    </button>
                </div>
            </div>
            <div class="card-body">
                <?php if (!empty($logs_recentes)): ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th width="150">Data/Hora</th>
                                    <th width="100">Tipo</th>
                                    <th width="120">Usuário</th>
                                    <th>Mensagem</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($logs_recentes as $log): ?>
                                    <tr>
                                        <td>
                                            <small><?= date('d/m/Y H:i:s', strtotime($log['data'])) ?></small>
                                        </td>
                                        <td>
                                            <?php
                                            $tipo_cores = [
                                                'info' => 'info',
                                                'warning' => 'warning',
                                                'error' => 'danger',
                                                'success' => 'success'
                                            ];
                                            ?>
                                            <span class="badge bg-<?= $tipo_cores[$log['tipo']] ?? 'secondary' ?>">
                                                <?= ucfirst($log['tipo']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <small><?= htmlspecialchars($log['usuario'] ?? 'Sistema') ?></small>
                                        </td>
                                        <td>
                                            <small><?= htmlspecialchars($log['mensagem']) ?></small>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center text-muted">
                        <i class="bi bi-inbox"></i>
                        Nenhum log encontrado
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Extensões PHP -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-puzzle"></i>
                    Extensões PHP Carregadas
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php 
                    $extensoes_importantes = ['pdo', 'pdo_mysql', 'mysqli', 'curl', 'gd', 'mbstring', 'json', 'openssl', 'zip'];
                    $extensoes_carregadas = get_loaded_extensions();
                    ?>
                    
                    <div class="col-md-6">
                        <h6>Extensões Essenciais</h6>
                        <?php foreach ($extensoes_importantes as $ext): ?>
                            <div class="d-flex align-items-center mb-2">
                                <?php if (in_array($ext, $extensoes_carregadas)): ?>
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    <span><?= $ext ?></span>
                                    <span class="badge bg-success ms-2">Carregada</span>
                                <?php else: ?>
                                    <i class="bi bi-x-circle text-danger me-2"></i>
                                    <span><?= $ext ?></span>
                                    <span class="badge bg-danger ms-2">Não encontrada</span>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="col-md-6">
                        <h6>Todas as Extensões (<?= count($extensoes_carregadas) ?>)</h6>
                        <div style="max-height: 200px; overflow-y: auto;">
                            <?php foreach ($extensoes_carregadas as $ext): ?>
                                <span class="badge bg-light text-dark me-1 mb-1"><?= $ext ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.status-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    display: inline-block;
}
</style>

<script>
function atualizarInformacoes() {
    location.reload();
}

function baixarLogs() {
    window.open('/configuracao/baixar-logs', '_blank');
}

function limparLogs() {
    if (confirm('Deseja limpar todos os logs do sistema? Esta ação não pode ser desfeita.')) {
        fetch('/configuracao/limpar-logs', {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Logs limpos com sucesso!');
                location.reload();
            } else {
                alert('Erro ao limpar logs: ' + data.message);
            }
        })
        .catch(error => {
            alert('Erro: ' + error.message);
        });
    }
}

// Atualizar informações a cada 30 segundos
setInterval(function() {
    // Atualizar apenas os dados dinâmicos via AJAX
    fetch('/configuracao/info-dinamica')
        .then(response => response.json())
        .then(data => {
            // Atualizar elementos específicos sem recarregar a página
            if (data.uptime) {
                // Atualizar uptime, sessões ativas, etc.
            }
        })
        .catch(error => {
            console.log('Erro ao atualizar informações dinâmicas:', error);
        });
}, 30000);
</script>

<?php
function formatBytes($size, $precision = 2) {
    $base = log($size, 1024);
    $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');
    return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
}
?>

