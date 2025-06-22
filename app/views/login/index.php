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
            
            <form method="POST" action="<?php echo BASE_URL; ?>/login/authenticate">
                <div class="mb-3">
                    <label for="username" class="form-label">Usuário</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-person"></i>
                        </span>
                        <input type="text" class="form-control" id="username" name="username" required autofocus>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="password" class="form-label">Senha</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Entrar
                    </button>
                </div>
            </form>
            
            <hr class="my-4">
            
            <div class="text-center">
                <small class="text-muted">
                    <i class="bi bi-info-circle"></i>
                    Use as credenciais fornecidas pelo administrador
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

