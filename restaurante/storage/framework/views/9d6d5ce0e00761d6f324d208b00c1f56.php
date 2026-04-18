<?php $__env->startSection('page-title'); ?>
Pedido #<?php echo e(str_pad($pedido->id, 4, '0', STR_PAD_LEFT)); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb', 'Detalhes do pedido'); ?>
<?php $__env->startSection('content'); ?>
<div style="display:grid; grid-template-columns: 1.2fr 1fr; gap:24px">
    <div class="panel">
        <div class="panel-header">
            <div class="panel-title">🧾 Pedido <span style="color:var(--accent); font-family:monospace">#<?php echo e(str_pad($pedido->id,4,'0',STR_PAD_LEFT)); ?></span></div>
            <?php $cores=['em_preparo'=>'warning','pronto_entrega'=>'success','pago'=>'info','cancelado'=>'danger','entregue'=>'secondary']; ?>
            <span class="badge badge-<?php echo e($cores[$pedido->status]??'secondary'); ?>" style="font-size:13px; padding:6px 14px"><?php echo e(str_replace('_',' ',ucfirst($pedido->status))); ?></span>
        </div>
        <div style="display:grid; gap:0; margin-bottom:20px">
            <div style="display:flex; justify-content:space-between; padding:12px 0; border-bottom:1px solid var(--border)"><span style="color:var(--muted)">Mesa</span><strong><?php echo e($pedido->table->numero ?? '—'); ?></strong></div>
            <div style="display:flex; justify-content:space-between; padding:12px 0; border-bottom:1px solid var(--border)"><span style="color:var(--muted)">Garçom</span><strong><?php echo e($pedido->user->name ?? '—'); ?></strong></div>
            <div style="display:flex; justify-content:space-between; padding:12px 0; border-bottom:1px solid var(--border)"><span style="color:var(--muted)">Horário</span><strong><?php echo e($pedido->horario_pedido ? $pedido->horario_pedido->format('d/m/Y H:i') : $pedido->created_at->format('d/m/Y H:i')); ?></strong></div>
            <?php if($pedido->observacoes): ?>
            <div style="padding:12px 0; border-bottom:1px solid var(--border)">
                <div style="color:var(--muted); margin-bottom:6px">Observações</div>
                <div style="background:rgba(234,179,8,.08); border:1px solid rgba(234,179,8,.2); border-radius:8px; padding:10px 14px; color:#facc15; font-size:13px"> <?php echo e($pedido->observacoes); ?></div>
            </div>
            <?php endif; ?>
        </div>
        <div style="display:flex; flex-direction:column; gap:8px; margin-bottom:20px">
            <?php $__currentLoopData = $pedido->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $ic=['pendente'=>'secondary','em_preparo'=>'warning','pronto'=>'success','entregue'=>'info']; ?>
            <div style="display:flex; justify-content:space-between; align-items:center; background:rgba(255,255,255,.03); border:1px solid rgba(255,255,255,.06); border-radius:10px; padding:14px 16px">
                <div style="display:flex; align-items:center; gap:12px">
                    <div style="width:30px; height:30px; border-radius:8px; background:rgba(255,255,255,.06); display:flex; align-items:center; justify-content:center; font-weight:800; color:#fff"><?php echo e($item->quantidade); ?></div>
                    <div>
                        <div style="font-weight:600; color:#fff"><?php echo e($item->menuItem->nome ?? 'Item'); ?></div>
                        <div style="font-size:12px; color:var(--muted)">R$ <?php echo e(number_format($item->preco_unitario,2,',','.')); ?> cada</div>
                    </div>
                </div>
                <div style="text-align:right">
                    <div style="font-weight:800; color:#fff; font-family:monospace">R$ <?php echo e(number_format($item->subtotal,2,',','.')); ?></div>
                    <span class="badge badge-<?php echo e($ic[$item->status]??'secondary'); ?>" style="margin-top:4px"><?php echo e(str_replace('_',' ',ucfirst($item->status))); ?></span>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div style="display:flex; justify-content:space-between; align-items:center; padding:16px 0; border-top:2px solid var(--border)">
            <span style="font-size:16px; font-weight:600; color:var(--muted)">Total do Pedido</span>
            <span style="font-size:24px; font-weight:800; color:var(--accent); font-family:monospace">R$ <?php echo e(number_format($pedido->total,2,',','.')); ?></span>
        </div>
    </div>

    <div>
        <?php if($pedido->payment): ?>
        <div class="panel" style="border-color:rgba(34,197,94,.3); background:rgba(34,197,94,.04); margin-bottom:20px">
            <div class="panel-header"><div class="panel-title" style="color:#4ade80">✅ Pagamento Confirmado</div></div>
            <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid var(--border)"><span style="color:var(--muted)">Método</span><strong><?php echo e(str_replace('_',' ',ucfirst($pedido->payment->metodo))); ?></strong></div>
            <div style="display:flex; justify-content:space-between; padding:10px 0"><span style="color:var(--muted)">Valor Pago</span><strong style="color:#4ade80; font-size:18px; font-family:monospace">R$ <?php echo e(number_format($pedido->payment->valor_final,2,',','.')); ?></strong></div>
        </div>
        <?php endif; ?>

        <?php if(Auth::user()->role==='garcom' && !in_array($pedido->status,['pago','cancelado'])): ?>
        <div class="panel" style="margin-bottom:20px">
            <div class="panel-header"><div class="panel-title">✏️ Atualizar Status</div></div>
            <form method="POST" action="<?php echo e(route('orders.updateStatus',$pedido)); ?>">
                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                <div class="form-group">
                    <label>Novo Status</label>
                    <select name="status" class="form-select" required>
                        <?php $__currentLoopData = ['aberto','em_preparo','pronto_entrega','entregue','cancelado']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($s); ?>" <?php echo e($pedido->status===$s?'selected':''); ?>><?php echo e(str_replace('_',' ',ucfirst($s))); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center">💾 Atualizar</button>
            </form>
        </div>
        <?php endif; ?>

        <a href="<?php echo e(route('dashboard.pedidos')); ?>" class="btn btn-secondary">← Voltar aos Pedidos</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project_corrigido\resources\views/orders/show.blade.php ENDPATH**/ ?>