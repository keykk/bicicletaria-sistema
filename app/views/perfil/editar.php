<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-pencil-square"></i>
                Editar Perfil
            </h1>
            <a href="/perfil" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
                Voltar
            </a>
        </div>
    </div>
</div>

<form method="POST" action="/perfil/atualizar" enctype="multipart/form-data" id="formPerfil">
    <div class="row">
        <!-- Informações Pessoais -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-person"></i>
                        Informações Pessoais
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="nome" class="form-label">Nome Completo *</label>
                            <input type="text" class="form-control" id="nome" name="nome" 
                                   value="<?= htmlspecialchars($usuario['nome']) ?>" required>
                            <div class="invalid-feedback">
                                Por favor, informe seu nome completo.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" 
                                   value="<?= htmlspecialchars($usuario['cpf'] ?? '') ?>"
                                   placeholder="000.000.000-00">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?= htmlspecialchars($usuario['email']) ?>" required>
                            <div class="form-text">Será usado para login e notificações</div>
                            <div class="invalid-feedback">
                                Por favor, informe um email válido.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="tel" class="form-control" id="telefone" name="telefone" 
                                   value="<?= htmlspecialchars($usuario['telefone'] ?? '') ?>"
                                   placeholder="(11) 99999-9999">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="endereco" class="form-label">Endereço</label>
                        <textarea class="form-control" id="endereco" name="endereco" 
                                  rows="3" placeholder="Rua, número, bairro, cidade, CEP..."><?= htmlspecialchars($usuario['endereco'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>
            
            <!-- Informações do Sistema -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-gear"></i>
                        Informações do Sistema
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="usuario" class="form-label">Nome de Usuário</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" 
                                   value="<?= htmlspecialchars($usuario['usuario']) ?>" readonly>
                            <div class="form-text">Nome de usuário não pode ser alterado</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nivel" class="form-label">Nível de Acesso</label>
                            <input type="text" class="form-control" id="nivel" 
                                   value="<?php
                                   $nivel_nomes = [
                                       'admin' => 'Administrador',
                                       'gerente' => 'Gerente', 
                                       'vendedor' => 'Vendedor',
                                       'estoquista' => 'Estoquista'
                                   ];
                                   echo $nivel_nomes[$usuario['nivel']] ?? $usuario['nivel'];
                                   ?>" readonly>
                            <div class="form-text">Nível de acesso definido pelo administrador</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="data_criacao" class="form-label">Cadastrado em</label>
                            <input type="text" class="form-control" 
                                   value="<?= date('d/m/Y H:i', strtotime($usuario['data_criacao'])) ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="ultimo_acesso" class="form-label">Último Acesso</label>
                            <input type="text" class="form-control" 
                                   value="<?= $usuario['ultimo_acesso'] ? date('d/m/Y H:i', strtotime($usuario['ultimo_acesso'])) : 'Primeiro acesso' ?>" readonly>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Configurações de Privacidade -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-shield-check"></i>
                        Configurações de Privacidade
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="receber_notificacoes" 
                                       name="receber_notificacoes" value="1"
                                       <?= ($usuario['receber_notificacoes'] ?? true) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="receber_notificacoes">
                                    Receber notificações por email
                                </label>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="mostrar_atividades" 
                                       name="mostrar_atividades" value="1"
                                       <?= ($usuario['mostrar_atividades'] ?? true) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="mostrar_atividades">
                                    Registrar minhas atividades no sistema
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i>
                                <strong>Sobre suas configurações:</strong>
                                <br>
                                <small>
                                    • Notificações incluem alertas de sistema e atualizações importantes<br>
                                    • O registro de atividades ajuda no controle e auditoria do sistema
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Avatar e Ações -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-image"></i>
                        Foto do Perfil
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3" id="avatar-preview">
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
                    
                    <div class="mb-3">
                        <input type="file" class="form-control" id="avatar" name="avatar" 
                               accept="image/*" onchange="previewAvatar(this)">
                        <div class="form-text">JPG, PNG ou GIF (máx. 2MB)</div>
                    </div>
                    
                    <?php if (!empty($usuario['avatar'])): ?>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removerAvatar()">
                            <i class="bi bi-trash"></i>
                            Remover Foto
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Ações de Segurança -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-shield-lock"></i>
                        Segurança
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="/perfil/alterar-senha" class="btn btn-outline-warning">
                            <i class="bi bi-key"></i>
                            Alterar Senha
                        </a>
                        
                        <button type="button" class="btn btn-outline-info" onclick="baixarDados()">
                            <i class="bi bi-download"></i>
                            Baixar Meus Dados
                        </button>
                        
                        <button type="button" class="btn btn-outline-secondary" onclick="verAtividades()">
                            <i class="bi bi-activity"></i>
                            Ver Atividades
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Informações Adicionais -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-info-circle"></i>
                        Informações
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <strong>Total de logins:</strong>
                        <br>
                        <small class="text-muted"><?= number_format($usuario['total_logins'] ?? 0, 0, ',', '.') ?> vezes</small>
                    </div>
                    
                    <div class="mb-2">
                        <strong>Último IP:</strong>
                        <br>
                        <small class="text-muted"><?= htmlspecialchars($usuario['ultimo_ip'] ?? 'N/A') ?></small>
                    </div>
                    
                    <div>
                        <strong>Status:</strong>
                        <br>
                        <?php
                        $status_cores = [
                            'ativo' => 'success',
                            'inativo' => 'secondary',
                            'bloqueado' => 'danger'
                        ];
                        ?>
                        <span class="badge bg-<?= $status_cores[$usuario['status']] ?? 'secondary' ?>">
                            <?= ucfirst($usuario['status']) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Botões de ação -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="button" class="btn btn-outline-danger" onclick="confirmarExclusao()">
                                <i class="bi bi-exclamation-triangle"></i>
                                Excluir Minha Conta
                            </button>
                        </div>
                        <div>
                            <a href="/perfil" class="btn btn-outline-secondary me-2">
                                <i class="bi bi-x"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i>
                                Salvar Alterações
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
// Máscara para CPF
document.getElementById('cpf').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    e.target.value = value;
});

