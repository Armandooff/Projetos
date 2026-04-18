<?php $__env->startSection('page-title', 'Pedidos'); ?>
<?php $__env->startSection('breadcrumb', 'Histórico e gestão de pedidos'); ?>
<?php $__env->startSection('content'); ?>

<div class="table-wrap">
    <div class="table-header">
        <h2>🧾 Todos os Pedidos</h2>
        <div style="display:flex; gap:10px; align-items:center">
            <select id="filter-status" class="form-select" style="width:180px; font-size:13px; padding:7px 12px">
                <option value="">Todos os status</option>
                <option value="em_preparo">Em Preparo</option>
                <option value="pronto_entrega">Pronto p/ Entrega</option>
                <option value="entregue">Entregue</option>
                <option value="pago">Pago</option>
                <option value="cancelado">Cancelado</option>
            </select>
            <?php if(Auth::user()->role === 'garcom'): ?>
            <a href="<?php echo e(route('orders.create')); ?>" class="btn btn-primary btn-sm">➕ Novo</a>
            <?php endif; ?>
        </div>
    </div>
    <?php if($pedidos->isEmpty()): ?>
        <div class="empty-state">🧾<p>Nenhum pedido encontrado</p></div>
    <?php else: ?>
    <table>
        <thead>
            <tr><th>#</th><th>Mesa</th><th>Garçom</th><th>Itens</th><th>Total</th><th>Status</th><th>Horário</th><th></th></tr>
        </thead>
        <tbody id="pedidos-table">
        <?php $__currentLoopData = $pedidos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $cores = ['em_preparo'=>'warning','pronto_entrega'=>'success','pago'=>'info','cancelado'=>'danger','entregue'=>'secondary','aberto'=>'primary']; ?>
        <tr class="pedido-row" data-status="<?php echo e($p->status); ?>" onclick="window.location='<?php echo e(route('orders.show', $p)); ?>'" style="cursor:pointer">
            <td class="td-mono td-primary">#<?php echo e(str_pad($p->id,4,'0',STR_PAD_LEFT)); ?></td>
            <td>Mesa <?php echo e($p->table->numero ?? '—'); ?></td>
            <td style="color:var(--muted)"><?php echo e($p->user->name ?? '—'); ?></td>
            <td><span class="badge badge-secondary"><?php echo e($p->items->count()); ?></span></td>
            <td class="td-mono">R$ <?php echo e(number_format($p->total,2,',','.')); ?></td>
            <td><span class="badge badge-<?php echo e($cores[$p->status] ?? 'secondary'); ?>"><?php echo e(str_replace('_',' ',ucfirst($p->status))); ?></span></td>
            <td style="color:var(--muted); font-size:12px"><?php echo e($p->created_at->format('d/m H:i')); ?></td>
            <td onclick="event.stopPropagation()">
                <a href="<?php echo e(route('orders.show', $p)); ?>" class="btn btn-secondary btn-sm btn-icon">👁</a>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
document.getElementById('filter-status').addEventListener('change', function() {
    const v = this.value;
    document.querySelectorAll('.pedido-row').forEach(row => {
        row.style.display = !v || row.dataset.status === v ? '' : 'none';
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project_corrigido\resources\views/dashboard/pedidos.blade.php ENDPATH**/ ?>