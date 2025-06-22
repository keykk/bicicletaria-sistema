    </main>
    
    <?php if (isset($_SESSION['user_id'])): ?>
    <!-- Footer -->
    <footer class="bg-light mt-5 py-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">
                        <i class="bi bi-bicycle text-primary"></i>
                        <strong>BikeSystem</strong> - Sistema de Gestão de Bicicletaria
                    </p>
                    <small class="text-muted">Versão 1.0.0</small>
                </div>
                <div class="col-md-6 text-md-end">
                    <small class="text-muted">
                        © <?= date('Y') ?> Todos os direitos reservados
                    </small>
                </div>
            </div>
        </div>
    </footer>
    <?php endif; ?>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    

    <!-- Depois o plugin jQuery Mask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <!-- Custom JS -->
    <script src="<?php echo PUBLIC_URL; ?>/js/app.js"></script>
    
    <!-- Page specific scripts -->
    <?php if (isset($scripts) && is_array($scripts)): ?>
        <?php foreach ($scripts as $script): ?>
            <script src="<?= $script ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <?php if (isset($inline_scripts)): ?>
        <script>
            <?= $inline_scripts ?>
        </script>
    <?php endif; ?>
</body>
</html>