// Máscara para telefone
document.getElementById('telefone').addEventListener('input', function(e) {
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

// Preview do avatar
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const preview = document.getElementById('avatar-preview');
            preview.innerHTML = `
                <img src="${e.target.result}" alt="Preview" 
                     class="img-fluid rounded-circle" style="max-width: 150px; max-height: 150px;">
            `;
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Remover avatar
function removerAvatar() {
    if (confirm('Deseja remover sua foto de perfil?')) {
        fetch('/perfil/remover-avatar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erro ao remover foto: ' + data.message);
            }
        })
        .catch(error => {
            alert('Erro: ' + error.message);
        });
    }
}

// Validação do formulário
document.getElementById('formPerfil').addEventListener('submit', function(e) {
    const nome = document.getElementById('nome').value.trim();
    const email = document.getElementById('email').value.trim();
    
    if (!nome) {
        e.preventDefault();
        document.getElementById('nome').classList.add('is-invalid');
        document.getElementById('nome').focus();
        return false;
    }
    
    if (!email) {
        e.preventDefault();
        document.getElementById('email').classList.add('is-invalid');
        document.getElementById('email').focus();
        return false;
    }
    
    // Validar email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        e.preventDefault();
        document.getElementById('email').classList.add('is-invalid');
        document.getElementById('email').focus();
        return false;
    }
    
    // Remover classes de erro se tudo estiver ok
    document.getElementById('nome').classList.remove('is-invalid');
    document.getElementById('email').classList.remove('is-invalid');
});

// Remover classes de erro ao digitar
document.getElementById('nome').addEventListener('input', function() {
    this.classList.remove('is-invalid');
});

document.getElementById('email').addEventListener('input', function() {
    this.classList.remove('is-invalid');
});

// Funções auxiliares
function baixarDados() {
    if (confirm('Deseja baixar uma cópia dos seus dados pessoais?')) {
        window.open('/perfil/baixar-dados', '_blank');
    }
}

function verAtividades() {
    window.location.href = '/perfil/atividades';
}

function confirmarExclusao() {
    if (confirm('ATENÇÃO: Deseja excluir sua conta? Esta ação não pode ser desfeita e você perderá acesso ao sistema.')) {
        if (confirm('Tem certeza absoluta? Todos os seus dados serão removidos permanentemente!')) {
            const senha = prompt('Digite sua senha para confirmar a exclusão:');
            if (senha) {
                fetch('/perfil/excluir-conta', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ senha: senha })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Conta excluída com sucesso. Você será redirecionado para a página de login.');
                        window.location.href = '/login';
                    } else {
                        alert('Erro ao excluir conta: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('Erro: ' + error.message);
                });
            }
        }
    }
}
</script>

