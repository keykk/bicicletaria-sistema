<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-gear"></i>
                Configurações do Sistema
            </h1>
        </div>
    </div>
</div>

<!-- Cards de configurações -->
<div class="row">
    <!-- Configurações da Empresa -->
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 border-primary">
            <div class="card-header bg-primary text-white">
                <h6 class="card-title mb-0">
                    <i class="bi bi-building"></i>
                    Empresa
                </h6>
            </div>
            <div class="card-body">
                <p class="card-text">Configure as informações da sua bicicletaria que aparecerão nos orçamentos e documentos.</p>
                <ul class="list-unstyled">
                    <li><i class="bi bi-check-circle text-success"></i> Nome e dados da empresa</li>
                    <li><i class="bi bi-check-circle text-success"></i> Endereço e contatos</li>
                    <li><i class="bi bi-check-circle text-success"></i> Logo e identidade visual</li>
                    <li><i class="bi bi-check-circle text-success"></i> CNPJ e documentos</li>
                </ul>
            </div>
            <div class="card-footer">
                <a href="<?php echo BASE_URL; ?>/configuracao/empresa" class="btn btn-primary">
                    <i class="bi bi-pencil"></i>
                    Configurar Empresa
                </a>
            </div>
        </div>
    </div>

    <!-- Configurações do Sistema -->
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 border-info">
            <div class="card-header bg-info text-white">
                <h6 class="card-title mb-0">
                    <i class="bi bi-gear-wide-connected"></i>
                    Sistema
                </h6>
            </div>
            <div class="card-body">
                <p class="card-text">Ajuste configurações gerais do sistema, limites e comportamentos padrão.</p>
                <ul class="list-unstyled">
                    <li><i class="bi bi-check-circle text-success"></i> Limites de estoque</li>
                    <li><i class="bi bi-check-circle text-success"></i> Configurações de orçamento</li>
                    <li><i class="bi bi-check-circle text-success"></i> Formatos e moeda</li>
                    <li><i class="bi bi-check-circle text-success"></i> Timezone e idioma</li>
                </ul>
            </div>
            <div class="card-footer">
                <a href="<?php echo BASE_URL; ?>/configuracao/sistema" class="btn btn-info">
                    <i class="bi bi-gear"></i>
                    Configurar Sistema
                </a>
            </div>
        </div>
    </div>

    <!-- Gerenciamento de Usuários -->
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 border-success">
            <div class="card-header bg-success text-white">
                <h6 class="card-title mb-0">
                    <i class="bi bi-people"></i>
                    Usuários
                </h6>
            </div>
            <div class="card-body">
                <p class="card-text">Gerencie usuários do sistema, permissões e níveis de acesso.</p>
                <ul class="list-unstyled">
                    <li><i class="bi bi-check-circle text-success"></i> Criar novos usuários</li>
                    <li><i class="bi bi-check-circle text-success"></i> Definir permissões</li>
                    <li><i class="bi bi-check-circle text-success"></i> Ativar/desativar contas</li>
                    <li><i class="bi bi-check-circle text-success"></i> Histórico de acessos</li>
                </ul>
            </div>
            <div class="card-footer">
                <a href="<?php echo BASE_URL; ?>/configuracao/usuarios" class="btn btn-success">
                    <i class="bi bi-people"></i>
                    Gerenciar Usuários
                </a>
            </div>
        </div>
    </div>

    <!-- Backup e Segurança -->
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 border-warning">
            <div class="card-header bg-warning text-dark">
                <h6 class="card-title mb-0">
                    <i class="bi bi-shield-check"></i>
                    Backup
                </h6>
            </div>
            <div class="card-body">
                <p class="card-text">Configure backups automáticos e gerencie a segurança dos dados.</p>
                <ul class="list-unstyled">
                    <li><i class="bi bi-check-circle text-success"></i> Backup automático</li>
                    <li><i class="bi bi-check-circle text-success"></i> Restaurar dados</li>
                    <li><i class="bi bi-check-circle text-success"></i> Download de backups</li>
                    <li><i class="bi bi-check-circle text-success"></i> Configurar frequência</li>
                </ul>
            </div>
            <div class="card-footer">
                <a href="<?php echo BASE_URL; ?>/configuracao/backup" class="btn btn-warning">
                    <i class="bi bi-download"></i>
                    Gerenciar Backup
                </a>
            </div>
        </div>
    </div>

    <!-- Configurações de Email -->
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 border-secondary">
            <div class="card-header bg-secondary text-white">
                <h6 class="card-title mb-0">
                    <i class="bi bi-envelope"></i>
                    Email
                </h6>
            </div>
            <div class="card-body">
                <p class="card-text">Configure servidor SMTP para envio de orçamentos e notificações por email.</p>
                <ul class="list-unstyled">
                    <li><i class="bi bi-check-circle text-success"></i> Servidor SMTP</li>
                    <li><i class="bi bi-check-circle text-success"></i> Templates de email</li>
                    <li><i class="bi bi-check-circle text-success"></i> Teste de envio</li>
                    <li><i class="bi bi-check-circle text-success"></i> Notificações automáticas</li>
                </ul>
            </div>
            <div class="card-footer">
                <button class="btn btn-secondary" onclick="testarEmail()">
                    <i class="bi bi-envelope-check"></i>
                    Testar Email
                </button>
            </div>
        </div>
    </div>

    <!-- Informações do Sistema -->
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 border-dark">
            <div class="card-header bg-dark text-white">
                <h6 class="card-title mb-0">
                    <i class="bi bi-info-circle"></i>
                    Informações
                </h6>
            </div>
            <div class="card-body">
                <p class="card-text">Visualize informações técnicas do sistema e versões instaladas.</p>
                <ul class="list-unstyled">
                    <li><i class="bi bi-check-circle text-success"></i> Versão do sistema</li>
                    <li><i class="bi bi-check-circle text-success"></i> Informações do servidor</li>
                    <li><i class="bi bi-check-circle text-success"></i> Logs do sistema</li>
                    <li><i class="bi bi-check-circle text-success"></i> Status dos serviços</li>
                </ul>
            </div>
            <div class="card-footer">
                <a href="<?php echo BASE_URL; ?>/configuracao/info" class="btn btn-dark">
                    <i class="bi bi-info-circle"></i>
                    Ver Informações
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Seção de ações rápidas -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-lightning"></i>
                    Ações Rápidas
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <button class="btn btn-outline-primary w-100" onclick="criarBackup()">
                            <i class="bi bi-download"></i>
                            <br>
                            Criar Backup
                        </button>
                    </div>
                    <div class="col-md-3 mb-3">
                        <button class="btn btn-outline-success w-100" onclick="novoUsuario()">
                            <i class="bi bi-person-plus"></i>
                            <br>
                            Novo Usuário
                        </button>
                    </div>
                    <div class="col-md-3 mb-3">
                        <button class="btn btn-outline-info w-100" onclick="verificarAtualizacoes()">
                            <i class="bi bi-arrow-clockwise"></i>
                            <br>
                            Verificar Atualizações
                        </button>
                    </div>
                    <div class="col-md-3 mb-3">
                        <button class="btn btn-outline-warning w-100" onclick="limparCache()">
                            <i class="bi bi-trash"></i>
                            <br>
                            Limpar Cache
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status do sistema -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-activity"></i>
                    Status do Sistema
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="status-indicator bg-success me-2"></div>
                            <div>
                                <strong>Banco de Dados</strong>
                                <br>
                                <small class="text-muted">Conectado</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="status-indicator bg-success me-2"></div>
                            <div>
                                <strong>Servidor Web</strong>
                                <br>
                                <small class="text-muted">Online</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="status-indicator bg-<?= $email_configurado ? 'success' : 'warning' ?> me-2"></div>
                            <div>
                                <strong>Email</strong>
                                <br>
                                <small class="text-muted"><?= $email_configurado ? 'Configurado' : 'Não configurado' ?></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="status-indicator bg-<?= $backup_automatico ? 'success' : 'warning' ?> me-2"></div>
                            <div>
                                <strong>Backup</strong>
                                <br>
                                <small class="text-muted"><?= $backup_automatico ? 'Automático ativo' : 'Manual apenas' ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Últimas atividades -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-clock-history"></i>
                    Últimas Atividades do Sistema
                </h6>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <?php if (!empty($ultimas_atividades)): ?>
                        <?php foreach ($ultimas_atividades as $atividade): ?>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-<?= $atividade['tipo'] ?>"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title"><?= htmlspecialchars($atividade['titulo']) ?></h6>
                                    <p class="timeline-text"><?= htmlspecialchars($atividade['descricao']) ?></p>
                                    <small class="text-muted">
                                        <i class="bi bi-clock"></i>
                                        <?= date('d/m/Y H:i', strtotime($atividade['data'])) ?>
                                    </small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center text-muted">
                            <i class="bi bi-inbox"></i>
                            Nenhuma atividade recente
                        </div>
                    <?php endif; ?>
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

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -23px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #dee2e6;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border-left: 3px solid #0d6efd;
}

