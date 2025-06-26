<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <i class="bi bi-bicycle"></i>
            <h2 class="mb-0">BikeSystem</h2>
            <p class="mb-0">Sistema de Gestão de Bicicletaria</p>
        </div>
        
        <div class="login-body">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-triangle"></i>
                    <?= $error ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="<?php echo BASE_URL; ?>/empresa/select">
                <div class="mb-3">
                    <label for="lista_empresa" class="form-label">Empresa</label>
                    <select class="form-select" id="lista_empresa" name="lista_empresa" required>
                        <option value="">Selecione uma Empresa</option>
                        <?php foreach ($empresas as $empresa): ?>
                            <option value="<?= $empresa['id'] ?>" >
                                <?= htmlspecialchars($empresa['nome']) . ' ('.htmlspecialchars($empresa['cpf_cnpj']) . ')' ?> 
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            
                <div class="d-flex gap-2">
                    <a href="<?php echo BASE_URL;?>/empresa/novo" class="btn btn-outline-primary btn-lg w-50">
                        <i class="bi bi-person-plus"></i> Cadastrar
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg w-50">
                        <i class="bi bi-box-arrow-in-right"></i> Entrar
                    </button>
                </div>
            </form>
            
            <hr class="my-4">
            
            <div class="text-center">
                <small class="text-muted">
                    <i class="bi bi-info-circle"></i>
                    Seja Bem-vindo ao BikeSystem! Selecione uma empresa para continuar.
                </small>
            </div>
        </div>
    </div>
</div>

<style>
body {
    background: linear-gradient(135deg, #0d6efd, #0056b3);
    margin: 0;
    padding: 0;
}

main {
    padding: 0 !important;
    margin: 0 !important;
}
</style>
