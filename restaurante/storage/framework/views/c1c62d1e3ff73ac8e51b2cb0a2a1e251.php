<?php $__env->startSection('page-title', 'Vendas'); ?>
<?php $__env->startSection('breadcrumb', 'Relatório de vendas do mês'); ?>
<?php $__env->startSection('content'); ?>
<div class="cards-grid" style="grid-template-columns:repeat(2,1fr)">
    <div class="stat-card" style="--card-color:#22c55e">
        <div class="sc-header"><div class="sc-icon"></div><span class="sc-badge">Hoje</span></div>
        <div class="sc-value">R$ <?php echo e(number_format($totalHoje,2,',','.')); ?></div>
        <div class="sc-label">Total de hoje</div>
    </div>
    <div class="stat-card" style="--card-color:#3b82f6">
        <div class="sc-header"><div class="sc-icon"></div><span class="sc-badge">Mês</span></div>
        <div class="sc-value">R$ <?php echo e(number_format($totalMes,2,',','.')); ?></div>
        <div class="sc-label">Total do mês</div>
    </div>
</div>
<div class="table-wrap">
    <div class="table-header"><h2>📈 Vendas do Mês (<?php echo e($vendas->count()); ?>)</h2></div>
    <?php if($vendas->isEmpty()): ?>
        <div class="empty-state">📈<p>Nenhuma venda este mês</p></div>
    <?php else: ?>
    <table>
        <thead><tr><th>Data</th><th>Pedido</th><th>Método</th><th>Valor</th><th>Status</th></tr></thead>
        <tbody>
        <?php $__currentLoopData = $vendas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td style="color:var(--muted); font-size:12px"><?php echo e($v->created_at->format('d/m/Y H:i')); ?></td>
            <td class="td-mono td-primary">#<?php echo e(str_pad($v->order_id,4,'0',STR_PAD_LEFT)); ?></td>
            <td>
                <?php
                    $icones = ['dinheiro'=>'💵','cartao_credito'=>'💳','cartao_debito'=>'💳','pix'=>'📱'];
                    $icone  = $icones[$v->metodo] ?? '';
                    $label  = ucfirst(str_replace('_', ' ', $v->metodo));
                ?>
                <?php echo e($icone); ?> <?php echo e($label); ?>

            </td>
            <td class="td-mono" style="color:#4ade80; font-weight:700">R$ <?php echo e(number_format($v->valor_final,2,',','.')); ?></td>
            <td><span class="badge badge-<?php echo e($v->status==='confirmado'?'success':'warning'); ?>"><?php echo e(ucfirst($v->status)); ?></span></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project_corrigido\resources\views/dashboard/vendas.blade.php ENDPATH**/ ?>