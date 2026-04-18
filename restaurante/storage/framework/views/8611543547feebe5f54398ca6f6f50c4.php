<?php $__env->startSection('page-title', 'Estoque — Chef'); ?>
<?php $__env->startSection('breadcrumb', 'Visão de ingredientes disponíveis'); ?>
<?php $__env->startSection('content'); ?>
<div class="table-wrap">
    <div class="table-header"><h2>📦 Ingredientes em Estoque</h2></div>
    <table>
        <thead><tr><th>Item</th><th>Disponível</th><th>Mínimo</th><th>Status</th></tr></thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $itens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
            $unidadesPeso   = ['kg','g','gramas','grama'];
            $unidadesVolume = ['l','ml','litro','litros'];
            $u = strtolower($item->unidade);
            $isPeso   = in_array($u, $unidadesPeso);
            $isVolume = in_array($u, $unidadesVolume);

            if ($isPeso) {
                $qtd = $item->quantidade_atual >= 1
                    ? number_format($item->quantidade_atual, 3, ',', '.') . ' kg'
                    : number_format($item->quantidade_atual * 1000, 0, ',', '.') . ' g';
                $min = $item->quantidade_minima >= 1
                    ? number_format($item->quantidade_minima, 3, ',', '.') . ' kg'
                    : number_format($item->quantidade_minima * 1000, 0, ',', '.') . ' g';
            } elseif ($isVolume) {
                $qtd = $item->quantidade_atual >= 1
                    ? number_format($item->quantidade_atual, 2, ',', '.') . ' L'
                    : number_format($item->quantidade_atual * 1000, 0, ',', '.') . ' mL';
                $min = $item->quantidade_minima >= 1
                    ? number_format($item->quantidade_minima, 2, ',', '.') . ' L'
                    : number_format($item->quantidade_minima * 1000, 0, ',', '.') . ' mL';
            } else {
                $qtd = number_format($item->quantidade_atual, 0, ',', '.') . ' un';
                $min = number_format($item->quantidade_minima, 0, ',', '.') . ' un';
            }
            $alerta = $item->quantidade_atual <= $item->quantidade_minima;
        ?>
        <tr>
            <td><div class="td-primary"><?php echo e($item->nome); ?></div></td>
            <td>
                <span style="font-family:monospace; font-weight:800; font-size:15px; color:<?php echo e($alerta ? '#f87171' : '#4ade80'); ?>">
                    <?php echo e($qtd); ?>

                </span>
            </td>
            <td class="td-mono" style="color:var(--muted)"><?php echo e($min); ?></td>
            <td>
                <?php if($item->quantidade_atual <= 0): ?>
                    <span class="badge badge-danger">Esgotado</span>
                <?php elseif($alerta): ?>
                    <span class="badge badge-warning">Estoque baixo</span>
                <?php else: ?>
                    <span class="badge badge-success">OK</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="4"><div class="empty-state">📦<p>Sem itens</p></div></td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project_corrigido\resources\views/dashboard/chef-estoque.blade.php ENDPATH**/ ?>