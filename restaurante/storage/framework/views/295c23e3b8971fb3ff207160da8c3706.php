<?php $__env->startSection('page-title', 'Cozinha — Preparo'); ?>
<?php $__env->startSection('breadcrumb', 'Fila de pedidos em preparo'); ?>
<?php $__env->startSection('content'); ?>

<div class="cards-grid" style="grid-template-columns:repeat(3,1fr); margin-bottom:24px">
    <div class="stat-card" style="--card-color:#f97316">
        <div class="sc-header"><div class="sc-icon">🔥</div></div>
        <div class="sc-value"><?php echo e($pedidosEmPreparo->count()); ?></div>
        <div class="sc-label">Pedidos em preparo</div>
    </div>
    <div class="stat-card" style="--card-color:#3b82f6">
        <div class="sc-header"><div class="sc-icon">🍴</div></div>
        <div class="sc-value"><?php echo e($totalItems); ?></div>
        <div class="sc-label">Total de itens</div>
    </div>
    <div class="stat-card" style="--card-color:#22c55e">
        <div class="sc-header"><div class="sc-icon"></div></div>
        <div class="sc-value"><?php echo e($itensProntos); ?><span style="font-size:16px;font-weight:500;color:var(--muted)">/<?php echo e($totalItems); ?></span></div>
        <div class="sc-label">Itens prontos</div>
    </div>
</div>

<?php if($pedidosEmPreparo->isEmpty()): ?>
<div class="panel" style="text-align:center; padding:64px">
    <div style="font-size:64px; margin-bottom:16px">🍳</div>
    <div style="font-size:18px; font-weight:700; color:#fff; margin-bottom:8px">Cozinha Livre</div>
    <div style="color:var(--muted); font-size:14px">Nenhum pedido em preparo no momento</div>
</div>
<?php else: ?>
<div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(380px, 1fr)); gap:20px">
    <?php $__currentLoopData = $pedidosEmPreparo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pedido): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $prontos = $pedido->items->where('status','pronto')->count();
        $total   = $pedido->items->count();
        $pct     = $total > 0 ? round($prontos/$total*100) : 0;
        $minutos = $pedido->horario_pedido ? now()->diffInMinutes($pedido->horario_pedido) : 0;
    ?>
    <div class="panel" style="margin-bottom:0; border-color: <?php echo e($minutos > 20 ? 'rgba(239,68,68,.3)' : 'rgba(255,255,255,.07)'); ?>">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:16px">
            <div>
                <div style="font-size:18px; font-weight:800; color:#fff">
                    Pedido <span style="color:var(--accent); font-family:monospace">#<?php echo e(str_pad($pedido->id,4,'0',STR_PAD_LEFT)); ?></span>
                </div>
                <div style="font-size:13px; color:var(--muted); margin-top:3px">
                    Mesa <?php echo e($pedido->table->numero ?? '—'); ?>

                    <?php if($pedido->horario_pedido): ?>
                    · <span style="color: <?php echo e($minutos > 20 ? '#f87171' : ($minutos > 10 ? '#facc15' : '#4ade80')); ?>">
                        <?php echo e($minutos); ?> min atrás
                    </span>
                    <?php endif; ?>
                </div>
            </div>
            <span class="badge badge-<?php echo e($pct === 100 ? 'success' : 'warning'); ?>"><?php echo e($prontos); ?>/<?php echo e($total); ?> prontos</span>
        </div>

        <!-- Progress bar -->
        <div style="background:rgba(255,255,255,.06); border-radius:4px; height:4px; margin-bottom:16px">
            <div style="height:4px; border-radius:4px; background:<?php echo e($pct===100 ? '#22c55e' : 'var(--accent)'); ?>; width:<?php echo e($pct); ?>%; transition:.3s"></div>
        </div>

        <?php if($pedido->observacoes): ?>
        <div style="background:rgba(234,179,8,.08); border:1px solid rgba(234,179,8,.2); border-radius:8px; padding:10px 14px; margin-bottom:14px; font-size:13px; color:#facc15">
             <?php echo e($pedido->observacoes); ?>

        </div>
        <?php endif; ?>

        <div style="display:flex; flex-direction:column; gap:8px">
            <?php $__currentLoopData = $pedido->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div style="display:flex; align-items:center; justify-content:space-between; background:rgba(255,255,255,.03); border:1px solid <?php echo e($item->status === 'pronto' ? 'rgba(34,197,94,.2)' : 'rgba(255,255,255,.06)'); ?>; border-radius:10px; padding:12px 16px; transition:.2s">
                <div style="display:flex; align-items:center; gap:10px">
                    <div style="width:28px; height:28px; border-radius:8px; background:<?php echo e($item->status === 'pronto' ? 'rgba(34,197,94,.15)' : 'rgba(255,255,255,.05)'); ?>; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:13px; color:<?php echo e($item->status === 'pronto' ? '#4ade80' : '#fff'); ?>"><?php echo e($item->quantidade); ?></div>
                    <div>
                        <div style="font-weight:600; color:#fff; font-size:13.5px"><?php echo e($item->menuItem->nome ?? 'Item'); ?></div>
                        <?php if($item->observacoes): ?><div style="font-size:11px; color:var(--muted)"><?php echo e($item->observacoes); ?></div><?php endif; ?>
                    </div>
                </div>
                <form method="POST" action="<?php echo e(route('chef.item.status', $item)); ?>" style="display:flex; gap:6px">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    <?php if($item->status !== 'pronto'): ?>
                        <input type="hidden" name="status" value="pronto">
                        <button type="submit" class="btn btn-success btn-sm">✓ Pronto</button>
                    <?php else: ?>
                        <input type="hidden" name="status" value="em_preparo">
                        <button type="submit" class="btn btn-warning btn-sm"></button>
                    <?php endif; ?>
                </form>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
    // Auto-refresh a cada 30 segundos
    setTimeout(() => location.reload(), 30000);
    let countdown = 30;
    const interval = setInterval(() => {
        countdown--;
        if (countdown <= 0) clearInterval(interval);
    }, 1000);
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project_corrigido\resources\views/dashboard/chef-preparo.blade.php ENDPATH**/ ?>