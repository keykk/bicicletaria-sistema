<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-file-text"></i>
                Pedido de Venda #<?= $venda['id'] ?>
            </h1>
            <div class="btn-group" role="group">
                <a href="<?php echo BASE_URL; ?>/pdv/imprimir/<?= $venda['id'] ?>" 
                   class="btn btn-success" target="_blank">
                    <i class="bi bi-printer"></i>
                    Imprimir
                </a>
                <?php if (!empty($venda['email'])): ?>
                    <a href="<?php echo BASE_URL; ?>/pdv/enviar-email/<?= $venda['id'] ?>" 
                       class="btn btn-info">
                        <i class="bi bi-envelope"></i>
                        Enviar Email
                    </a>
                <?php endif; ?>
                <a href="<?php echo BASE_URL; ?>/pdv/vendas" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Voltar
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Informações do orçamento -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-info-circle"></i>
                    Informações
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td><strong>Número:</strong></td>
                        <td><span class="badge bg-primary fs-6">#<?= $venda['id'] ?></span></td>
                    </tr>
                    <tr>
                        <td><strong>Data:</strong></td>
                        <td><?= date('d/m/Y H:i', strtotime($venda['data_venda'])) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Cliente:</strong></td>
                        <td><?= htmlspecialchars($venda['cliente_nome']) ?></td>
                    </tr>
                    <?php if (!empty($venda['cliente_telefone'])): ?>
                    <tr>
                        <td><strong>Telefone:</strong></td>
                        <td>
                            <i class="bi bi-telephone text-muted"></i>
                            <?= htmlspecialchars($venda['cliente_telefone']) ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <?php if (!empty($venda['cliente_email'])): ?>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td>
                            <i class="bi bi-envelope text-muted"></i>
                            <?= htmlspecialchars($venda['cliente_email']) ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <td><strong>Valor Total:</strong></td>
                        <td>
                            <span class="fs-5 fw-bold text-success">
                                R$ <?= number_format($venda['total'], 2, ',', '.') ?>
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        
        <!-- Status do orçamento -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-check-circle"></i>
                    Status
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="bi bi-circle-fill text-success me-2"></i>
                    <span class="badge bg-success">Venda Ativo</span>
                </div>
                <small class="text-muted mt-2 d-block">
                    Criado em <?= date('d/m/Y', strtotime($venda['data_venda'])) ?>
                </small>
            </div>
        </div>
    </div>
    
    <!-- Itens do orçamento -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-list"></i>
                    Itens do Orçamento (<?= count($venda['itens']) ?>)
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Preço Unit.</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($venda['itens'] as $index => $item): ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-secondary"><?= $index + 1 ?></span>
                                    </td>
                                    <td>
                                        <div>
                                            <strong><?= htmlspecialchars($item['produto_nome']) ?></strong>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold"><?= $item['quantidade'] ?></span>
                                        <small class="text-muted"><?= htmlspecialchars($item['unidade_medida']) ?></small>
                                    </td>
                                    <td>
                                        <strong>R$ <?= number_format($item['preco_unitario'], 2, ',', '.') ?></strong>
                                    </td>
                                    <td>
                                        <strong class="text-success">
                                            R$ <?= number_format($item['subtotal'], 2, ',', '.') ?>
                                        </strong>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="4" class="text-end">Total Geral:</th>
                                <th>
                                    <span class="fs-5 text-success">
                                        R$ <?= number_format($venda['total'], 2, ',', '.') ?>
                                    </span>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ações adicionais -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-gear"></i>
                    Ações Disponíveis
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <a href="<?php echo BASE_URL; ?>/pdv/imprimir/<?= $venda['id'] ?>" 
                           class="btn btn-outline-success w-100" target="_blank">
                            <i class="bi bi-printer"></i>
                            Imprimir A4
                        </a>
                    </div>
                    <?php if (!empty($venda['cliente_email'])): ?>
                    <div class="col-md-3 mb-2">
                        <a href="<?php echo BASE_URL; ?>/pdv/enviar-email/<?= $venda['id'] ?>" 
                           class="btn btn-outline-info w-100">
                            <i class="bi bi-envelope"></i>
                            Enviar por Email
                        </a>
                    </div>
                    <?php endif; ?>
                    <div class="col-md-3 mb-2">
                        <a href="<?php echo BASE_URL; ?>/pdv" class="btn btn-outline-primary w-100">
                            <i class="bi bi-plus-circle"></i>
                            Novo Pedido
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="<?php echo BASE_URL; ?>/pdv/excluir/<?= $venda['id'] ?>" 
                           class="btn btn-outline-danger w-100 btn-delete"
                           data-item="este pedido">
                            <i class="bi bi-trash"></i>
                            Excluir Pedido
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



