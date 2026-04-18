<?php $__env->startSection('page-title', 'Relatórios'); ?>
<?php $__env->startSection('breadcrumb', 'Análise gerencial por período'); ?>

<?php $__env->startSection('styles'); ?>
<style>
.rel-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:14px; margin-bottom:24px; }
.rel-card { background:var(--bg2); border:1px solid var(--border); border-radius:12px; padding:18px; position:relative; overflow:hidden; }
.rel-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:var(--cc,var(--accent)); }
.rel-card-label { font-size:12px; color:var(--muted); margin-bottom:6px; }
.rel-card-value { font-size:22px; font-weight:800; color:#fff; }
.rel-card-sub   { font-size:12px; color:var(--muted); margin-top:4px; }

.rank-row { display:flex; align-items:center; gap:12px; padding:10px 0; border-bottom:1px solid rgba(255,255,255,.05); }
.rank-row:last-child { border-bottom:none; }
.rank-num { width:24px; height:24px; border-radius:6px; background:rgba(249,115,22,.15); color:var(--accent); font-size:11px; font-weight:800; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.rank-bar-bg { flex:1; height:6px; background:rgba(255,255,255,.06); border-radius:3px; overflow:hidden; }
.rank-bar    { height:100%; background:var(--accent); border-radius:3px; transition:.4s; }

.metodo-row { display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid rgba(255,255,255,.05); }
.metodo-row:last-child { border-bottom:none; }

.chart-wrap { display:flex; align-items:flex-end; gap:4px; height:120px; margin-top:12px; }
.chart-bar-col { flex:1; display:flex; flex-direction:column; align-items:center; gap:4px; min-width:0; }
.chart-bar-col .bar { width:100%; background:rgba(249,115,22,.5); border-radius:4px 4px 0 0; transition:.4s; min-height:4px; }
.chart-bar-col .bar:hover { background:var(--accent); }
.chart-bar-col .lbl { font-size:9px; color:var(--muted); text-align:center; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; width:100%; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<div class="panel" style="margin-bottom:20px">
    <form method="GET" action="<?php echo e(route('dashboard.relatorios')); ?>"
          style="display:flex; gap:14px; align-items:flex-end; flex-wrap:wrap">
        <div class="form-group" style="margin:0; flex:1; min-width:150px">
            <label>Data Início</label>
            <input type="date" name="data_inicio" class="form-control"
                   value="<?php echo e($dataInicio->format('Y-m-d')); ?>">
        </div>
        <div class="form-group" style="margin:0; flex:1; min-width:150px">
            <label>Data Fim</label>
            <input type="date" name="data_fim" class="form-control"
                   value="<?php echo e($dataFim->format('Y-m-d')); ?>">
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filtrar</button>
        <a href="<?php echo e(route('dashboard.relatorios')); ?>" class="btn btn-secondary">Últimos 30 dias</a>
    </form>
</div>


<div class="rel-grid">
    <div class="rel-card" style="--cc:#22c55e">
        <div class="rel-card-label">💰 Faturamento</div>
        <div class="rel-card-value">R$ <?php echo e(number_format($totalVendas,2,',','.')); ?></div>
        <div class="rel-card-sub">Total no período</div>
    </div>
    <div class="rel-card" style="--cc:#ef4444">
        <div class="rel-card-label">🛒 Compras</div>
        <div class="rel-card-value">R$ <?php echo e(number_format($totalCompras,2,',','.')); ?></div>
        <div class="rel-card-sub">Custo de estoque</div>
    </div>
    <div class="rel-card" style="--cc:#f97316">
        <div class="rel-card-label">💸 Sangrias</div>
        <div class="rel-card-value">R$ <?php echo e(number_format($totalSangrias,2,',','.')); ?></div>
        <div class="rel-card-sub">Retiradas do caixa</div>
    </div>
    <div class="rel-card" style="--cc:<?php echo e($lucroEstimado >= 0 ? '#4ade80' : '#f87171'); ?>">
        <div class="rel-card-label">📈 Lucro Estimado</div>
        <div class="rel-card-value" style="color:<?php echo e($lucroEstimado >= 0 ? '#4ade80' : '#f87171'); ?>">
            R$ <?php echo e(number_format($lucroEstimado,2,',','.')); ?>

        </div>
        <div class="rel-card-sub">Vendas − compras − sangrias</div>
    </div>
    <div class="rel-card" style="--cc:#3b82f6">
        <div class="rel-card-label">🧾 Pedidos</div>
        <div class="rel-card-value"><?php echo e($totalPedidos); ?></div>
        <div class="rel-card-sub"><?php echo e($pedidosCancelados); ?> cancelado(s)</div>
    </div>
    <div class="rel-card" style="--cc:#a855f7">
        <div class="rel-card-label">🎯 Ticket Médio</div>
        <div class="rel-card-value">R$ <?php echo e(number_format($ticketMedio,2,',','.')); ?></div>
        <div class="rel-card-sub">Por pagamento</div>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px">

    
    <div class="panel" style="margin:0">
        <div class="panel-header">
            <div class="panel-title"><i class="fas fa-trophy"></i> Itens Mais Vendidos</div>
        </div>
        <?php $maxQtd = $itensMaisVendidos->max('quantidade') ?: 1; ?>
        <?php $__empty_1 = true; $__currentLoopData = $itensMaisVendidos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="rank-row">
            <div class="rank-num"><?php echo e($i+1); ?></div>
            <div style="flex:1; min-width:0">
                <div style="font-size:13px; font-weight:600; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis"><?php echo e($item['nome']); ?></div>
                <div class="rank-bar-bg" style="margin-top:5px">
                    <div class="rank-bar" style="width:<?php echo e(($item['quantidade']/$maxQtd)*100); ?>%"></div>
                </div>
            </div>
            <div style="text-align:right; flex-shrink:0; margin-left:10px">
                <div style="font-weight:800; color:#fff"><?php echo e($item['quantidade']); ?>x</div>
                <div style="font-size:11px; color:var(--muted)">R$ <?php echo e(number_format($item['total'],2,',','.')); ?></div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="empty-state" style="padding:24px"><p>Sem dados no período</p></div>
        <?php endif; ?>
    </div>

    
    <div style="display:flex; flex-direction:column; gap:20px">

        <div class="panel" style="margin:0">
            <div class="panel-header">
                <div class="panel-title"><i class="fas fa-credit-card"></i> Forma de Pagamento</div>
            </div>
            <?php
                $metodoLabel = ['dinheiro'=>'💵 Dinheiro','cartao_credito'=>'💳 Crédito','cartao_debito'=>'💳 Débito','pix'=>'📱 Pix'];
                $totalMetodo = $porMetodo->sum('total') ?: 1;
            ?>
            <?php $__empty_1 = true; $__currentLoopData = $porMetodo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $metodo => $dados): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="metodo-row">
                <div>
                    <div style="font-weight:600; color:#fff; font-size:13px"><?php echo e($metodoLabel[$metodo] ?? $metodo); ?></div>
                    <div style="font-size:11px; color:var(--muted)"><?php echo e($dados['qtd']); ?> pagamento(s)</div>
                </div>
                <div style="text-align:right">
                    <div style="font-weight:800; color:#4ade80">R$ <?php echo e(number_format($dados['total'],2,',','.')); ?></div>
                    <div style="font-size:11px; color:var(--muted)"><?php echo e(number_format(($dados['total']/$totalMetodo)*100,1)); ?>%</div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty-state" style="padding:20px"><p>Sem pagamentos</p></div>
            <?php endif; ?>
        </div>

        <div class="panel" style="margin:0">
            <div class="panel-header">
                <div class="panel-title"><i class="fas fa-concierge-bell"></i> Desempenho Garçons</div>
            </div>
            <?php $__empty_1 = true; $__currentLoopData = $porGarcom; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="metodo-row">
                <div>
                    <div style="font-weight:600; color:#fff; font-size:13px"><?php echo e($g['nome']); ?></div>
                    <div style="font-size:11px; color:var(--muted)"><?php echo e($g['pedidos']); ?> pedido(s)</div>
                </div>
                <div style="font-weight:800; color:var(--accent)">R$ <?php echo e(number_format($g['total'],2,',','.')); ?></div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty-state" style="padding:20px"><p>Sem dados</p></div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px">

    
    <div class="panel" style="margin:0">
        <div class="panel-header">
            <div class="panel-title"><i class="fas fa-chart-bar"></i> Vendas por Dia</div>
            <span style="font-size:12px; color:var(--muted)">R$ <?php echo e(number_format($totalVendas,2,',','.')); ?> total</span>
        </div>
        <?php if($vendasPorDia->isEmpty()): ?>
        <div class="empty-state" style="padding:24px"><p>Sem dados no período</p></div>
        <?php else: ?>
        <?php $maxVenda = $vendasPorDia->max() ?: 1; ?>
        <div class="chart-wrap">
            <?php $__currentLoopData = $vendasPorDia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dia => $valor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="chart-bar-col">
                <div class="bar" style="height:<?php echo e(($valor/$maxVenda)*100); ?>px" title="<?php echo e($dia); ?>: R$ <?php echo e(number_format($valor,2,',','.')); ?>"></div>
                <div class="lbl"><?php echo e($dia); ?></div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
    </div>

    
    <div class="panel" style="margin:0">
        <div class="panel-header">
            <div class="panel-title"><i class="fas fa-chair"></i> Mesas Mais Usadas</div>
        </div>
        <?php $maxMesa = $porMesa->max('pedidos') ?: 1; ?>
        <?php $__empty_1 = true; $__currentLoopData = $porMesa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="rank-row">
            <div style="min-width:60px; font-weight:700; color:#fff; font-size:13px"><?php echo e($m['mesa']); ?></div>
            <div class="rank-bar-bg">
                <div class="rank-bar" style="width:<?php echo e(($m['pedidos']/$maxMesa)*100); ?>%"></div>
            </div>
            <div style="text-align:right; margin-left:10px; flex-shrink:0">
                <div style="font-weight:800; color:#fff"><?php echo e($m['pedidos']); ?>x</div>
                <div style="font-size:11px; color:var(--muted)">R$ <?php echo e(number_format($m['total'],2,',','.')); ?></div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="empty-state" style="padding:24px"><p>Sem dados</p></div>
        <?php endif; ?>
    </div>
</div>


<?php if($estoqueCritico->isNotEmpty()): ?>
<div class="panel">
    <div class="panel-header">
        <div class="panel-title" style="color:#f87171"><i class="fas fa-exclamation-triangle"></i> Estoque Crítico</div>
        <span class="badge badge-danger"><?php echo e($estoqueCritico->count()); ?> item(ns)</span>
    </div>
    <table>
        <thead><tr><th>Item</th><th>Atual</th><th>Mínimo</th><th>Situação</th></tr></thead>
        <tbody>
        <?php $__currentLoopData = $estoqueCritico; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td style="font-weight:600; color:#fff"><?php echo e($e->nome); ?></td>
            <td class="td-mono" style="color:#f87171; font-weight:700"><?php echo e(number_format($e->quantidade_atual,2,',','.')); ?> <?php echo e($e->unidade); ?></td>
            <td class="td-mono" style="color:var(--muted)"><?php echo e(number_format($e->quantidade_minima,2,',','.')); ?> <?php echo e($e->unidade); ?></td>
            <td><span class="badge badge-danger">⚠️ Repor</span></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php endif; ?>


<div class="table-wrap">
    <div class="table-header">
        <h2><i class="fas fa-list"></i> Pagamentos no Período</h2>
        <span class="badge badge-secondary"><?php echo e($pagamentos->count()); ?></span>
    </div>
    <?php if($pagamentos->isEmpty()): ?>
        <div class="empty-state"><p>Nenhum pagamento no período</p></div>
    <?php else: ?>
    <table>
        <thead><tr><th>Data</th><th>Pedido</th><th>Mesa</th><th>Método</th><th>Valor</th></tr></thead>
        <tbody>
        <?php $__currentLoopData = $pagamentos->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td style="color:var(--muted);font-size:12px"><?php echo e($pg->created_at->format('d/m/Y H:i')); ?></td>
            <td class="td-mono td-primary">#<?php echo e(str_pad($pg->order_id,4,'0',STR_PAD_LEFT)); ?></td>
            <td style="color:var(--muted)">Mesa <?php echo e($pg->order->table->numero ?? '—'); ?></td>
            <td>
                <?php $mi=['dinheiro'=>'💵','cartao_credito'=>'💳','cartao_debito'=>'💳','pix'=>'📱']; ?>
                <?php echo e($mi[$pg->metodo]??''); ?> <?php echo e(ucfirst(str_replace('_',' ',$pg->metodo))); ?>

            </td>
            <td class="td-mono" style="color:#4ade80;font-weight:700">R$ <?php echo e(number_format($pg->valor_final,2,',','.')); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project_corrigido\resources\views/dashboard/relatorios.blade.php ENDPATH**/ ?>