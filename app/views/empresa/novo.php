<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-building"></i>
                Configurações da Empresa
            </h1>
            <a href="<?php echo BASE_URL; ?>/empresa" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
                Voltar
            </a>
        </div>
    </div>
</div>

<form method="POST" action="<?php echo BASE_URL; ?>/empresa/novo" enctype="multipart/form-data">
    <div class="row">
        <!-- Informações Básicas -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-info-circle"></i>
                        Informações Básicas
                    </h6>
                </div>
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label for="empresa_nome" class="form-label">Nome da Empresa *</label>
                            <input type="text" class="form-control" id="empresa_nome" name="empresa_nome" 
                                value="<?= htmlspecialchars($_POST['empresa_nome'] ?? '') ?>" required>
                            <!--<div class="form-text">Nome que aparecerá nos orçamentos e documentos</div>-->
                        </div>
                        <div class="col-md-5 mb-3">
                            <label for="empresa_nome_fantasia" class="form-label">Nome Fantasia *</label>
                            <input type="text" class="form-control" id="empresa_nome_fantasia" name="empresa_nome_fantasia" 
                                value="<?= htmlspecialchars($_POST['empresa_nome_fantasia'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="empresa_cnpj" class="form-label">CNPJ</label>
                            <input type="text" class="form-control" id="empresa_cnpj" name="empresa_cnpj" 
                                value="<?= htmlspecialchars($_POST['empresa_cnpj'] ?? '') ?>"
                                placeholder="00.000.000/0000-00">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="empresa_slogan" class="form-label">Slogan</label>
                        <input type="text" class="form-control" id="empresa_slogan" name="empresa_slogan" 
                               value="<?= htmlspecialchars($_POST['empresa_slogan'] ?? '') ?>"
                               placeholder="Sua melhor pedalada começa aqui!">
                        <div class="form-text">Frase que representa sua empresa</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="empresa_endereco" class="form-label">Endereço Completo *</label>
                        <textarea class="form-control" id="empresa_endereco" name="empresa_endereco" 
                                  rows="3" required><?= htmlspecialchars($_POST['empresa_endereco'] ?? '') ?></textarea>
                        <div class="form-text">Endereço completo com CEP, cidade e estado</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cidade" class="form-label">Cidade *</label>
                            <input type="text" class="form-control" id="cidade" name="cidade" 
                                value="<?= htmlspecialchars($_POST['cidade'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="estado" class="form-label">Estado *</label>
                            <input type="text" class="form-control" id="estado" name="estado" 
                                value="<?= htmlspecialchars($_POST['estado'] ?? '') ?>" 
                                maxlength="2" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="cep" class="form-label">CEP</label>
                            <input type="number" class="form-control" id="cep" name="cep" 
                                value="<?= htmlspecialchars($_POST['cep'] ?? '') ?>"
                                placeholder="00000-000">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contatos -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-telephone"></i>
                        Informações de Contato
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="empresa_telefone" class="form-label">Telefone Principal *</label>
                            <input type="tel" class="form-control" id="empresa_telefone" name="empresa_telefone" 
                                   value="<?= htmlspecialchars($_POST['empresa_telefone'] ?? '') ?>" 
                                   placeholder="(11) 99999-9999" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="empresa_whatsapp" class="form-label">WhatsApp</label>
                            <input type="tel" class="form-control" id="empresa_whatsapp" name="empresa_whatsapp" 
                                   value="<?= htmlspecialchars($_POST['empresa_whatsapp'] ?? '') ?>" 
                                   placeholder="(11) 99999-9999">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="empresa_email" class="form-label">Email Principal *</label>
                            <input type="email" class="form-control" id="empresa_email" name="empresa_email" 
                                   value="<?= htmlspecialchars($_POST['empresa_email'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="empresa_website" class="form-label">Website</label>
                            <input type="url" class="form-control" id="empresa_website" name="empresa_website" 
                                   value="<?= htmlspecialchars($_POST['empresa_website'] ?? '') ?>" 
                                   placeholder="https://www.minhabicicletaria.com.br">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Redes Sociais -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-share"></i>
                        Redes Sociais
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="empresa_facebook" class="form-label">
                                <i class="bi bi-facebook text-primary"></i>
                                Facebook
                            </label>
                            <input type="url" class="form-control" id="empresa_facebook" name="empresa_facebook" 
                                   value="<?= htmlspecialchars($_POST['empresa_facebook'] ?? '') ?>" 
                                   placeholder="https://facebook.com/minhabicicletaria">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="empresa_instagram" class="form-label">
                                <i class="bi bi-instagram text-danger"></i>
                                Instagram
                            </label>
                            <input type="url" class="form-control" id="empresa_instagram" name="empresa_instagram" 
                                   value="<?= htmlspecialchars($_POST['empresa_instagram'] ?? '') ?>" 
                                   placeholder="https://instagram.com/minhabicicletaria">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="empresa_youtube" class="form-label">
                                <i class="bi bi-youtube text-danger"></i>
                                YouTube
                            </label>
                            <input type="url" class="form-control" id="empresa_youtube" name="empresa_youtube" 
                                value="<?= htmlspecialchars($_POST['empresa_youtube'] ?? '') ?>" 
                                placeholder="https://youtube.com/@minhabicicletaria">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="empresa_twitter" class="form-label">
                                <i class="bi bi-twitter text-primary"></i>
                                Twitter
                            </label>
                            <input type="url" class="form-control" id="empresa_twitter" name="empresa_twitter" 
                                value="<?= htmlspecialchars($POST['empresa_twitter'] ?? '') ?>" 
                                placeholder="https://twitter.com/minhabicicletaria">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Logo e Configurações Visuais -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-image"></i>
                        Logo da Empresa
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <?php if (!empty($_POST['empresa_logo'])): ?>
                            <img src="<?= htmlspecialchars($_POST['empresa_logo'] ?? '') ?>" 
                                 alt="Logo da Empresa" class="img-fluid" style="max-height: 150px;">
                        <?php else: ?>
                            <div class="bg-light border rounded p-4" style="height: 150px; display: flex; align-items: center; justify-content: center;">
                                <div class="text-muted">
                                    <i class="bi bi-image" style="font-size: 2rem;"></i>
                                    <br>
                                    <small>Nenhuma logo</small>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <input type="file" class="form-control" id="empresa_logo" name="empresa_logo" 
                               accept="image/*">
                        <div class="form-text">Formatos: JPG, PNG, GIF (máx. 2MB)</div>
                    </div>
                </div>
            </div>
            
            <!-- Cores da Marca -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-palette"></i>
                        Cores da Marca
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="empresa_cor_primaria" class="form-label">Cor Primária</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" 
                                   id="empresa_cor_primaria" name="empresa_cor_primaria" 
                                   value="<?= htmlspecialchars($_POST['empresa_cor_primaria'] ?? '#0d6efd') ?>">
                            <input type="text" class="form-control" 
                                   value="<?= htmlspecialchars($_POST['empresa_cor_primaria'] ?? '#0d6efd') ?>"
                                   readonly>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="empresa_cor_secundaria" class="form-label">Cor Secundária</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" 
                                   id="empresa_cor_secundaria" name="empresa_cor_secundaria" 
                                   value="<?= htmlspecialchars($_POST['empresa_cor_secundaria'] ?? '#6c757d') ?>">
                            <input type="text" class="form-control" 
                                   value="<?= htmlspecialchars($_POST['empresa_cor_secundaria'] ?? '#6c757d') ?>"
                                   readonly>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="resetarCores()">
                            <i class="bi bi-arrow-clockwise"></i>
                            Cores Padrão
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Informações Adicionais -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-info-square"></i>
                        Informações Adicionais
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="empresa_inscricao_estadual" class="form-label">Inscrição Estadual</label>
                        <input type="text" class="form-control" id="empresa_inscricao_estadual" 
                               name="empresa_inscricao_estadual" 
                               value="<?= htmlspecialchars($_POST['empresa_inscricao_estadual'] ?? '') ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="empresa_regime_tributario" class="form-label">Regime Tributário</label>
                        <select class="form-select" id="empresa_regime_tributario" name="empresa_regime_tributario">
                            <option value="">Selecione</option>
                            <option value="simples_nacional" <?= ($_POST['empresa_regime_tributario'] ?? '') === 'simples_nacional' ? 'selected' : '' ?>>Simples Nacional</option>
                            <option value="lucro_presumido" <?= ($_POST['empresa_regime_tributario'] ?? '') === 'lucro_presumido' ? 'selected' : '' ?>>Lucro Presumido</option>
                            <option value="lucro_real" <?= ($_POST['empresa_regime_tributario'] ?? '') === 'lucro_real' ? 'selected' : '' ?>>Lucro Real</option>
                            <option value="mei" <?= ($_POST['empresa_regime_tributario'] ?? '') === 'mei' ? 'selected' : '' ?>>MEI</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="empresa_responsavel" class="form-label">Responsável</label>
                        <input type="text" class="form-control" id="empresa_responsavel" 
                               name="empresa_responsavel" 
                               value="<?= htmlspecialchars($_POST['empresa_responsavel'] ?? '') ?>"
                               placeholder="Nome do proprietário/responsável">
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
                            
                        </div>
                        <div>
                            <button type="button" class="btn btn-outline-secondary me-2" onclick="resetarFormulario()">
                                <i class="bi bi-arrow-clockwise"></i>
                                Resetar
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i>
                                Salvar Configurações
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<script>
// Máscara para CNPJ
document.getElementById('empresa_cnpj').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    value = value.replace(/^(\d{2})(\d)/, '$1.$2');
    value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
    value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
    value = value.replace(/(\d{4})(\d)/, '$1-$2');
    e.target.value = value;
});

