<?php $__env->startSection('page-title', 'Estoque'); ?>
<?php $__env->startSection('breadcrumb', 'Controle de inventário'); ?>

<?php $__env->startSection('styles'); ?>
<style>
.unidade-badge {
    padding:2px 8px; border-radius:6px; font-size:11px; font-weight:700;
    background:rgba(99,102,241,.15); color:#818cf8;
}
.qtd-display { font-family:monospace; font-weight:800; font-size:15px; }
.qtd-display.ok     { color:#4ade80; }
.qtd-display.alerta { color:#f87171; }
.form-ajuste {
    display:none; margin-top:10px; padding:14px;
    background:var(--bg3); border-radius:10px; border:1px solid var(--border);
}
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php if($estoqueAlerta->isNotEmpty()): ?>
<div class="alert alert-warning">
    ⚠️ <span><strong><?php echo e($estoqueAlerta->count()); ?> item(s)</strong> abaixo do estoque mínimo — reposição necessária!</span>
</div>
<?php endif; ?>

<div class="table-wrap">
    <div class="table-header">
        <h2>📦 Inventário (<?php echo e($itens->count()); ?> itens)</h2>
        <input type="text" id="stock-search" placeholder="Buscar item..."
               class="form-control" style="width:220px; padding:7px 12px; font-size:13px">
    </div>
    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantidade Atual</th>
                <th>Mínimo</th>
                <th>Unidade</th>
                <th>Preço Unit.</th>
                <th>Status</th>
                <th>Ajuste</th>
            </tr>
        </thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $itens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
            $alerta = $item->quantidade_atual <= $item->quantidade_minima;
            // Unidades de peso usam gramas/kg; resto usa unidade
            $unidadesPeso = ['kg', 'g', 'gramas', 'grama'];
            $unidadesVolume = ['l', 'ml', 'litro', 'litros'];
            $isPeso   = in_array(strtolower($item->unidade), $unidadesPeso);
            $isVolume = in_array(strtolower($item->unidade), $unidadesVolume);

            // Exibição inteligente
            if ($isPeso) {
                if ($item->quantidade_atual >= 1) {
                    $qtdDisplay = number_format($item->quantidade_atual, 3, ',', '.') . ' kg';
                    $minDisplay = number_format($item->quantidade_minima, 3, ',', '.') . ' kg';
                } else {
                    $qtdDisplay = number_format($item->quantidade_atual * 1000, 0, ',', '.') . ' g';
                    $minDisplay = number_format($item->quantidade_minima * 1000, 0, ',', '.') . ' g';
                }
            } elseif ($isVolume) {
                if ($item->quantidade_atual >= 1) {
                    $qtdDisplay = number_format($item->quantidade_atual, 2, ',', '.') . ' L';
                    $minDisplay = number_format($item->quantidade_minima, 2, ',', '.') . ' L';
                } else {
                    $qtdDisplay = number_format($item->quantidade_atual * 1000, 0, ',', '.') . ' mL';
                    $minDisplay = number_format($item->quantidade_minima * 1000, 0, ',', '.') . ' mL';
                }
            } else {
                $qtdDisplay = number_format($item->quantidade_atual, 0, ',', '.') . ' un';
                $minDisplay = number_format($item->quantidade_minima, 0, ',', '.') . ' un';
            }
        ?>
        <tr class="stock-row" data-nome="<?php echo e(strtolower($item->nome)); ?>">
            <td>
                <div class="td-primary" style="font-weight:600"><?php echo e($item->nome); ?></div>
            </td>
            <td>
                <span class="qtd-display <?php echo e($alerta ? 'alerta' : 'ok'); ?>">
                    <?php echo e($qtdDisplay); ?>

                </span>
            </td>
            <td style="color:var(--muted); font-family:monospace; font-size:13px">
                <?php echo e($minDisplay); ?>

            </td>
            <td>
                <span class="unidade-badge"><?php echo e($item->unidade); ?></span>
            </td>
            <td class="td-mono">R$ <?php echo e(number_format($item->preco_unitario, 2, ',', '.')); ?></td>
            <td>
                <?php if($item->quantidade_atual <= 0): ?>
                    <span class="badge badge-danger">Esgotado</span>
                <?php elseif($alerta): ?>
                    <span class="badge badge-warning">Estoque baixo</span>
                <?php else: ?>
                    <span class="badge badge-success">Normal</span>
                <?php endif; ?>
            </td>
            <td>
                <button class="btn btn-secondary btn-sm" onclick="toggleForm('form-<?php echo e($item->id); ?>')">
                    ✏️ Ajustar
                </button>
                <div id="form-<?php echo e($item->id); ?>" class="form-ajuste">
                    <form method="POST" action="<?php echo e(route('estoque.movimento', $item)); ?>"
                          style="display:flex; gap:8px; align-items:flex-end; flex-wrap:wrap">
                        <?php echo csrf_field(); ?>
                        <div class="form-group" style="margin:0; min-width:100px">
                            <label style="font-size:10px; text-transform:uppercase; letter-spacing:.5px">Tipo</label>
                            <select name="tipo" class="form-select" style="font-size:12px; padding:7px 10px" required>
                                <option value="entrada">➕ Entrada</option>
                                <option value="saida">➖ Saída</option>
                                <option value="ajuste">🔧 Ajuste</option>
                            </select>
                        </div>
                        <div class="form-group" style="margin:0; min-width:110px">
                            <label style="font-size:10px; text-transform:uppercase; letter-spacing:.5px">
                                Quantidade
                                <?php if($isPeso): ?>
                                <span style="color:var(--accent)">(kg)</span>
                                <?php elseif($isVolume): ?>
                                <span style="color:var(--accent)">(L)</span>
                                <?php else: ?>
                                <span style="color:var(--accent)">(un)</span>
                                <?php endif; ?>
                            </label>
                            <input type="number" name="quantidade"
                                   step="<?php echo e($isPeso || $isVolume ? '0.001' : '1'); ?>"
                                   min="<?php echo e($isPeso || $isVolume ? '0.001' : '1'); ?>"
                                   max="99999"
                                   class="form-control" style="font-size:12px; padding:7px 10px" required>
                        </div>
                        <div class="form-group" style="margin:0; flex:1; min-width:130px">
                            <label style="font-size:10px; text-transform:uppercase; letter-spacing:.5px">Motivo</label>
                            <input type="text" name="motivo" class="form-control"
                                   style="font-size:12px; padding:7px 10px" placeholder="Motivo...">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                        <button type="button" class="btn btn-secondary btn-sm"
                                onclick="toggleForm('form-<?php echo e($item->id); ?>')">×</button>
                    </form>
                </div>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="7">
            <div class="empty-state">📦<p>Nenhum item cadastrado</p></div>
        </td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function toggleForm(id) {
    const el = document.getElementById(id);
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}
document.getElementById('stock-search').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.stock-row').forEach(row => {
        row.style.display = row.dataset.nome.includes(q) ? '' : 'none';
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project_corrigido\resources\views/dashboard/estoque.blade.php ENDPATH**/ ?>