.timeline-title {
    margin-bottom: 5px;
    font-size: 14px;
}

.timeline-text {
    margin-bottom: 5px;
    font-size: 13px;
}
</style>

<script>
function criarBackup() {
    if (confirm('Deseja criar um backup manual do sistema?')) {
        window.location.href = '<?php echo BASE_URL; ?>/configuracao/criar-backup';
    }
}

function novoUsuario() {
    window.location.href = '<?php echo BASE_URL; ?>/configuracao/novo-usuario';
}

function testarEmail() {
    const email = prompt('Digite um email para teste:');
    if (email) {
        fetch('<?php echo BASE_URL; ?>/configuracao/testar-email', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Email de teste enviado com sucesso!');
            } else {
                alert('Erro ao enviar email: ' + data.message);
            }
        })
        .catch(error => {
            alert('Erro: ' + error.message);
        });
    }
}

function verificarAtualizacoes() {
    alert('Verificação de atualizações em desenvolvimento. Mantenha-se atualizado através do repositório oficial.');
}

function limparCache() {
    if (confirm('Deseja limpar o cache do sistema? Esta ação pode afetar temporariamente a performance.')) {
        fetch('<?php echo BASE_URL; ?>/configuracao/limpar-cache', {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Cache limpo com sucesso!');
                location.reload();
            } else {
                alert('Erro ao limpar cache: ' + data.message);
            }
        })
        .catch(error => {
            alert('Erro: ' + error.message);
        });
    }
}
</script>

