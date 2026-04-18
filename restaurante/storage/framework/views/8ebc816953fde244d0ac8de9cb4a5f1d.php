<?php $__env->startSection('page-title', 'Mesas'); ?>
<?php $__env->startSection('breadcrumb', 'Controle do salão'); ?>

<?php $__env->startSection('styles'); ?>
<style>
.mesas-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(160px,1fr)); gap:16px; }
.mesa-wrap { display:flex; flex-direction:column; gap:6px; }

.mesa-card {
    border-radius:14px; padding:16px 12px 14px;
    border:2px solid var(--border);
    text-align:center; cursor:pointer;
    transition:all .18s; position:relative;
    background:var(--bg2);
}
.mesa-card::after {
    content:''; position:absolute; bottom:0; left:0; right:0;
    height:3px; border-radius:0 0 12px 12px;
    background: var(--mc, var(--muted));
}
.mesa-card.disponivel { --mc:#22c55e; border-color:rgba(34,197,94,.2); }
.mesa-card.ocupada    { --mc:#ef4444; border-color:rgba(239,68,68,.35); background:rgba(239,68,68,.04); }
.mesa-card.reservada  { --mc:#eab308; border-color:rgba(234,179,8,.35); background:rgba(234,179,8,.04); }
.mesa-card:hover      { transform:translateY(-2px); box-shadow:0 6px 20px rgba(0,0,0,.3); }

.mc-number { font-size:28px; font-weight:900; color:#fff; line-height:1; }
.mc-seats  { font-size:11px; color:var(--muted); margin:2px 0 8px; }
.mc-pedidos{ font-size:11px; color:var(--accent); font-weight:700; margin-bottom:4px; }

.status-btns { display:flex; gap:5px; justify-content:center; flex-wrap:wrap; }
.sbtn {
    font-size:11px; padding:5px 10px; border-radius:8px;
    border:1.5px solid transparent; cursor:pointer;
    font-weight:700; font-family:inherit; transition:.15s;
    background:transparent;
}
.sbtn:disabled { opacity:.35; cursor:not-allowed; }
.sbtn-disponivel { border-color:rgba(34,197,94,.4); color:#4ade80; }
.sbtn-disponivel:not(:disabled):hover { background:rgba(34,197,94,.12); }
.sbtn-disponivel.ativo { background:rgba(34,197,94,.15); border-color:#4ade80; }
.sbtn-reservada  { border-color:rgba(234,179,8,.4);  color:#fbbf24; }
.sbtn-reservada:not(:disabled):hover  { background:rgba(234,179,8,.12); }
.sbtn-reservada.ativo  { background:rgba(234,179,8,.15);  border-color:#fbbf24; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px">
    <div style="display:flex; gap:8px; flex-wrap:wrap">
        <span class="badge badge-success" style="padding:6px 14px">● Disponível</span>
        <span class="badge badge-danger"  style="padding:6px 14px">● Ocupada</span>
        <span class="badge badge-warning" style="padding:6px 14px">● Reservada</span>
    </div>
    <?php if(Auth::user()->role === 'gerente'): ?>
    <a href="<?php echo e(route('mesas.create')); ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nova Mesa
    </a>
    <?php endif; ?>
</div>

<div class="mesas-grid">
    <?php $__empty_1 = true; $__currentLoopData = $mesas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mesa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php
        $temPedido    = $mesa->orders->isNotEmpty();
        $contaFechada = $mesa->orders->contains('status','pronto_entrega');
        $href = $temPedido ? route('mesas.conta', $mesa) : null;
    ?>
    <div class="mesa-wrap">
        
        <div class="mesa-card <?php echo e($mesa->status); ?>"
             <?php if($href): ?> onclick="window.location='<?php echo e($href); ?>'" <?php else: ?> style="cursor:default" <?php endif; ?>>
            <div class="mc-number"><?php echo e($mesa->numero); ?></div>
            <div class="mc-seats"><?php echo e($mesa->assentos); ?> lugares</div>

            <?php if($temPedido): ?>
            <div class="mc-pedidos">
                <?php echo e($mesa->orders->count()); ?> pedido(s)
                <?php if($contaFechada): ?>
                <br><span style="color:#fbbf24">Conta fechada</span>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <span class="badge badge-<?php echo e($mesa->status==='disponivel'?'success':($mesa->status==='ocupada'?'danger':'warning')); ?>">
                <?php echo e(ucfirst($mesa->status)); ?>

            </span>
        </div>

        
        <?php if(in_array(Auth::user()->role, ['garcom','gerente']) && !$temPedido): ?>
        <div class="status-btns">
            <form method="POST" action="<?php echo e(route('mesas.atualizar', $mesa)); ?>">
                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                <input type="hidden" name="status" value="disponivel">
                <button type="submit" class="sbtn sbtn-disponivel <?php echo e($mesa->status==='disponivel'?'ativo':''); ?>"
                        <?php if($mesa->status==='disponivel'): ?> disabled <?php endif; ?>>
                    Livre
                </button>
            </form>
            <form method="POST" action="<?php echo e(route('mesas.atualizar', $mesa)); ?>">
                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                <input type="hidden" name="status" value="reservada">
                <button type="submit" class="sbtn sbtn-reservada <?php echo e($mesa->status==='reservada'?'ativo':''); ?>"
                        <?php if($mesa->status==='reservada'): ?> disabled <?php endif; ?>>
                    Reservar
                </button>
            </form>
        </div>
        <?php elseif(in_array(Auth::user()->role, ['garcom','gerente']) && $temPedido): ?>
        <div style="text-align:center; font-size:11px; padding:4px 0">
            <?php if($contaFechada): ?>
            <span style="color:#fbbf24"><i class="fas fa-clock" style="font-size:10px"></i> Aguardando pagamento</span>
            <?php else: ?>
            <span style="color:var(--muted)"><i class="fas fa-lock" style="font-size:10px"></i> Pedidos em aberto</span>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        
        <?php if(Auth::user()->role === 'gerente'): ?>
        <div style="display:flex; gap:5px; justify-content:center">
            <a href="<?php echo e(route('mesas.edit', $mesa)); ?>" class="btn btn-secondary btn-sm btn-icon">
                <i class="fas fa-pencil"></i>
            </a>
            <form method="POST" action="<?php echo e(route('mesas.destroy', $mesa)); ?>"
                  onsubmit="return confirm('Deletar Mesa <?php echo e($mesa->numero); ?>?')">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button class="btn btn-danger btn-sm btn-icon">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
        <?php endif; ?>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="empty-state" style="grid-column:1/-1">
        <i class="fas fa-chair"></i><p>Nenhuma mesa cadastrada</p>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project_corrigido\resources\views/mesas/index.blade.php ENDPATH**/ ?>