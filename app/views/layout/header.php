<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sistema de Gestão - Bicicletaria' ?></title>
    <!-- Bootstrap CSS -->
    <link href="<?php echo PUBLIC_URL; ?>/bootstrap-5.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="<?php echo PUBLIC_URL; ?>/bootstrap-5.3.7-dist/icons-1.13.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo PUBLIC_URL; ?>/css/style.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="<?= PUBLIC_URL ?>/select2-4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <link href="<?= PUBLIC_URL ?>/select2-bootstrap-5-theme-master/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet">


    <!-- jQuery -->
    <script src="<?php echo PUBLIC_URL; ?>/js/jquery-3.7.1.js"></script>
    <!-- Bootstrap JS -->
    <script src="<?php echo PUBLIC_URL; ?>/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
    

    <!-- Depois o plugin jQuery Mask -->
    <script src="<?php echo PUBLIC_URL; ?>/jQuery-Mask-Plugin-master/dist/jquery.mask.min.js"></script>

    <!-- Select2 JS -->
    <script src="<?= PUBLIC_URL ?>/select2-4.0.13/dist/js/select2.min.js"></script>

    <!-- Custom JS -->
    <script src="<?php echo PUBLIC_URL; ?>/js/app.js"></script>

    <script>
        var produtosPrecos = {};
        function checkJQuery(callback) {
            if (window.jQuery) {
                callback(jQuery);
            } else {
                var script = document.createElement('script');
                script.src = "<?php echo PUBLIC_URL; ?>/js/jquery-3.7.1.js";
                script.onload = function() {
                    callback(jQuery);
                };
                document.head.appendChild(script);
            }
        }
    </script>
</head>
<body>
    <?php if (isset($_SESSION['user_id']) && isset($_SESSION['empresa_id'])): ?>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>/dashboard">
                <i class="bi bi-bicycle"></i>
                BikeSystem
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/dashboard">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-box-seam"></i> Produtos
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/produto">Listar Produtos</a></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/produto/novo">Novo Produto</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-boxes"></i> Estoque
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/estoque">Relatório de Estoque</a></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/estoque/entrada">Entrada</a></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/estoque/saida">Saída</a></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/estoque/ajuste">Ajuste</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-currency-dollar"></i> Preços
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/tabelapreco">Tabelas de Preço</a></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/tabelapreco/nova">Nova Tabela</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-file-text"></i> Ponto de Venda
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/pdv">PDV</a></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/pdv/vendas">Vendas</a></li>
                        </ul>
                    </li>
                </ul>
                
                <a href="<?php echo BASE_URL; ?>/empresa" class="nav-link text-white d-flex align-items-center ms-lg-auto">
                    <i class="bi bi-building me-2"></i>
                    <span><?= strtoupper($_SESSION['empresa_data']['nome'] ?? 'Empresa não encontrada !') ?></span>
                </a>

                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i>
                            <?= ucwords($_SESSION['user_data']['nome_usuario'] ?? 'Usuário') ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item bi bi-sliders" href="<?php echo BASE_URL; ?>/configuracao"> Configurações</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item bi bi-person" href="<?php echo BASE_URL; ?>/perfil"> Meu Perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item bi bi-box-arrow-right" href="<?php echo BASE_URL; ?>/login/logout"> Sair</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php endif; ?>
    
    <!-- Main Content -->
    <main class="<?= isset($_SESSION['user_id']) ? 'container-fluid mt-4' : '' ?>">
        <?php if (isset($_SESSION['user_id'])): ?>
        <!-- Breadcrumb -->
        
        
        <!-- Alerts -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i>
                <?= $_SESSION['success'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['errors']) && is_array($_SESSION['errors'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i>
                <ul class="mb-0">
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>
        
        <?php if (isset($errors) && is_array($errors) && !empty($errors)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i>
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i>
                <?= $success ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php endif; ?>

