<?php $__env->startSection('page-title', 'Dashboard — Gerente'); ?>
<?php $__env->startSection('breadcrumb', 'Visão geral do restaurante'); ?>
<?php $__env->startSection('content'); ?>

<div class="cards-grid">
    <div class="stat-card" style="--card-color: #22c55e">
        <div class="sc-header">
            <div class="sc-icon"></div>
            <span class="sc-badge">Hoje</span>
        </div>
        <div class="sc-value">R$ <?php echo e(number_format($vendaHoje, 2, ',', '.')); ?></div>
        <div class="sc-label">Vendas do dia</div>
    </div>
    <div class="stat-card" style="--card-color: #f97316">
        <div class="sc-header">
            <div class="sc-icon">🔥</div>
            <span class="sc-badge">Agora</span>
        </div>
        <div class="sc-value"><?php echo e($pedidosEmPreparo->count()); ?></div>
        <div class="sc-label">Pedidos em preparo</div>
    </div>
    <div class="stat-card" style="--card-color: #3b82f6">
        <div class="sc-header">
            <div class="sc-icon">🪑</div>
            <span class="sc-badge">Ocupação</span>
        </div>
        <div class="sc-value"><?php echo e($mesasOcupadas); ?><span style="font-size:16px;font-weight:500;color:var(--muted)">/<?php echo e($totalMesas); ?></span></div>
        <div class="sc-label">Mesas ocupadas</div>
    </div>
    <div class="stat-card" style="--card-color: <?php echo e($estoqueAlerta->count() > 0 ? '#ef4444' : '#22c55e'); ?>">
        <div class="sc-header">
            <div class="sc-icon">⚠️</div>
            <span class="sc-badge">Alerta</span>
        </div>
        <div class="sc-value"><?php echo e($estoqueAlerta->count()); ?></div>
        <div class="sc-label">Itens em estoque crítico</div>
    </div>
</div>

<div style="display:grid; grid-template-columns: 1.2fr 1fr; gap: 24px;">

    <div class="table-wrap">
        <div class="table-header">
            <h2>🔥 Em Preparo Agora</h2>
            <a href="<?php echo e(route('dashboard.pedidos')); ?>" class="btn btn-secondary btn-sm">Ver todos</a>
        </div>
        <?php if($pedidosEmPreparo->isEmpty()): ?>
            <div class="empty-state">✅<p>Nenhum pedido em preparo</p></div>
        <?php else: ?>
        <table>
            <thead><tr><th>Pedido</th><th>Mesa</th><th>Itens</th><th>Valor</th><th>Tempo</th></tr></thead>
            <tbody>
            <?php $__currentLoopData = $pedidosEmPreparo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><span class="td-primary td-mono">#<?php echo e(str_pad($p->id, 4, '0', STR_PAD_LEFT)); ?></span></td>
                <td>Mesa <?php echo e($p->table->numero ?? '—'); ?></td>
                <td><span class="badge badge-warning"><?php echo e($p->items->count()); ?> itens</span></td>
                <td class="td-mono">R$ <?php echo e(number_format($p->total, 2, ',', '.')); ?></td>
                <td style="color:var(--muted); font-size:12px"><?php echo e($p->created_at->diffForHumans()); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>

    <div class="table-wrap">
        <div class="table-header">
            <h2>⚠️ Estoque Crítico</h2>
            <a href="<?php echo e(route('dashboard.estoque')); ?>" class="btn btn-secondary btn-sm">Gerenciar</a>
        </div>
        <?php if($estoqueAlerta->isEmpty()): ?>
            <div class="empty-state">📦<p>Estoque normalizado</p></div>
        <?php else: ?>
        <table>
            <thead><tr><th>Item</th><th>Atual</th><th>Mínimo</th></tr></thead>
            <tbody>
            <?php $__currentLoopData = $estoqueAlerta; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $u2 = strtolower($item->unidade);
                $isPeso2 = in_array($u2, ['kg','g','gramas','grama']);
                $isVol2  = in_array($u2, ['l','ml','litro','litros']);
                if ($isPeso2) {
                    $qd = $item->quantidade_atual >= 1
                        ? number_format($item->quantidade_atual,3,',','.') . ' kg'
                        : number_format($item->quantidade_atual*1000,0,',','.') . ' g';
                } elseif ($isVol2) {
                    $qd = $item->quantidade_atual >= 1
                        ? number_format($item->quantidade_atual,2,',','.') . ' L'
                        : number_format($item->quantidade_atual*1000,0,',','.') . ' mL';
                } else {
                    $qd = number_format($item->quantidade_atual,0,',','.') . ' un';
                }
            ?>
            <tr>
                <td class="td-primary"><?php echo e($item->nome); ?></td>
                <td><span style="color:#f87171; font-weight:700; font-family:monospace"><?php echo e($qd); ?></span></td>
                <td style="color:var(--muted)">mín. <?php echo e(number_format($item->quantidade_minima,2,',','.')); ?> <?php echo e($item->unidade); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<div style="display:grid; grid-template-columns: repeat(3,1fr); gap:16px; margin-top:8px">
    <a href="<?php echo e(route('dashboard.vendas')); ?>" class="stat-card" style="--card-color:#22c55e; text-decoration:none; display:flex; align-items:center; gap:14px; padding:18px 22px">
        <div class="sc-icon">📈</div>
        <div><div style="color:#fff; font-weight:700; font-size:14px">Relatório de Vendas</div><div class="sc-label">Ver histórico do mês</div></div>
        →
    </a>
    <a href="<?php echo e(route('compras.index')); ?>" class="stat-card" style="--card-color:#3b82f6; text-decoration:none; display:flex; align-items:center; gap:14px; padding:18px 22px">
        <div class="sc-icon">🛒</div>
        <div><div style="color:#fff; font-weight:700; font-size:14px">Registrar Compra</div><div class="sc-label">Entrada de estoque</div></div>
        →
    </a>
    <a href="<?php echo e(route('mesas.index')); ?>" class="stat-card" style="--card-color:#a855f7; text-decoration:none; display:flex; align-items:center; gap:14px; padding:18px 22px">
        <div class="sc-icon">🪑</div>
        <div><div style="color:#fff; font-weight:700; font-size:14px">Gerenciar Mesas</div><div class="sc-label"><?php echo e($totalMesas); ?> mesas cadastradas</div></div>
        →
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project_corrigido\resources\views/dashboard/admin.blade.php ENDPATH**/ ?>