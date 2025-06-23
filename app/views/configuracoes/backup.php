<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-shield-check"></i>
                Gerenciamento de Backup
            </h1>
            <div>
                <button class="btn btn-success me-2" onclick="criarBackup()">
                    <i class="bi bi-plus-circle"></i>
                    Criar Backup
                </button>
                <a href="/configuracao" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Voltar
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Configurações de backup automático -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-gear"></i>
                    Configurações de Backup Automático
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" action="/configuracao/salvar-backup">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="backup_automatico" 
                                       name="backup_automatico" <?= $config['backup_automatico'] ? 'checked' : '' ?>>
                                <label class="form-check-label" for="backup_automatico">
                                    <strong>Backup Automático</strong>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="intervalo_horas" class="form-label">Intervalo (horas)</label>
                            <select class="form-select" id="intervalo_horas" name="intervalo_horas">
                                <option value="6" <?= $config['intervalo_horas'] == 6 ? 'selected' : '' ?>>A cada 6 horas</option>
                                <option value="12" <?= $config['intervalo_horas'] == 12 ? 'selected' : '' ?>>A cada 12 horas</option>
                                <option value="24" <?= $config['intervalo_horas'] == 24 ? 'selected' : '' ?>>Diário</option>
                                <option value="168" <?= $config['intervalo_horas'] == 168 ? 'selected' : '' ?>>Semanal</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="manter_arquivos" class="form-label">Manter arquivos (dias)</label>
                            <input type="number" class="form-control" id="manter_arquivos" 
                                   name="manter_arquivos" value="<?= $config['manter_arquivos'] ?>" 
                                   min="1" max="365">
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i>
                            Salvar Configurações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Status do último backup -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card border-info">
            <div class="card-header bg-info text-white">
                <h6 class="card-title mb-0">
                    <i class="bi bi-info-circle"></i>
                    Status do Backup
                </h6>
            </div>
            <div class="card-body">
                <?php if ($ultimo_backup): ?>
                    <div class="row">
                        <div class="col-6">
                            <strong>Último Backup:</strong>
                            <br>
                            <?= date('d/m/Y H:i', $ultimo_backup['date']) ?>
                        </div>
                        <div class="col-6">
                            <strong>Tamanho:</strong>
                            <br>
                            <?= formatBytes($ultimo_backup['size']) ?>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-success">
                            <i class="bi bi-check-circle"></i>
                            Sistema protegido
                        </span>
                    </div>
                <?php else: ?>
                    <div class="text-center">
                        <i class="bi bi-exclamation-triangle text-warning" style="font-size: 2rem;"></i>
                        <h6 class="mt-2">Nenhum backup encontrado</h6>
                        <p class="text-muted">Crie seu primeiro backup para proteger os dados.</p>
                        <button class="btn btn-warning" onclick="criarBackup()">
                            <i class="bi bi-plus-circle"></i>
                            Criar Primeiro Backup
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card border-warning">
            <div class="card-header bg-warning text-dark">
                <h6 class="card-title mb-0">
                    <i class="bi bi-exclamation-triangle"></i>
                    Próximo Backup
                </h6>
            </div>
            <div class="card-body">
                <?php if ($config['backup_automatico']): ?>
                    <div class="row">
                        <div class="col-6">
                            <strong>Próximo backup:</strong>
                            <br>
                            <?= $proximo_backup ?>
                        </div>
                        <div class="col-6">
                            <strong>Frequência:</strong>
                            <br>
                            A cada <?= $config['intervalo_horas'] ?> horas
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-success">
                            <i class="bi bi-clock"></i>
                            Automático ativo
                        </span>
                    </div>
                <?php else: ?>
                    <div class="text-center">
                        <i class="bi bi-clock text-muted" style="font-size: 2rem;"></i>
                        <h6 class="mt-2">Backup automático desativado</h6>
                        <p class="text-muted">Ative o backup automático para proteção contínua.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Lista de backups -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0">
                    <i class="bi bi-list"></i>
                    Arquivos de Backup (<?= count($backups) ?>)
                </h6>
                <div>
                    <button class="btn btn-outline-danger btn-sm" onclick="limparBackupsAntigos()" 
                            <?= count($backups) == 0 ? 'disabled' : '' ?>>
                        <i class="bi bi-trash"></i>
                        Limpar Antigos
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <?php if (empty($backups)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                        <h5 class="mt-3">Nenhum backup encontrado</h5>
                        <p class="text-muted">Crie seu primeiro backup para começar a proteger seus dados.</p>
                        <button class="btn btn-primary" onclick="criarBackup()">
                            <i class="bi bi-plus-circle"></i>
                            Criar Primeiro Backup
                        </button>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Arquivo</th>
                                    <th width="150">Data/Hora</th>
                                    <th width="100">Tamanho</th>
                                    <th width="100">Tipo</th>
                                    <th width="150">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($backups as $backup): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-file-earmark-zip text-primary me-2"></i>
                                                <div>
                                                    <strong><?= htmlspecialchars($backup['filename']) ?></strong>
                                                    <br>
                                                    <small class="text-muted">
                                                        <?= pathinfo($backup['filename'], PATHINFO_EXTENSION) === 'gz' ? 'Comprimido' : 'SQL' ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <strong><?= date('d/m/Y', $backup['date']) ?></strong>
                                                <br>
                                                <small class="text-muted"><?= date('H:i:s', $backup['date']) ?></small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">
                                                <?= formatBytes($backup['size']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php 
                                            $idade = time() - $backup['date'];
                                            $dias = floor($idade / 86400);
                                            ?>
                                            <?php if ($dias == 0): ?>
                                                <span class="badge bg-success">Hoje</span>
                                            <?php elseif ($dias == 1): ?>
                                                <span class="badge bg-warning">Ontem</span>
                                            <?php elseif ($dias <= 7): ?>
                                                <span class="badge bg-secondary"><?= $dias ?> dias</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger"><?= $dias ?> dias</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="/configuracao/baixar-backup/<?= urlencode($backup['filename']) ?>" 
                                                   class="btn btn-outline-success" 
                                                   data-bs-toggle="tooltip" title="Baixar">
                                                    <i class="bi bi-download"></i>
                                                </a>
                                                <button class="btn btn-outline-primary" 
                                                        onclick="restaurarBackup('<?= htmlspecialchars($backup['filename']) ?>')"
                                                        data-bs-toggle="tooltip" title="Restaurar">
                                                    <i class="bi bi-arrow-clockwise"></i>
                                                </button>
                                                <button class="btn btn-outline-danger" 
                                                        onclick="excluirBackup('<?= htmlspecialchars($backup['filename']) ?>')"
                                                        data-bs-toggle="tooltip" title="Excluir">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="2">Total de arquivos: <?= count($backups) ?></th>
                                    <th>
                                        <?php 
                                        $tamanho_total = array_sum(array_column($backups, 'size'));
                                        echo formatBytes($tamanho_total);
                                        ?>
                                    </th>
                                    <th colspan="2"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Instruções de backup -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-info">
            <div class="card-header bg-info text-white">
                <h6 class="card-title mb-0">
                    <i class="bi bi-lightbulb"></i>
                    Dicas Importantes sobre Backup
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Boas Práticas:</h6>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-check-circle text-success"></i> Mantenha backup automático ativo</li>
                            <li><i class="bi bi-check-circle text-success"></i> Faça backup antes de atualizações</li>
                            <li><i class="bi bi-check-circle text-success"></i> Teste restaurações periodicamente</li>
                            <li><i class="bi bi-check-circle text-success"></i> Armazene cópias em local seguro</li>
                            <li><i class="bi bi-check-circle text-success"></i> Monitore o espaço em disco</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Informações Técnicas:</h6>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-info-circle text-info"></i> Backups são comprimidos automaticamente</li>
                            <li><i class="bi bi-info-circle text-info"></i> Inclui estrutura e dados do banco</li>
                            <li><i class="bi bi-info-circle text-info"></i> Arquivos antigos são removidos automaticamente</li>
                            <li><i class="bi bi-info-circle text-info"></i> Processo não afeta performance do sistema</li>
                            <li><i class="bi bi-info-circle text-info"></i> Logs de backup são mantidos para auditoria</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function criarBackup() {
    if (confirm('Deseja criar um novo backup? Este processo pode levar alguns minutos.')) {
        // Mostrar loading
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Criando...';
        btn.disabled = true;
        
        fetch('/configuracao/criar-backup', {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Backup criado com sucesso!');
                location.reload();
            } else {
                alert('Erro ao criar backup: ' + data.message);
            }
        })
        .catch(error => {
            alert('Erro: ' + error.message);
        })
        .finally(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }
}

function restaurarBackup(filename) {
    if (confirm('ATENÇÃO: Esta ação irá substituir todos os dados atuais pelos dados do backup selecionado. Esta operação não pode ser desfeita. Deseja continuar?')) {
        if (confirm('Tem certeza absoluta? Todos os dados atuais serão perdidos!')) {
            const btn = event.target;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-hourglass-split"></i>';
            btn.disabled = true;
            
            fetch('/configuracao/restaurar-backup', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ filename: filename })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Backup restaurado com sucesso! O sistema será recarregado.');
                    location.reload();
                } else {
                    alert('Erro ao restaurar backup: ' + data.message);
                }
            })
            .catch(error => {
                alert('Erro: ' + error.message);
            })
            .finally(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        }
    }
}

function excluirBackup(filename) {
    if (confirm('Deseja excluir este arquivo de backup? Esta ação não pode ser desfeita.')) {
        fetch('/configuracao/excluir-backup', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ filename: filename })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Backup excluído com sucesso!');
                location.reload();
            } else {
                alert('Erro ao excluir backup: ' + data.message);
            }
        })
        .catch(error => {
            alert('Erro: ' + error.message);
        });
    }
}

function limparBackupsAntigos() {
    if (confirm('Deseja excluir todos os backups com mais de 30 dias? Esta ação não pode ser desfeita.')) {
        fetch('/configuracao/limpar-backups-antigos', {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Backups antigos removidos com sucesso!');
                location.reload();
            } else {
                alert('Erro ao limpar backups: ' + data.message);
            }
        })
        .catch(error => {
            alert('Erro: ' + error.message);
        });
    }
}

// Função para formatar bytes (JavaScript)
function formatBytes(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Inicializar tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<?php
function formatBytes($size, $precision = 2) {
    $base = log($size, 1024);
    $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');
    return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
}
?>

