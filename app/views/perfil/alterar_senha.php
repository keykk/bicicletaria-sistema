<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-key"></i>
                Alterar Senha
            </h1>
            <a href="/perfil" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
                Voltar
            </a>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-shield-lock"></i>
                    Alteração de Senha
                </h6>
            </div>
            <div class="card-body">
                <!-- Informações de Segurança -->
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i>
                    <strong>Dicas de Segurança:</strong>
                    <ul class="mb-0 mt-2">
                        <li>Use pelo menos 8 caracteres</li>
                        <li>Combine letras maiúsculas e minúsculas</li>
                        <li>Inclua números e símbolos</li>
                        <li>Evite informações pessoais óbvias</li>
                    </ul>
                </div>
                
                <form method="POST" action="/perfil/atualizar-senha" id="formSenha">
                    <div class="mb-3">
                        <label for="senha_atual" class="form-label">Senha Atual *</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="senha_atual" name="senha_atual" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('senha_atual')">
                                <i class="bi bi-eye" id="senha_atual-icon"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback">
                            Por favor, informe sua senha atual.
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="nova_senha" class="form-label">Nova Senha *</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="nova_senha" name="nova_senha" 
                                   required minlength="6" onkeyup="verificarForcaSenha()">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('nova_senha')">
                                <i class="bi bi-eye" id="nova_senha-icon"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback">
                            A nova senha deve ter pelo menos 6 caracteres.
                        </div>
                        
                        <!-- Indicador de força da senha -->
                        <div class="mt-2">
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar" id="forca-senha" role="progressbar" style="width: 0%"></div>
                            </div>
                            <small class="text-muted" id="forca-texto">Digite uma senha</small>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="confirmar_senha" class="form-label">Confirmar Nova Senha *</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" 
                                   required onkeyup="verificarConfirmacao()">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirmar_senha')">
                                <i class="bi bi-eye" id="confirmar_senha-icon"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback">
                            As senhas não coincidem.
                        </div>
                        <div class="valid-feedback">
                            Senhas coincidem!
                        </div>
                    </div>
                    
                    <!-- Opções adicionais -->
                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="deslogar_outros" name="deslogar_outros" checked>
                            <label class="form-check-label" for="deslogar_outros">
                                Deslogar de todos os outros dispositivos
                            </label>
                            <div class="form-text">Recomendado para maior segurança</div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary" id="btnAlterar" disabled>
                            <i class="bi bi-check-circle"></i>
                            Alterar Senha
                        </button>
                        <a href="/perfil" class="btn btn-outline-secondary">
                            <i class="bi bi-x"></i>
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Informações Adicionais -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-shield-check"></i>
                    Informações de Segurança
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Último acesso:</strong>
                    <br>
                    <small class="text-muted">
                        <?= $usuario['ultimo_acesso'] ? date('d/m/Y H:i', strtotime($usuario['ultimo_acesso'])) : 'Primeiro acesso' ?>
                    </small>
                </div>
                
                <div class="mb-3">
                    <strong>IP do último acesso:</strong>
                    <br>
                    <small class="text-muted"><?= htmlspecialchars($usuario['ultimo_ip'] ?? 'N/A') ?></small>
                </div>
                
                <div class="mb-3">
                    <strong>Total de logins:</strong>
                    <br>
                    <small class="text-muted"><?= number_format($usuario['total_logins'] ?? 0, 0, ',', '.') ?> vezes</small>
                </div>
                
                <hr>
                
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>Importante:</strong>
                    <br>
                    <small>
                        Após alterar sua senha, você será deslogado automaticamente e precisará fazer login novamente com a nova senha.
                    </small>
                </div>
            </div>
        </div>
        
        <!-- Histórico de Senhas -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-clock-history"></i>
                    Histórico de Alterações
                </h6>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Senha criada</h6>
                            <p class="timeline-text text-muted">
                                <small>
                                    <i class="bi bi-clock"></i>
                                    <?= date('d/m/Y H:i', strtotime($usuario['data_criacao'])) ?>
                                </small>
                            </p>
                        </div>
                    </div>
                    
                    <?php if (!empty($usuario['ultima_alteracao_senha'])): ?>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-warning"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Última alteração</h6>
                                <p class="timeline-text text-muted">
                                    <small>
                                        <i class="bi bi-clock"></i>
                                        <?= date('d/m/Y H:i', strtotime($usuario['ultima_alteracao_senha'])) ?>
                                    </small>
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="mt-3">
                    <small class="text-muted">
                        <i class="bi bi-info-circle"></i>
                        Recomendamos alterar a senha a cada 90 dias.
                    </small>
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

.progress {
    transition: all 0.3s ease;
}
</style>

<script>
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

