<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-person-circle"></i>
                Meu Perfil
            </h1>
            <div>
                <a href="<?php echo BASE_URL; ?>/perfil/editar" class="btn btn-primary me-2">
                    <i class="bi bi-pencil"></i>
                    Editar Perfil
                </a>
                <a href="<?php echo BASE_URL; ?>/dashboard" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Voltar
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Informações do Usuário -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="mb-3">
                    <?php if (!empty($usuario['avatar'])): ?>
                        <img src="<?= htmlspecialchars($usuario['avatar']) ?>" 
                             alt="Avatar" class="img-fluid rounded-circle" style="max-width: 150px; max-height: 150px;">
                    <?php else: ?>
                        <div class="bg-primary text-white rounded-circle mx-auto d-flex align-items-center justify-content-center" 
                             style="width: 150px; height: 150px; font-size: 3rem;">
                            <?= strtoupper(substr($usuario['nome'], 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <h4 class="card-title"><?= htmlspecialchars($usuario['nome']) ?></h4>
                <p class="text-muted mb-2">
                    <i class="bi bi-envelope"></i>
                    <?= htmlspecialchars($usuario['email']) ?>
                </p>
                
                <?php if (!empty($usuario['telefone'])): ?>
                    <p class="text-muted mb-2">
                        <i class="bi bi-telephone"></i>
                        <?= htmlspecialchars($usuario['telefone']) ?>
                    </p>
                <?php endif; ?>
                
                <div class="mt-3">
                    <?php
                    $nivel_cores = [
                        'admin' => 'danger',
                        'gerente' => 'warning',
                        'vendedor' => 'primary',
                        'estoquista' => 'info'
                    ];
                    $nivel_nomes = [
                        'admin' => 'Administrador',
                        'gerente' => 'Gerente',
                        'vendedor' => 'Vendedor',
                        'estoquista' => 'Estoquista'
                    ];
                    ?>
                    <span class="badge bg-<?= $nivel_cores[$usuario['nivel']] ?? 'secondary' ?> fs-6">
                        <?= $nivel_nomes[$usuario['nivel']] ?? $usuario['nivel'] ?>
                    </span>
                </div>
                
                <div class="mt-3">
                    <?php
                    $status_cores = [
                        'ativo' => 'success',
                        'inativo' => 'secondary',
                        'bloqueado' => 'danger'
                    ];
                    ?>
                    <span class="badge bg-<?= $status_cores[$usuario['status']] ?? 'secondary' ?>">
                        <i class="bi bi-circle-fill" style="font-size: 8px;"></i>
                        <?= ucfirst($usuario['status']) ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-info-circle"></i>
                    Informações Pessoais
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Nome Completo:</strong></td>
                                <td><?= htmlspecialchars($usuario['nome']) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td><?= htmlspecialchars($usuario['email']) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Telefone:</strong></td>
                                <td><?= !empty($usuario['telefone']) ? htmlspecialchars($usuario['telefone']) : '<span class="text-muted">Não informado</span>' ?></td>
                            </tr>
                            <tr>
                                <td><strong>CPF:</strong></td>
                                <td><?= !empty($usuario['cpf']) ? htmlspecialchars($usuario['cpf']) : '<span class="text-muted">Não informado</span>' ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Usuário:</strong></td>
                                <td><?= htmlspecialchars($usuario['nome_usuario']) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Nível de Acesso:</strong></td>
                                <td><?= $nivel_nomes[$usuario['nivel_acesso']] ?? $usuario['nivel_acesso'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Cadastrado em:</strong></td>
                                <td><?= date('d/m/Y H:i', strtotime($usuario['dths_cadastro'])) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Último Acesso:</strong></td>
                                <td>
                                    <?php if ($usuario['ultimo_acesso']): ?>
                                        <?= date('d/m/Y H:i', strtotime($usuario['ultimo_acesso'])) ?>
                                    <?php else: ?>
                                        <span class="text-muted">Primeiro acesso</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <?php if (!empty($usuario['endereco'])): ?>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <strong>Endereço:</strong>
                            <p class="mt-2"><?= nl2br(htmlspecialchars($usuario['endereco'])) ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Estatísticas do Usuário -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-primary">
            <div class="card-body text-center">
                <h3 class="text-primary"><?= number_format($estatisticas['orcamentos_criados'], 0, ',', '.') ?></h3>
                <p class="card-text">Orçamentos Criados</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-success">
            <div class="card-body text-center">
                <h3 class="text-success"><?= number_format($estatisticas['produtos_cadastrados'], 0, ',', '.') ?></h3>
                <p class="card-text">Produtos Cadastrados</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-info">
            <div class="card-body text-center">
                <h3 class="text-info"><?= number_format($estatisticas['total_logins'], 0, ',', '.') ?></h3>
                <p class="card-text">Total de Logins</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-warning">
            <div class="card-body text-center">
                <h3 class="text-warning"><?= number_format($estatisticas['dias_desde_cadastro'], 0, ',', '.') ?></h3>
                <p class="card-text">Dias no Sistema</p>
            </div>
        </div>
    </div>
</div>

<!-- Ações Rápidas -->
<div class="row mb-4">
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
                        <a href="<?php echo BASE_URL; ?>/perfil/editar" class="btn btn-outline-primary w-100">
                            <i class="bi bi-pencil"></i>
                            <br>
                            Editar Perfil
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?php echo BASE_URL; ?>/perfil/alterarsenha" class="btn btn-outline-warning w-100">
                            <i class="bi bi-key"></i>
                            <br>
                            Alterar Senha
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?php echo BASE_URL; ?>/perfil/atividades" class="btn btn-outline-info w-100">
                            <i class="bi bi-activity"></i>
                            <br>
                            Minhas Atividades
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <button class="btn btn-outline-secondary w-100" onclick="baixarDadosPessoais()">
                            <i class="bi bi-download"></i>
                            <br>
                            Baixar Dados
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Atividades Recentes -->
<?php if (!empty($atividades_recentes)): ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0">
                    <i class="bi bi-clock-history"></i>
                    Atividades Recentes
                </h6>
                <a href="/perfil/atividades" class="btn btn-outline-primary btn-sm">
                    Ver Todas
                </a>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <?php foreach (array_slice($atividades_recentes, 0, 5) as $atividade): ?>
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title"><?= htmlspecialchars($atividade['descricao']) ?></h6>
                                <p class="timeline-text text-muted">
                                    <small>
                                        <i class="bi bi-clock"></i>
                                        <?= date('d/m/Y H:i', strtotime($atividade['data_criacao'])) ?>
                                    </small>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Configurações de Privacidade -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-shield-check"></i>
                    Configurações de Privacidade e Segurança
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="receber_notificacoes" 
                                   <?= ($usuario['receber_notificacoes'] ?? true) ? 'checked' : '' ?>
                                   onchange="alterarConfiguracao('receber_notificacoes', this.checked)">
                            <label class="form-check-label" for="receber_notificacoes">
                                Receber notificações por email
                            </label>
                        </div>
                        
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="mostrar_atividades" 
                                   <?= ($usuario['mostrar_atividades'] ?? true) ? 'checked' : '' ?>
                                   onchange="alterarConfiguracao('mostrar_atividades', this.checked)">
                            <label class="form-check-label" for="mostrar_atividades">
                                Registrar minhas atividades
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i>
                            <strong>Dica de Segurança:</strong>
                            <br>
                            Altere sua senha regularmente e mantenha suas informações atualizadas.
                        </div>
                        
                        <div class="text-muted">
                            <small>
                                <i class="bi bi-shield"></i>
                                Último IP de acesso: <?= htmlspecialchars($usuario['ultimo_ip'] ?? 'N/A') ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -35px;
    top: 5px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: #007bff;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #007bff;
}

.timeline::before {
    content: '';
    position: absolute;
    left: -31px;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: #dee2e6;
}

.timeline-title {
    margin-bottom: 5px;
    font-size: 0.9rem;
}

.timeline-text {
    margin-bottom: 0;
    font-size: 0.8rem;
}
</style>

<script>
function alterarConfiguracao(campo, valor) {
    fetch('<?php echo BASE_URL; ?>/perfil/alterar-configuracao', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ 
            campo: campo,
            valor: valor 
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Mostrar feedback visual
            const elemento = document.getElementById(campo);
            elemento.parentElement.classList.add('text-success');
            setTimeout(() => {
                elemento.parentElement.classList.remove('text-success');
            }, 2000);
        } else {
            alert('Erro ao alterar configuração: ' + data.message);
            // Reverter o checkbox
            document.getElementById(campo).checked = !valor;
        }
    })
    .catch(error => {
        alert('Erro: ' + error.message);
        // Reverter o checkbox
        document.getElementById(campo).checked = !valor;
    });
}

function baixarDadosPessoais() {
    if (confirm('Deseja baixar uma cópia dos seus dados pessoais?')) {
        window.open('<?php echo BASE_URL; ?>/perfil/baixar-dados', '_blank');
    }
}

// Atualizar estatísticas a cada 5 minutos
setInterval(function() {
    fetch('<?php echo BASE_URL; ?>/perfil/estatisticas-atualizadas')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Atualizar os números nas estatísticas
                // Implementar se necessário
            }
        })
        .catch(error => {
            console.log('Erro ao atualizar estatísticas:', error);
        });
}, 300000); // 5 minutos
</script>

