<?php $__env->startSection('page-title', 'Controle de Estoque'); ?>
<?php $__env->startSection('breadcrumb', 'Entradas, saídas e saldo'); ?>

<?php $__env->startSection('styles'); ?>
<style>
.est-tabs { display:flex; gap:8px; margin-bottom:20px; flex-wrap:wrap; }
.est-tab  { padding:7px 16px; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer; border:1px solid var(--border); background:var(--bg2); color:var(--muted); transition:.15s; }
.est-tab.on { background:rgba(249,115,22,.12); color:var(--accent); border-color:rgba(249,115,22,.3); }
.est-sec { display:none; } .est-sec.on { display:block; }
.mov-entrada { color:#4ade80; } .mov-saida { color:#f87171; } .mov-ajuste { color:#fbbf24; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="panel" style="margin-bottom:20px">
    <form method="GET" style="display:flex;gap:14px;align-items:flex-end;flex-wrap:wrap">
        <div class="form-group" style="margin:0;flex:1;min-width:150px"><label>Início</label><input type="date" name="data_inicio" class="form-control" value="<?php echo e($di->format('Y-m-d')); ?>"></div>
        <div class="form-group" style="margin:0;flex:1;min-width:150px"><label>Fim</label><input type="date" name="data_fim" class="form-control" value="<?php echo e($df->format('Y-m-d')); ?>"></div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filtrar</button>
        <a href="<?php echo e(route('controle.estoque')); ?>" class="btn btn-secondary">Últimos 30 dias</a>
    </form>
</div>


<div class="cards-grid" style="grid-template-columns:repeat(auto-fill,minmax(180px,1fr));margin-bottom:22px">
    <div class="stat-card" style="--card-color:#22c55e">
        <div class="sc-header"><div class="sc-icon"><i class="fas fa-arrow-down"></i></div><span class="sc-badge">Período</span></div>
        <div class="sc-value" style="font-size:20px;color:#4ade80"><?php echo e(number_format($totalEntradas,3,',','.')); ?></div>
        <div class="sc-label">Total de Entradas</div>
    </div>
    <div class="stat-card" style="--card-color:#ef4444">
        <div class="sc-header"><div class="sc-icon"><i class="fas fa-arrow-up"></i></div><span class="sc-badge">Período</span></div>
        <div class="sc-value" style="font-size:20px;color:#f87171"><?php echo e(number_format($totalSaidas,3,',','.')); ?></div>
        <div class="sc-label">Total de Saídas</div>
    </div>
    <div class="stat-card" style="--card-color:#3b82f6">
        <div class="sc-header"><div class="sc-icon"><i class="fas fa-boxes"></i></div><span class="sc-badge">Atual</span></div>
        <div class="sc-value" style="font-size:18px">R$ <?php echo e(number_format($valorEstoque,2,',','.')); ?></div>
        <div class="sc-label">Valor em Estoque</div>
    </div>
    <div class="stat-card" style="--card-color:#a855f7">
        <div class="sc-header"><div class="sc-icon"><i class="fas fa-box"></i></div><span class="sc-badge">Total</span></div>
        <div class="sc-value"><?php echo e($itens->count()); ?></div>
        <div class="sc-label">Produtos Cadastrados</div>
    </div>
</div>


<div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-bottom:22px">
    <div class="panel">
        <div class="panel-header"><div class="panel-title" style="color:#4ade80"><i class="fas fa-arrow-down"></i> Registrar Entrada</div></div>
        <form method="POST" action="<?php echo e(route('controle.estoque.entrada')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label>Produto</label>
                <select name="stock_item_id" id="sel-entrada" class="form-select" required onchange="setUnit(this,'entrada-unit','entrada-conv','entrada-qty')">
                    <option value="">— Selecione —</option>
                    <?php $__currentLoopData = $itens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($item->id); ?>" data-unit="<?php echo e($item->unidade); ?>"><?php echo e($item->nome); ?> (<?php echo e($item->unidade); ?>) — Atual: <?php echo e(number_format($item->quantidade_atual,3,',','.')); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group">
                <label>Quantidade</label>
                <input type="number" name="quantidade" id="entrada-qty" step="0.001" min="0.001" max="9999999" class="form-control" placeholder="0,000" required
                       oninput="previewConversao(this,'entrada-conv','entrada-unit')">
                <div id="entrada-conv" style="font-size:11px;color:#fbbf24;margin-top:4px;display:none"></div>
            </div>
            <button type="submit" class="btn btn-success" style="width:100%;justify-content:center">
                <i class="fas fa-plus-circle"></i> Registrar Entrada
            </button>
        </form>
    </div>

    <div class="panel">
        <div class="panel-header"><div class="panel-title" style="color:#f87171"><i class="fas fa-arrow-up"></i> Registrar Saída</div></div>
        <form method="POST" action="<?php echo e(route('controle.estoque.saida')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label>Produto</label>
                <select name="stock_item_id" id="sel-saida" class="form-select" required onchange="setUnit(this,'saida-unit','saida-conv','saida-qty')">
                    <option value="">— Selecione —</option>
                    <?php $__currentLoopData = $itens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($item->id); ?>" data-unit="<?php echo e($item->unidade); ?>"><?php echo e($item->nome); ?> (<?php echo e($item->unidade); ?>) — Atual: <?php echo e(number_format($item->quantidade_atual,3,',','.')); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group">
                <label>Quantidade</label>
                <input type="number" name="quantidade" id="saida-qty" step="0.001" min="0.001" max="9999999" class="form-control" placeholder="0,000" required
                       oninput="previewConversao(this,'saida-conv','saida-unit')">
                <div id="saida-conv" style="font-size:11px;color:#fbbf24;margin-top:4px;display:none"></div>
            </div>
            <div class="form-group">
                <label>Motivo</label>
                <input type="text" name="motivo" class="form-control" placeholder="Ex: Vencimento, Quebra, Uso...">
            </div>
            <button type="submit" class="btn btn-danger" style="width:100%;justify-content:center">
                <i class="fas fa-minus-circle"></i> Registrar Saída
            </button>
        </form>
    </div>
</div>


<div class="est-tabs">
    <button class="est-tab on" onclick="showEst('saldo',this)">📊 Saldo Atual</button>
    <button class="est-tab" onclick="showEst('entradas',this)">➕ Entradas</button>
    <button class="est-tab" onclick="showEst('saidas',this)">➖ Saídas</button>
    <button class="est-tab" onclick="showEst('ajustes',this)">🔧 Ajustes</button>
</div>


<div class="est-sec on" id="est-saldo">
    <div class="table-wrap">
        <div class="table-header"><h2><i class="fas fa-balance-scale"></i> Saldo de Estoque por Produto</h2></div>
        <table>
            <thead><tr><th>Produto</th><th>Entradas (período)</th><th>Saídas (período)</th><th>Saldo Atual</th><th>Valor</th><th>Status</th></tr></thead>
            <tbody>
            <?php $__currentLoopData = $saldo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $alerta = $s['item']->quantidade_atual <= $s['item']->quantidade_minima; ?>
            <tr>
                <td class="td-primary"><?php echo e($s['item']->nome); ?><div style="font-size:11px;color:var(--muted)"><?php echo e($s['item']->unidade); ?></div></td>
                <td class="td-mono mov-entrada">+<?php echo e(number_format($s['entradas'],3,',','.')); ?></td>
                <td class="td-mono mov-saida">-<?php echo e(number_format($s['saidas'],3,',','.')); ?></td>
                <td class="td-mono" style="color:<?php echo e($alerta?'#f87171':'#4ade80'); ?>;font-weight:800;font-size:15px"><?php echo e(number_format($s['saldo'],3,',','.')); ?></td>
                <td class="td-mono" style="color:var(--muted)">R$ <?php echo e(number_format($s['valor'],2,',','.')); ?></td>
                <td>
                    <?php if($s['item']->quantidade_atual <= 0): ?> <span class="badge badge-danger">Esgotado</span>
                    <?php elseif($alerta): ?> <span class="badge badge-warning">Baixo</span>
                    <?php else: ?> <span class="badge badge-success">OK</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>


<div class="est-sec" id="est-entradas">
    <div class="table-wrap">
        <div class="table-header"><h2><i class="fas fa-arrow-down"></i> Histórico de Entradas (<?php echo e($entradas->count()); ?>)</h2></div>
        <?php if($entradas->isEmpty()): ?> <div class="empty-state"><p>Sem entradas no período</p></div>
        <?php else: ?>
        <table>
            <thead><tr><th>Data/Hora</th><th>Produto</th><th>Quantidade</th><th>Antes</th><th>Depois</th><th>Motivo</th><th>Usuário</th></tr></thead>
            <tbody>
            <?php $__currentLoopData = $entradas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td style="font-size:12px;color:var(--muted)"><?php echo e($m->created_at->format('d/m H:i')); ?></td>
                <td class="td-primary"><?php echo e($m->stockItem->nome ?? '—'); ?></td>
                <td class="td-mono mov-entrada" style="font-weight:700">+<?php echo e(number_format($m->quantidade,3,',','.')); ?></td>
                <td class="td-mono" style="color:var(--muted)"><?php echo e(number_format($m->quantidade_anterior,3,',','.')); ?></td>
                <td class="td-mono" style="color:#4ade80"><?php echo e(number_format($m->quantidade_nova,3,',','.')); ?></td>
                <td style="font-size:12px;color:var(--muted)"><?php echo e($m->motivo ?? '—'); ?></td>
                <td style="font-size:12px;color:var(--muted)"><?php echo e($m->user->name ?? '—'); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>


<div class="est-sec" id="est-saidas">
    <div class="table-wrap">
        <div class="table-header"><h2><i class="fas fa-arrow-up"></i> Histórico de Saídas (<?php echo e($saidas->count()); ?>)</h2></div>
        <?php if($saidas->isEmpty()): ?> <div class="empty-state"><p>Sem saídas no período</p></div>
        <?php else: ?>
        <table>
            <thead><tr><th>Data/Hora</th><th>Produto</th><th>Quantidade</th><th>Antes</th><th>Depois</th><th>Motivo</th><th>Usuário</th></tr></thead>
            <tbody>
            <?php $__currentLoopData = $saidas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td style="font-size:12px;color:var(--muted)"><?php echo e($m->created_at->format('d/m H:i')); ?></td>
                <td class="td-primary"><?php echo e($m->stockItem->nome ?? '—'); ?></td>
                <td class="td-mono mov-saida" style="font-weight:700">-<?php echo e(number_format($m->quantidade,3,',','.')); ?></td>
                <td class="td-mono" style="color:var(--muted)"><?php echo e(number_format($m->quantidade_anterior,3,',','.')); ?></td>
                <td class="td-mono" style="color:#f87171"><?php echo e(number_format($m->quantidade_nova,3,',','.')); ?></td>
                <td style="font-size:12px;color:var(--muted)"><?php echo e($m->motivo ?? '—'); ?></td>
                <td style="font-size:12px;color:var(--muted)"><?php echo e($m->user->name ?? '—'); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>


<div class="est-sec" id="est-ajustes">
    <div class="table-wrap">
        <div class="table-header"><h2><i class="fas fa-sliders-h"></i> Ajustes Manuais (<?php echo e($ajustes->count()); ?>)</h2></div>
        <?php if($ajustes->isEmpty()): ?> <div class="empty-state"><p>Sem ajustes no período</p></div>
        <?php else: ?>
        <table>
            <thead><tr><th>Data/Hora</th><th>Produto</th><th>Antes</th><th>Depois</th><th>Diferença</th><th>Motivo</th></tr></thead>
            <tbody>
            <?php $__currentLoopData = $ajustes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $diff = $m->quantidade_nova - $m->quantidade_anterior; ?>
            <tr>
                <td style="font-size:12px;color:var(--muted)"><?php echo e($m->created_at->format('d/m H:i')); ?></td>
                <td class="td-primary"><?php echo e($m->stockItem->nome ?? '—'); ?></td>
                <td class="td-mono" style="color:var(--muted)"><?php echo e(number_format($m->quantidade_anterior,3,',','.')); ?></td>
                <td class="td-mono"><?php echo e(number_format($m->quantidade_nova,3,',','.')); ?></td>
                <td class="td-mono" style="color:<?php echo e($diff>=0?'#4ade80':'#f87171'); ?>;font-weight:700"><?php echo e($diff>=0?'+':''); ?><?php echo e(number_format($diff,3,',','.')); ?></td>
                <td style="font-size:12px;color:var(--muted)"><?php echo e($m->motivo ?? '—'); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function showEst(id, btn) {
    document.querySelectorAll('.est-sec').forEach(s => s.classList.remove('on'));
    document.querySelectorAll('.est-tab').forEach(b => b.classList.remove('on'));
    document.getElementById('est-' + id).classList.add('on');
    btn.classList.add('on');
}
</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
// Armazena a unidade do produto selecionado
const unitMap = { entrada: 'un', saida: 'un' };

function setUnit(selectEl, unitKey, convId, qtyId) {
    const opt = selectEl.options[selectEl.selectedIndex];
    const unit = opt ? (opt.dataset.unit || 'un') : 'un';
    unitMap[unitKey] = unit;
    // reset preview
    const convEl = document.getElementById(convId);
    if (convEl) convEl.style.display = 'none';
    // re-run preview if qty already filled
    const qtyEl = document.getElementById(qtyId);
    if (qtyEl && qtyEl.value) previewConversao(qtyEl, convId, unitKey);
}

function previewConversao(input, convId, unitKey) {
    const conv = document.getElementById(convId);
    if (!conv) return;
    const val = parseFloat(input.value);
    if (!val || val <= 0) { conv.style.display = 'none'; return; }

    const unit = unitMap[unitKey] || 'un';

    let msg = null;
    if (unit === 'g' && val >= 1000) {
        const kg = (val / 1000).toFixed(3).replace(/\.?0+$/, '');
        msg = `⚡ Será convertido automaticamente: ${val}g → ${kg} kg`;
    } else if (unit === 'ml' && val >= 1000) {
        const L = (val / 1000).toFixed(3).replace(/\.?0+$/, '');
        msg = `⚡ Será convertido automaticamente: ${val}ml → ${L} L`;
    }

    if (msg) {
        conv.textContent = msg;
        conv.style.display = 'block';
    } else {
        conv.style.display = 'none';
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project_corrigido\resources\views/controle/estoque.blade.php ENDPATH**/ ?>