// Verificar força da senha
function verificarForcaSenha() {
    const senha = document.getElementById('nova_senha').value;
    const progressBar = document.getElementById('forca-senha');
    const textoForca = document.getElementById('forca-texto');
    
    let forca = 0;
    let texto = '';
    let cor = '';
    
    if (senha.length === 0) {
        forca = 0;
        texto = 'Digite uma senha';
        cor = '';
    } else if (senha.length < 6) {
        forca = 20;
        texto = 'Muito fraca';
        cor = 'bg-danger';
    } else {
        forca = 40;
        texto = 'Fraca';
        cor = 'bg-warning';
        
        // Verificar critérios
        if (senha.length >= 8) forca += 20;
        if (/[a-z]/.test(senha) && /[A-Z]/.test(senha)) forca += 20;
        if (/\d/.test(senha)) forca += 10;
        if (/[^a-zA-Z\d]/.test(senha)) forca += 10;
        
        if (forca >= 80) {
            texto = 'Muito forte';
            cor = 'bg-success';
        } else if (forca >= 60) {
            texto = 'Forte';
            cor = 'bg-info';
        } else if (forca >= 40) {
            texto = 'Média';
            cor = 'bg-warning';
        }
    }
    
    progressBar.style.width = forca + '%';
    progressBar.className = 'progress-bar ' + cor;
    textoForca.textContent = texto;
    
    verificarFormulario();
}

// Verificar confirmação de senha
function verificarConfirmacao() {
    const novaSenha = document.getElementById('nova_senha').value;
    const confirmarSenha = document.getElementById('confirmar_senha').value;
    const campo = document.getElementById('confirmar_senha');
    
    if (confirmarSenha.length === 0) {
        campo.classList.remove('is-valid', 'is-invalid');
    } else if (novaSenha === confirmarSenha) {
        campo.classList.remove('is-invalid');
        campo.classList.add('is-valid');
    } else {
        campo.classList.remove('is-valid');
        campo.classList.add('is-invalid');
    }
    
    verificarFormulario();
}

// Verificar se o formulário pode ser enviado
function verificarFormulario() {
    const senhaAtual = document.getElementById('senha_atual').value;
    const novaSenha = document.getElementById('nova_senha').value;
    const confirmarSenha = document.getElementById('confirmar_senha').value;
    const btnAlterar = document.getElementById('btnAlterar');
    
    const valido = senhaAtual.length > 0 && 
                   novaSenha.length >= 6 && 
                   novaSenha === confirmarSenha;
    
    btnAlterar.disabled = !valido;
}

// Validação do formulário
document.getElementById('formSenha').addEventListener('submit', function(e) {
    const senhaAtual = document.getElementById('senha_atual').value;
    const novaSenha = document.getElementById('nova_senha').value;
    const confirmarSenha = document.getElementById('confirmar_senha').value;
    
    if (!senhaAtual) {
        e.preventDefault();
        document.getElementById('senha_atual').classList.add('is-invalid');
        document.getElementById('senha_atual').focus();
        return false;
    }
    
    if (novaSenha.length < 6) {
        e.preventDefault();
        document.getElementById('nova_senha').classList.add('is-invalid');
        document.getElementById('nova_senha').focus();
        return false;
    }
    
    if (novaSenha !== confirmarSenha) {
        e.preventDefault();
        document.getElementById('confirmar_senha').classList.add('is-invalid');
        document.getElementById('confirmar_senha').focus();
        return false;
    }
    
    if (senhaAtual === novaSenha) {
        e.preventDefault();
        alert('A nova senha deve ser diferente da senha atual.');
        document.getElementById('nova_senha').focus();
        return false;
    }
    
    // Confirmar alteração
    if (!confirm('Deseja alterar sua senha? Você será deslogado automaticamente.')) {
        e.preventDefault();
        return false;
    }
});

// Adicionar listeners para verificação em tempo real
document.getElementById('senha_atual').addEventListener('input', verificarFormulario);
document.getElementById('nova_senha').addEventListener('input', function() {
    verificarForcaSenha();
    verificarConfirmacao();
});
document.getElementById('confirmar_senha').addEventListener('input', verificarConfirmacao);

// Remover classes de erro ao digitar
document.getElementById('senha_atual').addEventListener('input', function() {
    this.classList.remove('is-invalid');
});

document.getElementById('nova_senha').addEventListener('input', function() {
    this.classList.remove('is-invalid');
});

// Gerar senha segura
function gerarSenhaSegura() {
    const caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*';
    let senha = '';
    
    for (let i = 0; i < 12; i++) {
        senha += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
    }
    
    document.getElementById('nova_senha').value = senha;
    document.getElementById('confirmar_senha').value = senha;
    
    verificarForcaSenha();
    verificarConfirmacao();
}

// Adicionar botão para gerar senha (opcional)
document.addEventListener('DOMContentLoaded', function() {
    const novaSenhaGroup = document.querySelector('#nova_senha').parentElement;
    const btnGerar = document.createElement('button');
    btnGerar.type = 'button';
    btnGerar.className = 'btn btn-outline-info btn-sm mt-2';
    btnGerar.innerHTML = '<i class="bi bi-shuffle"></i> Gerar Senha Segura';
    btnGerar.onclick = gerarSenhaSegura;
    
    novaSenhaGroup.parentElement.appendChild(btnGerar);
});
</script>

