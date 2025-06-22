<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-file-text"></i>
                Orçamento #<?= $orcamento['id'] ?>
            </h1>
            <div class="btn-group" role="group">
                <a href="<?php echo BASE_URL; ?>/orcamento/imprimir/<?= $orcamento['id'] ?>" 
                   class="btn btn-success" target="_blank">
                    <i class="bi bi-printer"></i>
                    Imprimir
                </a>
                <?php if (!empty($orcamento['email'])): ?>
                    <a href="<?php echo BASE_URL; ?>/orcamento/enviar-email/<?= $orcamento['id'] ?>" 
                       class="btn btn-info">
                        <i class="bi bi-envelope"></i>
                        Enviar Email
                    </a>
                <?php endif; ?>
                <a href="<?php echo BASE_URL; ?>/orcamento" class="btn btn-outline-secondary">
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
                    Informações do Orçamento
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td><strong>Número:</strong></td>
                        <td><span class="badge bg-primary fs-6">#<?= $orcamento['id'] ?></span></td>
                    </tr>
                    <tr>
                        <td><strong>Data:</strong></td>
                        <td><?= date('d/m/Y H:i', strtotime($orcamento['data'])) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Cliente:</strong></td>
                        <td><?= htmlspecialchars($orcamento['cliente']) ?></td>
                    </tr>
                    <?php if (!empty($orcamento['telefone'])): ?>
                    <tr>
                        <td><strong>Telefone:</strong></td>
                        <td>
                            <i class="bi bi-telephone text-muted"></i>
                            <?= htmlspecialchars($orcamento['telefone']) ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <?php if (!empty($orcamento['email'])): ?>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td>
                            <i class="bi bi-envelope text-muted"></i>
                            <?= htmlspecialchars($orcamento['email']) ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <td><strong>Valor Total:</strong></td>
                        <td>
                            <span class="fs-5 fw-bold text-success">
                                R$ <?= number_format($orcamento['valor_total'], 2, ',', '.') ?>
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
                    <span class="badge bg-success">Orçamento Ativo</span>
                </div>
                <small class="text-muted mt-2 d-block">
                    Criado em <?= date('d/m/Y', strtotime($orcamento['data'])) ?>
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
                    Itens do Orçamento (<?= count($orcamento['itens']) ?>)
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
                            <?php foreach ($orcamento['itens'] as $index => $item): ?>
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
                                        <strong>R$ <?= number_format($item['preco'], 2, ',', '.') ?></strong>
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
                                        R$ <?= number_format($orcamento['valor_total'], 2, ',', '.') ?>
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
                        <a href="<?php echo BASE_URL; ?>/orcamento/imprimir/<?= $orcamento['id'] ?>" 
                           class="btn btn-outline-success w-100" target="_blank">
                            <i class="bi bi-printer"></i>
                            Imprimir Orçamento
                        </a>
                    </div>
                    <?php if (!empty($orcamento['email'])): ?>
                    <div class="col-md-3 mb-2">
                        <a href="<?php echo BASE_URL; ?>/orcamento/enviar-email/<?= $orcamento['id'] ?>" 
                           class="btn btn-outline-info w-100">
                            <i class="bi bi-envelope"></i>
                            Enviar por Email
                        </a>
                    </div>
                    <?php endif; ?>
                    <div class="col-md-3 mb-2">
                        <a href="<?php echo BASE_URL; ?>/orcamento/novo" class="btn btn-outline-primary w-100">
                            <i class="bi bi-plus-circle"></i>
                            Novo Orçamento
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="<?php echo BASE_URL; ?>/orcamento/excluir/<?= $orcamento['id'] ?>" 
                           class="btn btn-outline-danger w-100 btn-delete"
                           data-item="este orçamento">
                            <i class="bi bi-trash"></i>
                            Excluir Orçamento
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Observações -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-start-info">
            <div class="card-header bg-info bg-opacity-10">
                <h6 class="card-title mb-0">
                    <i class="bi bi-lightbulb text-info"></i>
                    Observações
                </h6>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    <li>Este orçamento tem validade de 30 dias a partir da data de emissão</li>
                    <li>Os preços podem sofrer alterações sem aviso prévio</li>
                    <li>Para confirmar o pedido, entre em contato conosco</li>
                    <?php if (!empty($orcamento['email'])): ?>
                    <li>Uma cópia pode ser enviada para o email cadastrado</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