// Máscara para telefone
function mascaraTelefone(input) {
    input.addEventListener('input', function(e) {
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
}

mascaraTelefone(document.getElementById('empresa_telefone'));
mascaraTelefone(document.getElementById('empresa_whatsapp'));

// Sincronizar cores
document.getElementById('empresa_cor_primaria').addEventListener('change', function() {
    this.nextElementSibling.value = this.value;
});

document.getElementById('empresa_cor_secundaria').addEventListener('change', function() {
    this.nextElementSibling.value = this.value;
});

function resetarCores() {
    document.getElementById('empresa_cor_primaria').value = '#0d6efd';
    document.getElementById('empresa_cor_secundaria').value = '#6c757d';
    document.querySelector('#empresa_cor_primaria + input').value = '#0d6efd';
    document.querySelector('#empresa_cor_secundaria + input').value = '#6c757d';
}

function resetarFormulario() {
    if (confirm('Deseja resetar todas as alterações não salvas?')) {
        location.reload();
    }
}

// Validação do formulário
document.querySelector('form').addEventListener('submit', function(e) {
    const nome = document.getElementById('empresa_nome').value.trim();
    const telefone = document.getElementById('empresa_telefone').value.trim();
    const email = document.getElementById('empresa_email').value.trim();
    const endereco = document.getElementById('empresa_endereco').value.trim();
    
    if (!nome || !telefone || !email || !endereco) {
        e.preventDefault();
        alert('Por favor, preencha todos os campos obrigatórios (*)');
        return false;
    }
    
    // Validar email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        e.preventDefault();
        alert('Por favor, insira um email válido');
        return false;
    }
});
</script>

