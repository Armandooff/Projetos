<?php $__env->startSection('page-title', 'Pagar Mesa'); ?>
<?php $__env->startSection('breadcrumb', 'Selecione a mesa para processar pagamento'); ?>
<?php $__env->startSection('content'); ?>
<div class="mesas-grid">
    <?php $__empty_1 = true; $__currentLoopData = $mesas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mesa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php $pedidos = $mesa->orders; ?>
    <div class="mesa-card <?php echo e($pedidos->isNotEmpty() ? 'ocupada' : 'disponivel'); ?>" style="cursor:default">
        <div class="mc-number"><?php echo e($mesa->numero); ?></div>
        <div class="mc-seats"><?php echo e($mesa->assentos); ?> lugares</div>
        <?php if($pedidos->isNotEmpty()): ?>
            <span class="badge badge-danger" style="margin:6px 0"><?php echo e($pedidos->count()); ?> pedido(s)</span>
            <?php $__currentLoopData = $pedidos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div style="margin-top:8px; background:var(--bg3); border-radius:10px; padding:12px; font-size:13px; text-align:left">
                <div style="display:flex; justify-content:space-between; margin-bottom:6px">
                    <span class="td-mono" style="color:var(--accent); font-weight:700">#<?php echo e(str_pad($p->id,4,'0',STR_PAD_LEFT)); ?></span>
                    <strong>R$ <?php echo e(number_format($p->total,2,',','.')); ?></strong>
                </div>
                <span class="badge badge-<?php echo e($p->status==='pronto_entrega'?'success':'warning'); ?>"><?php echo e(str_replace('_',' ',ucfirst($p->status))); ?></span>
                <?php if($p->status==='pronto_entrega'): ?>
                <form method="POST" action="<?php echo e(route('caixa.pagamento',$p)); ?>" style="margin-top:10px">
                    <?php echo csrf_field(); ?>
                    <select name="metodo" class="form-select" style="font-size:12px; padding:6px; margin-bottom:8px" required>
                        <option value="dinheiro">💵 Dinheiro</option>
                        <option value="cartao_credito">💳 Crédito</option>
                        <option value="cartao_debito">💳 Débito</option>
                        <option value="pix">📱 PIX</option>
                    </select>
                    <input type="hidden" name="valor_pago" value="<?php echo e($p->total); ?>">
                    <button type="submit" class="btn btn-success btn-sm" style="width:100%; justify-content:center">✓ Confirmar Pag.</button>
                </form>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <span class="badge badge-success" style="margin-top:8px">Livre</span>
        <?php endif; ?>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="empty-state" style="grid-column:1/-1">🪑<p>Nenhuma mesa cadastrada</p></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project_corrigido\resources\views/caixa/pagar-mesa.blade.php ENDPATH**/ ?>