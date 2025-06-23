<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-people"></i>
                Gerenciamento de Usuários
            </h1>
            <div>
                <a href="<?php echo BASE_URL; ?>/configuracao/novousuario" class="btn btn-success me-2">
                    <i class="bi bi-person-plus"></i>
                    Novo Usuário
                </a>
                <a href="<?php echo BASE_URL; ?>/configuracao" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Voltar
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Filtros e busca -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label for="busca" class="form-label">Buscar Usuário</label>
                        <input type="text" class="form-control" id="busca" name="busca" 
                               value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>" 
                               placeholder="Nome, email ou usuário...">
                    </div>
                    <div class="col-md-3">
                        <label for="nivel" class="form-label">Nível de Acesso</label>
                        <select class="form-select" id="nivel" name="nivel">
                            <option value="">Todos os níveis</option>
                            <option value="admin" <?= ($_GET['nivel'] ?? '') === 'admin' ? 'selected' : '' ?>>Administrador</option>
                            <option value="gerente" <?= ($_GET['nivel'] ?? '') === 'gerente' ? 'selected' : '' ?>>Gerente</option>
                            <option value="vendedor" <?= ($_GET['nivel'] ?? '') === 'vendedor' ? 'selected' : '' ?>>Vendedor</option>
                            <option value="estoquista" <?= ($_GET['nivel'] ?? '') === 'estoquista' ? 'selected' : '' ?>>Estoquista</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Todos</option>
                            <option value="ativo" <?= ($_GET['status'] ?? '') === 'ativo' ? 'selected' : '' ?>>Ativo</option>
                            <option value="inativo" <?= ($_GET['status'] ?? '') === 'inativo' ? 'selected' : '' ?>>Inativo</option>
                            <option value="bloqueado" <?= ($_GET['status'] ?? '') === 'bloqueado' ? 'selected' : '' ?>>Bloqueado</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-search"></i>
                            Buscar
                        </button>
                        <a href="<?php echo BASE_URL; ?>/configuracao/usuarios" class="btn btn-outline-secondary">
                            <i class="bi bi-x"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Estatísticas rápidas -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-primary">
            <div class="card-body text-center">
                <h4 class="text-primary"><?= count($usuarios) ?></h4>
                <p class="card-text">Total de Usuários</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-success">
            <div class="card-body text-center">
                <h4 class="text-success"><?= $estatisticas['ativos'] ?? '0' ?></h4>
                <p class="card-text">Usuários Ativos</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-warning">
            <div class="card-body text-center">
                <h4 class="text-warning"><?= $estatisticas['online'] ?? '0' ?></h4>
                <p class="card-text">Online Agora</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-info">
            <div class="card-body text-center">
                <h4 class="text-info"><?= $estatisticas['novos_mes'] ?? '0' ?></h4>
                <p class="card-text">Novos este Mês</p>
            </div>
        </div>
    </div>
</div>

