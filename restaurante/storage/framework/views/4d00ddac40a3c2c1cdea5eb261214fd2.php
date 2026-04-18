<?php $__env->startSection('page-title', 'Dashboard — Garçom'); ?>
<?php $__env->startSection('breadcrumb', 'Seu painel de trabalho'); ?>
<?php $__env->startSection('content'); ?>

<div class="cards-grid">
    <div class="stat-card" style="--card-color:#3b82f6">
        <div class="sc-header"><div class="sc-icon">🪑</div><span class="sc-badge">Agora</span></div>
        <div class="sc-value"><?php echo e($mesasOcupadas); ?><span style="font-size:16px;font-weight:500;color:var(--muted)">/<?php echo e($totalMesas); ?></span></div>
        <div class="sc-label">Mesas ocupadas</div>
    </div>
    <div class="stat-card" style="--card-color:#f97316">
        <div class="sc-header"><div class="sc-icon">🧾</div><span class="sc-badge">Seus pedidos</span></div>
        <div class="sc-value"><?php echo e($pedidosGarcom->count()); ?></div>
        <div class="sc-label">Pedidos abertos</div>
    </div>
    <div class="stat-card" style="--card-color:#22c55e">
        <div class="sc-header"><div class="sc-icon">🔔</div><span class="sc-badge">Prontos</span></div>
        <div class="sc-value"><?php echo e($pedidosProntosPagamento->count()); ?></div>
        <div class="sc-label">Para entregar</div>
    </div>
    <div class="stat-card" style="--card-color:#a855f7">
        <div class="sc-header"><div class="sc-icon"></div><span class="sc-badge">Hoje</span></div>
        <div class="sc-value" style="font-size:20px">R$ <?php echo e(number_format($totalPagamentosDia, 2, ',', '.')); ?></div>
        <div class="sc-label">Total recebido</div>
    </div>
</div>

<?php if($pedidosProntosPagamento->isNotEmpty()): ?>
<div class="panel" style="border-color: rgba(34,197,94,.3); background: rgba(34,197,94,.05)">
    <div class="panel-header">
        <div class="panel-title" style="color:#4ade80">🔔 Prontos para Entregar (<?php echo e($pedidosProntosPagamento->count()); ?>)</div>
    </div>
    <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(220px,1fr)); gap:12px">
        <?php $__currentLoopData = $pedidosProntosPagamento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('orders.show', $p)); ?>" style="text-decoration:none">
            <div style="background:rgba(34,197,94,.08); border:1px solid rgba(34,197,94,.2); border-radius:12px; padding:16px; transition:.2s" onmouseover="this.style.background='rgba(34,197,94,.14)'" onmouseout="this.style.background='rgba(34,197,94,.08)'">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px">
                    <span style="font-family:monospace; font-weight:700; color:#4ade80">#<?php echo e(str_pad($p->id,4,'0',STR_PAD_LEFT)); ?></span>
                    <span style="font-size:12px; color:rgba(255,255,255,.4)">Mesa <?php echo e($p->table->numero ?? '—'); ?></span>
                </div>
                <div style="font-size:13px; color:rgba(255,255,255,.6); margin-bottom:8px"><?php echo e($p->items->count()); ?> item(s)</div>
                <div style="font-weight:800; color:#fff">R$ <?php echo e(number_format($p->total,2,',','.')); ?></div>
            </div>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php endif; ?>

<div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px">

    <div class="panel">
        <div class="panel-header">
            <div class="panel-title">🪑 Mesas do Salão</div>
            <a href="<?php echo e(route('orders.create')); ?>" class="btn btn-primary btn-sm">➕ Novo Pedido</a>
        </div>
        <div class="mesas-grid">
            <?php $__currentLoopData = $mesas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mesa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $temPedido    = $mesa->orders->isNotEmpty();
                $contaFechada = $mesa->orders->contains('status', 'pronto_entrega');
                // Conta fechada → vai para a conta (só visualiza)
                // Tem pedido aberto → vai para a conta
                // Sem pedido → abre novo pedido
                $href = ($temPedido || $contaFechada)
                    ? route('mesas.conta', $mesa)
                    : route('orders.create', ['table_id' => $mesa->id]);
            ?>
            <a href="<?php echo e($href); ?>" style="text-decoration:none">
                <div class="mesa-card <?php echo e($mesa->status); ?>">
                    <div class="mc-number"><?php echo e($mesa->numero); ?></div>
                    <div class="mc-seats"><?php echo e($mesa->assentos); ?> lugares</div>
                    <?php if($temPedido): ?>
                    <div style="font-size:11px; font-weight:700; margin-top:2px; color:<?php echo e($contaFechada ? '#fbbf24' : 'var(--accent)'); ?>">
                        <?php echo e($mesa->orders->count()); ?> pedido(s)
                        <?php if($contaFechada): ?>· <span>🔒 Fechada</span><?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <span class="badge badge-<?php echo e($mesa->status === 'disponivel' ? 'success' : ($mesa->status === 'ocupada' ? 'danger' : 'warning')); ?>">
                        <?php echo e(ucfirst($mesa->status)); ?>

                    </span>
                </div>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <div class="table-wrap">
        <div class="table-header">
            <h2> Meus Pedidos Recentes</h2>
            <a href="<?php echo e(route('dashboard.pedidos')); ?>" class="btn btn-secondary btn-sm">Ver todos</a>
        </div>
        <?php if($pedidosGarcom->isEmpty()): ?>
            <div class="empty-state">🧾<p>Nenhum pedido ainda hoje</p></div>
        <?php else: ?>
        <table>
            <thead><tr><th>#</th><th>Mesa</th><th>Status</th><th>Total</th></tr></thead>
            <tbody>
            <?php $__currentLoopData = $pedidosGarcom->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $cores = ['em_preparo'=>'warning','pronto_entrega'=>'success','pago'=>'info','cancelado'=>'danger','entregue'=>'secondary']; ?>
            <tr onclick="window.location='<?php echo e(route('orders.show', $p)); ?>'" style="cursor:pointer">
                <td class="td-mono td-primary">#<?php echo e(str_pad($p->id,4,'0',STR_PAD_LEFT)); ?></td>
                <td>Mesa <?php echo e($p->table->numero ?? '—'); ?></td>
                <td><span class="badge badge-<?php echo e($cores[$p->status] ?? 'secondary'); ?>"><?php echo e(str_replace('_',' ',ucfirst($p->status))); ?></span></td>
                <td class="td-mono">R$ <?php echo e(number_format($p->total,2,',','.')); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project_corrigido\resources\views/dashboard/garcom.blade.php ENDPATH**/ ?>