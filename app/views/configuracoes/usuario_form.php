<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-person-<?= isset($usuario) ? 'gear' : 'plus' ?>"></i>
                <?= isset($usuario) ? 'Editar Usuário' : 'Novo Usuário' ?>
            </h1>
            <a href="/configuracao/usuarios" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
                Voltar
            </a>
        </div>
    </div>
</div>

<form method="POST" action="/configuracao/<?= isset($usuario) ? 'atualizarusuario/' . $usuario['id'] : 'criar-usuario' ?>" enctype="multipart/form-data">
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
                                   value="<?= htmlspecialchars($usuario['nome'] ?? '') ?>" required>
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
                                   value="<?= htmlspecialchars($usuario['email'] ?? '') ?>" required>
                            <div class="form-text">Será usado para login e notificações</div>
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
                                  rows="2"><?= htmlspecialchars($usuario['endereco'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>
            
            <!-- Dados de Acesso -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-key"></i>
                        Dados de Acesso
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="usuario" class="form-label">Nome de Usuário *</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" 
                                   value="<?= htmlspecialchars($usuario['usuario'] ?? '') ?>" 
                                   <?= isset($usuario) ? 'readonly' : '' ?> required>
                            <div class="form-text">
                                <?= isset($usuario) ? 'Nome de usuário não pode ser alterado' : 'Usado para fazer login no sistema' ?>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nivel" class="form-label">Nível de Acesso *</label>
                            <select class="form-select" id="nivel" name="nivel" required>
                                <option value="">Selecione o nível</option>
                                <option value="admin" <?= ($usuario['nivel'] ?? '') === 'admin' ? 'selected' : '' ?>>
                                    Administrador - Acesso total
                                </option>
                                <option value="gerente" <?= ($usuario['nivel'] ?? '') === 'gerente' ? 'selected' : '' ?>>
                                    Gerente - Relatórios e configurações
                                </option>
                                <option value="vendedor" <?= ($usuario['nivel'] ?? '') === 'vendedor' ? 'selected' : '' ?>>
                                    Vendedor - Orçamentos e produtos
                                </option>
                                <option value="estoquista" <?= ($usuario['nivel'] ?? '') === 'estoquista' ? 'selected' : '' ?>>
                                    Estoquista - Apenas estoque
                                </option>
                            </select>
                        </div>
                    </div>
                    
                    <?php if (!isset($usuario)): ?>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="senha" class="form-label">Senha *</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="senha" name="senha" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('senha')">
                                        <i class="bi bi-eye" id="senha-icon"></i>
                                    </button>
                                </div>
                                <div class="form-text">Mínimo 6 caracteres</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="confirmar_senha" class="form-label">Confirmar Senha *</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirmar_senha')">
                                        <i class="bi bi-eye" id="confirmar_senha-icon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i>
                            Para alterar a senha, use o botão "Resetar Senha" na lista de usuários.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Permissões Específicas -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-shield-check"></i>
                        Permissões Específicas
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Módulos</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="perm_produtos" name="permissoes[]" 
                                       value="produtos" <?= in_array('produtos', $usuario['permissoes'] ?? []) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="perm_produtos">
                                    Gerenciar Produtos
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="perm_estoque" name="permissoes[]" 
                                       value="estoque" <?= in_array('estoque', $usuario['permissoes'] ?? []) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="perm_estoque">
                                    Gerenciar Estoque
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="perm_orcamentos" name="permissoes[]" 
                                       value="orcamentos" <?= in_array('orcamentos', $usuario['permissoes'] ?? []) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="perm_orcamentos">
                                    Criar Orçamentos
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="perm_tabelas_preco" name="permissoes[]" 
                                       value="tabelas_preco" <?= in_array('tabelas_preco', $usuario['permissoes'] ?? []) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="perm_tabelas_preco">
                                    Gerenciar Tabelas de Preço
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6>Relatórios e Configurações</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="perm_relatorios" name="permissoes[]" 
                                       value="relatorios" <?= in_array('relatorios', $usuario['permissoes'] ?? []) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="perm_relatorios">
                                    Visualizar Relatórios
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="perm_configuracoes" name="permissoes[]" 
                                       value="configuracoes" <?= in_array('configuracoes', $usuario['permissoes'] ?? []) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="perm_configuracoes">
                                    Acessar Configurações
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="perm_usuarios" name="permissoes[]" 
                                       value="usuarios" <?= in_array('usuarios', $usuario['permissoes'] ?? []) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="perm_usuarios">
                                    Gerenciar Usuários
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="perm_backup" name="permissoes[]" 
                                       value="backup" <?= in_array('backup', $usuario['permissoes'] ?? []) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="perm_backup">
                                    Gerenciar Backup
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-12">
                            <h6>Ações Especiais</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="perm_excluir" name="permissoes[]" 
                                               value="excluir" <?= in_array('excluir', $usuario['permissoes'] ?? []) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="perm_excluir">
                                            Excluir Registros
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="perm_exportar" name="permissoes[]" 
                                               value="exportar" <?= in_array('exportar', $usuario['permissoes'] ?? []) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="perm_exportar">
                                            Exportar Dados
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="perm_importar" name="permissoes[]" 
                                               value="importar" <?= in_array('importar', $usuario['permissoes'] ?? []) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="perm_importar">
                                            Importar Dados
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Avatar e Status -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-image"></i>
                        Avatar do Usuário
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <?php if (!empty($usuario['avatar'])): ?>
                            <img src="<?= htmlspecialchars($usuario['avatar']) ?>" 
                                 alt="Avatar" class="img-fluid rounded-circle" style="max-width: 150px; max-height: 150px;">
                        <?php else: ?>
                            <div class="bg-primary text-white rounded-circle mx-auto d-flex align-items-center justify-content-center" 
                                 style="width: 150px; height: 150px; font-size: 3rem;">
                                <?= strtoupper(substr($usuario['nome'] ?? 'U', 0, 1)) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                        <div class="form-text">JPG, PNG ou GIF (máx. 2MB)</div>
                    </div>
                    
                    <?php if (!empty($usuario['avatar'])): ?>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removerAvatar()">
                            <i class="bi bi-trash"></i>
                            Remover Avatar
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Status e Configurações -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-gear"></i>
                        Status e Configurações
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="ativo" <?= ($usuario['status'] ?? 'ativo') === 'ativo' ? 'selected' : '' ?>>
                                Ativo
                            </option>
                            <option value="inativo" <?= ($usuario['status'] ?? '') === 'inativo' ? 'selected' : '' ?>>
                                Inativo
                            </option>
                            <option value="bloqueado" <?= ($usuario['status'] ?? '') === 'bloqueado' ? 'selected' : '' ?>>
                                Bloqueado
                            </option>
                        </select>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="enviar_email_boas_vindas" 
                               name="enviar_email_boas_vindas" <?= !isset($usuario) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="enviar_email_boas_vindas">
                            Enviar email de boas-vindas
                        </label>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="forcar_troca_senha" 
                               name="forcar_troca_senha" <?= ($usuario['forcar_troca_senha'] ?? false) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="forcar_troca_senha">
                            Forçar troca de senha no próximo login
                        </label>
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="receber_notificacoes" 
                               name="receber_notificacoes" <?= ($usuario['receber_notificacoes'] ?? true) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="receber_notificacoes">
                            Receber notificações por email
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Informações Adicionais -->
            <?php if (isset($usuario)): ?>
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="bi bi-info-circle"></i>
                            Informações Adicionais
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <strong>Criado em:</strong>
                            <br>
                            <small class="text-muted">
                                <?= date('d/m/Y H:i', strtotime($usuario['data_criacao'])) ?>
                            </small>
                        </div>
                        
                        <div class="mb-2">
                            <strong>Último acesso:</strong>
                            <br>
                            <small class="text-muted">
                                <?= $usuario['ultimo_acesso'] ? date('d/m/Y H:i', strtotime($usuario['ultimo_acesso'])) : 'Nunca acessou' ?>
                            </small>
                        </div>
                        
                        <div class="mb-2">
                            <strong>Total de logins:</strong>
                            <br>
                            <small class="text-muted"><?= $usuario['total_logins'] ?? 0 ?> vezes</small>
                        </div>
                        
                        <div>
                            <strong>IP do último acesso:</strong>
                            <br>
                            <small class="text-muted"><?= $usuario['ultimo_ip'] ?? 'N/A' ?></small>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Botões de ação -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <?php if (isset($usuario)): ?>
                                <button type="button" class="btn btn-outline-warning" onclick="resetarSenhaUsuario()">
                                    <i class="bi bi-key"></i>
                                    Resetar Senha
                                </button>
                            <?php endif; ?>
                        </div>
                        <div>
                            <a href="/configuracao/usuarios" class="btn btn-outline-secondary me-2">
                                <i class="bi bi-x"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i>
                                <?= isset($usuario) ? 'Atualizar Usuário' : 'Criar Usuário' ?>
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

// Gerar nome de usuário automaticamente
document.getElementById('nome').addEventListener('input', function() {
    if (!document.getElementById('usuario').readOnly) {
        const nome = this.value.toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z\s]/g, '')
            .split(' ')
            .filter(word => word.length > 0)
            .slice(0, 2)
            .join('.');
        
        document.getElementById('usuario').value = nome;
    }
});