<!-- Lista de usuários -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0">
                    <i class="bi bi-list"></i>
                    Lista de Usuários (<?= count($usuarios) ?>)
                </h6>
                <div class="btn-group btn-group-sm" role="group">
                    <button class="btn btn-outline-success" onclick="exportarUsuarios()">
                        <i class="bi bi-download"></i>
                        Exportar
                    </button>
                    <button class="btn btn-outline-info" onclick="enviarConvites()">
                        <i class="bi bi-envelope"></i>
                        Enviar Convites
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <?php if (empty($usuarios)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-people display-1 text-muted"></i>
                        <h5 class="mt-3">Nenhum usuário encontrado</h5>
                        <p class="text-muted">Crie o primeiro usuário para começar.</p>
                        <a href="<?php echo BASE_URL; ?>/configuracao/novousuario" class="btn btn-primary">
                            <i class="bi bi-person-plus"></i>
                            Criar Primeiro Usuário
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th width="60">
                                        <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                    </th>
                                    <th>Usuário</th>
                                    <th width="120">Nível</th>
                                    <th width="100">Status</th>
                                    <th width="150">Último Acesso</th>
                                    <th width="120">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="user-checkbox" value="<?= $usuario['id'] ?>">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar me-3">
                                                    <?php if (!empty($usuario['avatar'])): ?>
                                                        <img src="<?= htmlspecialchars($usuario['avatar']) ?>" 
                                                             alt="Avatar" class="rounded-circle" width="40" height="40">
                                                    <?php else: ?>
                                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                                             style="width: 40px; height: 40px;">
                                                            <?= strtoupper(substr($usuario['nome'], 0, 1)) ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div>
                                                    <strong><?= htmlspecialchars($usuario['nome']) ?></strong>
                                                    <br>
                                                    <small class="text-muted">
                                                        <i class="bi bi-envelope"></i>
                                                        <?= htmlspecialchars($usuario['email']) ?>
                                                    </small>
                                                    <br>
                                                    <small class="text-muted">
                                                        <i class="bi bi-person"></i>
                                                        <?= htmlspecialchars($usuario['usuario']) ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
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
                                            <span class="badge bg-<?= $nivel_cores[$usuario['nivel']] ?? 'secondary' ?>">
                                                <?= $nivel_nomes[$usuario['nivel']] ?? $usuario['nivel'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php
                                            $status_cores = [
                                                'ativo' => 'success',
                                                'inativo' => 'secondary',
                                                'bloqueado' => 'danger'
                                            ];
                                            $status_icones = [
                                                'ativo' => 'check-circle',
                                                'inativo' => 'pause-circle',
                                                'bloqueado' => 'x-circle'
                                            ];
                                            ?>
                                            <span class="badge bg-<?= $status_cores[$usuario['status'] ?? ''] ?? 'secondary' ?>">
                                                <i class="bi bi-<?= $status_icones[$usuario['status'] ?? ''] ?? 'question-circle' ?>"></i>
                                                <?= ucfirst($usuario['status'] ?? '') ?>
                                            </span>
                                            
                                            <?php if ($usuario['online'] ?? ''): ?>
                                                <br>
                                                <small class="text-success">
                                                    <i class="bi bi-circle-fill" style="font-size: 8px;"></i>
                                                    Online
                                                </small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($usuario['ultimo_acesso'])): ?>
                                                <div>
                                                    <strong><?= date('d/m/Y', strtotime($usuario['ultimo_acesso'])) ?></strong>
                                                    <br>
                                                    <small class="text-muted">
                                                        <?= date('H:i', strtotime($usuario['ultimo_acesso'])) ?>
                                                    </small>
                                                </div>
                                            <?php else: ?>
                                                <small class="text-muted">Nunca acessou</small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="<?php echo BASE_URL; ?>/configuracao/editarusuario/<?= $usuario['id'] ?>" 
                                                   class="btn btn-outline-primary" 
                                                   data-bs-toggle="tooltip" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                
                                                <?php if ($usuario['status'] ?? '' === 'ativo'): ?>
                                                    <button class="btn btn-outline-warning" 
                                                            onclick="alterarStatus(<?= $usuario['id'] ?>, 'inativo')"
                                                            data-bs-toggle="tooltip" title="Desativar">
                                                        <i class="bi bi-pause"></i>
                                                    </button>
                                                <?php else: ?>
                                                    <button class="btn btn-outline-success" 
                                                            onclick="alterarStatus(<?= $usuario['id'] ?>, 'ativo')"
                                                            data-bs-toggle="tooltip" title="Ativar">
                                                        <i class="bi bi-play"></i>
                                                    </button>
                                                <?php endif; ?>
                                                
                                                <button class="btn btn-outline-info" 
                                                        onclick="resetarSenha(<?= $usuario['id'] ?>)"
                                                        data-bs-toggle="tooltip" title="Resetar Senha">
                                                    <i class="bi bi-key"></i>
                                                </button>
                                                
                                                <?php if ($usuario['id'] != $_SESSION['user_id']): ?>
                                                    <button class="btn btn-outline-danger" 
                                                            onclick="excluirUsuario(<?= $usuario['id'] ?>)"
                                                            data-bs-toggle="tooltip" title="Excluir">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Ações em lote -->
<?php if (!empty($usuarios)): ?>
<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Ações em Lote:</strong>
                        <span id="selectedCount" class="text-muted">0 usuários selecionados</span>
                    </div>
                    <div id="batchActions" style="display: none;">
                        <button class="btn btn-outline-success btn-sm me-2" onclick="ativarSelecionados()">
                            <i class="bi bi-check-circle"></i>
                            Ativar
                        </button>
                        <button class="btn btn-outline-warning btn-sm me-2" onclick="desativarSelecionados()">
                            <i class="bi bi-pause-circle"></i>
                            Desativar
                        </button>
                        <button class="btn btn-outline-info btn-sm me-2" onclick="enviarEmailSelecionados()">
                            <i class="bi bi-envelope"></i>
                            Enviar Email
                        </button>
                        <button class="btn btn-outline-danger btn-sm" onclick="excluirSelecionados()">
                            <i class="bi bi-trash"></i>
                            Excluir
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
// Gerenciar seleção de usuários
function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.user-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
    
    updateSelectedCount();
}

function updateSelectedCount() {
    const checkboxes = document.querySelectorAll('.user-checkbox:checked');
    const count = checkboxes.length;
    
    document.getElementById('selectedCount').textContent = count + ' usuários selecionados';
    document.getElementById('batchActions').style.display = count > 0 ? 'block' : 'none';
}

// Adicionar listeners aos checkboxes
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.user-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedCount);
    });
    
    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

function alterarStatus(userId, novoStatus) {
    const acao = novoStatus === 'ativo' ? 'ativar' : 'desativar';
    
    if (confirm(`Deseja ${acao} este usuário?`)) {
        fetch('<?php echo BASE_URL; ?>/configuracao/alterarstatususuario', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ 
                user_id: userId, 
                status: novoStatus 
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erro ao alterar status: ' + data.message);
            }
        })
        .catch(error => {
            alert('Erro: ' + error.message);
        });
    }
}

function resetarSenha(userId) {
    if (confirm('Deseja resetar a senha deste usuário? Uma nova senha será enviada por email.')) {
        fetch('<?php echo BASE_URL; ?>/configuracao/resetarsenhausuario', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ user_id: userId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Nova senha enviada por email com sucesso!');
            } else {
                alert('Erro ao resetar senha: ' + data.message);
            }
        })
        .catch(error => {
            alert('Erro: ' + error.message);
        });
    }
}

function excluirUsuario(userId) {
    if (confirm('ATENÇÃO: Deseja excluir este usuário? Esta ação não pode ser desfeita.')) {
        if (confirm('Tem certeza absoluta? Todos os dados do usuário serão perdidos!')) {
            fetch('<?php echo BASE_URL; ?>/configuracao/excluirusuario', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ user_id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Erro ao excluir usuário: ' + data.message);
                }
            })
            .catch(error => {
                alert('Erro: ' + error.message);
            });
        }
    }
}

function getSelectedUsers() {
    const checkboxes = document.querySelectorAll('.user-checkbox:checked');
    return Array.from(checkboxes).map(cb => parseInt(cb.value));
}

function ativarSelecionados() {
    const userIds = getSelectedUsers();
    if (userIds.length === 0) {
        alert('Selecione pelo menos um usuário.');
        return;
    }
    
    if (confirm(`Deseja ativar ${userIds.length} usuários selecionados?`)) {
        executarAcaoLote('ativar', userIds);
    }
}

function desativarSelecionados() {
    const userIds = getSelectedUsers();
    if (userIds.length === 0) {
        alert('Selecione pelo menos um usuário.');
        return;
    }
    
    if (confirm(`Deseja desativar ${userIds.length} usuários selecionados?`)) {
        executarAcaoLote('desativar', userIds);
    }
}

function excluirSelecionados() {
    const userIds = getSelectedUsers();
    if (userIds.length === 0) {
        alert('Selecione pelo menos um usuário.');
        return;
    }
    
    if (confirm(`ATENÇÃO: Deseja excluir ${userIds.length} usuários selecionados? Esta ação não pode ser desfeita.`)) {
        if (confirm('Tem certeza absoluta? Todos os dados dos usuários serão perdidos!')) {
            executarAcaoLote('excluir', userIds);
        }
    }
}

function executarAcaoLote(acao, userIds) {
    fetch('<?php echo BASE_URL; ?>/configuracao/acaoloteusuarios', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ 
            acao: acao,
            user_ids: userIds 
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(`Ação "${acao}" executada com sucesso em ${userIds.length} usuários!`);
            location.reload();
        } else {
            alert('Erro ao executar ação: ' + data.message);
        }
    })
    .catch(error => {
        alert('Erro: ' + error.message);
    });
}

function exportarUsuarios() {
    window.open('<?php echo BASE_URL; ?>/configuracao/exportar-usuarios?formato=csv', '_blank');
}

function enviarConvites() {
    const userIds = getSelectedUsers();
    if (userIds.length === 0) {
        alert('Selecione os usuários para enviar convites.');
        return;
    }
    
    if (confirm(`Deseja enviar convites por email para ${userIds.length} usuários?`)) {
        fetch('<?php echo BASE_URL; ?>/configuracao/enviarconvites', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ user_ids: userIds })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Convites enviados com sucesso!');
            } else {
                alert('Erro ao enviar convites: ' + data.message);
            }
        })
        .catch(error => {
            alert('Erro: ' + error.message);
        });
    }
}

function enviarEmailSelecionados() {
    const userIds = getSelectedUsers();
    if (userIds.length === 0) {
        alert('Selecione os usuários para enviar email.');
        return;
    }
    
    const assunto = prompt('Digite o assunto do email:');
    if (!assunto) return;
    
    const mensagem = prompt('Digite a mensagem:');
    if (!mensagem) return;
    
    fetch('<?php echo BASE_URL; ?>/configuracao/enviaremailusuarios', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ 
            user_ids: userIds,
            assunto: assunto,
            mensagem: mensagem
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Emails enviados com sucesso!');
        } else {
            alert('Erro ao enviar emails: ' + data.message);
        }
    })
    .catch(error => {
        alert('Erro: ' + error.message);
    });
}
</script>