// Mostrar/ocultar senha
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        field.type = 'password';
        icon.className = 'bi bi-eye';
    }
}

// Configurar permissões por nível
document.getElementById('nivel').addEventListener('change', function() {
    const nivel = this.value;
    const checkboxes = document.querySelectorAll('input[name="permissoes[]"]');
    
    // Limpar todas as permissões
    checkboxes.forEach(cb => cb.checked = false);
    
    // Configurar permissões por nível
    const permissoesPorNivel = {
        'admin': ['produtos', 'estoque', 'orcamentos', 'tabelas_preco', 'relatorios', 'configuracoes', 'usuarios', 'backup', 'excluir', 'exportar', 'importar'],
        'gerente': ['produtos', 'estoque', 'orcamentos', 'tabelas_preco', 'relatorios', 'configuracoes', 'exportar'],
        'vendedor': ['produtos', 'orcamentos', 'tabelas_preco', 'exportar'],
        'estoquista': ['produtos', 'estoque']
    };
    
    if (permissoesPorNivel[nivel]) {
        permissoesPorNivel[nivel].forEach(perm => {
            const checkbox = document.getElementById('perm_' + perm);
            if (checkbox) checkbox.checked = true;
        });
    }
});

// Validação do formulário
document.querySelector('form').addEventListener('submit', function(e) {
    const nome = document.getElementById('nome').value.trim();
    const email = document.getElementById('email').value.trim();
    const usuario = document.getElementById('usuario').value.trim();
    const nivel = document.getElementById('nivel').value;
    
    if (!nome || !email || !usuario || !nivel) {
        e.preventDefault();
        alert('Por favor, preencha todos os campos obrigatórios.');
        return false;
    }
    
    // Validar email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        e.preventDefault();
        alert('Por favor, insira um email válido.');
        return false;
    }
    
    <?php if (!isset($usuario)): ?>
    // Validar senhas (apenas para novo usuário)
    const senha = document.getElementById('senha').value;
    const confirmarSenha = document.getElementById('confirmar_senha').value;
    
    if (senha.length < 6) {
        e.preventDefault();
        alert('A senha deve ter pelo menos 6 caracteres.');
        return false;
    }
    
    if (senha !== confirmarSenha) {
        e.preventDefault();
        alert('As senhas não coincidem.');
        return false;
    }
    <?php endif; ?>
});

<?php if (isset($usuario)): ?>
function resetarSenhaUsuario() {
    if (confirm('Deseja resetar a senha deste usuário? Uma nova senha será enviada por email.')) {
        fetch('/configuracao/resetar-senha-usuario', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ user_id: <?= $usuario['id'] ?> })
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

function removerAvatar() {
    if (confirm('Deseja remover o avatar atual?')) {
        fetch('/configuracao/remover-avatar-usuario', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ user_id: <?= $usuario['id'] ?> })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erro ao remover avatar: ' + data.message);
            }
        });
    }
}
<?php endif; ?>
</script>

