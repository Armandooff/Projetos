<?php $__env->startSection('page-title', 'Gerenciar Produtos'); ?>
<?php $__env->startSection('breadcrumb', 'Cadastro de insumos e estoque'); ?>
<?php $__env->startSection('styles'); ?>
<style>
.ger-tabs{display:flex;gap:8px;margin-bottom:24px;flex-wrap:wrap}
.ger-tab{padding:8px 18px;border-radius:8px;text-decoration:none;font-size:13px;font-weight:700;color:var(--muted);background:var(--bg2);border:1px solid var(--border);transition:.15s}
.ger-tab.active,.ger-tab:hover{background:rgba(249,115,22,.12);color:var(--accent);border-color:rgba(249,115,22,.3)}
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="ger-tabs">
    <a href="<?php echo e(route('gerenciar.mesas')); ?>"        class="ger-tab">🪑 Mesas</a>
    <a href="<?php echo e(route('gerenciar.cardapio')); ?>"     class="ger-tab">🍽️ Cardápio</a>
    <a href="<?php echo e(route('gerenciar.funcionarios')); ?>" class="ger-tab">👥 Funcionários</a>
    <a href="<?php echo e(route('gerenciar.produtos')); ?>"     class="ger-tab active">📦 Produtos</a>
</div>

<div style="display:grid;grid-template-columns:360px 1fr;gap:20px;align-items:start">
    <div class="panel" style="position:sticky;top:80px">
        <div class="panel-header"><div class="panel-title"><i class="fas fa-plus"></i> Novo Produto</div></div>
        <form method="POST" action="<?php echo e(route('gerenciar.produtos.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-group"><label>Nome</label><input type="text" name="nome" class="form-control" value="<?php echo e(old('nome')); ?>" required></div>
            <div class="form-row">
                <div class="form-group">
                    <label>Unidade</label>
                    <select name="unidade" class="form-select" required>
                        <option value="kg" <?php echo e(old('unidade')=='kg'?'selected':''); ?>>kg (peso)</option>
                        <option value="un" <?php echo e(old('unidade','un')=='un'?'selected':''); ?>>un (unidade)</option>
                        <option value="l"  <?php echo e(old('unidade')=='l'?'selected':''); ?>>L (litro)</option>
                        <option value="g"  <?php echo e(old('unidade')=='g'?'selected':''); ?>>g (gramas)</option>
                        <option value="ml" <?php echo e(old('unidade')=='ml'?'selected':''); ?>>mL</option>
                        <option value="cx" <?php echo e(old('unidade')=='cx'?'selected':''); ?>>cx (caixa)</option>
                    </select>
                </div>
                <div class="form-group"><label>Preço Unit. (R$)</label><input type="number" name="preco_unitario" step="0.01" min="0" class="form-control" value="<?php echo e(old('preco_unitario')); ?>" required></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label>Qtd. Atual</label><input type="number" name="quantidade_atual" step="0.001" min="0" class="form-control" value="<?php echo e(old('quantidade_atual',0)); ?>" required></div>
                <div class="form-group"><label>Qtd. Mínima</label><input type="number" name="quantidade_minima" step="0.001" min="0" class="form-control" value="<?php echo e(old('quantidade_minima',0)); ?>" required></div>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
                <i class="fas fa-save"></i> Cadastrar Produto
            </button>
        </form>
    </div>

    <div class="table-wrap">
        <div class="table-header">
            <h2><i class="fas fa-boxes"></i> Produtos Cadastrados (<?php echo e($itens->count()); ?>)</h2>
            <input type="text" id="search-prod" placeholder="Buscar..." class="form-control" style="width:200px;padding:7px 12px;font-size:13px">
        </div>
        <?php if($itens->isEmpty()): ?>
            <div class="empty-state"><i class="fas fa-boxes"></i><p>Nenhum produto cadastrado</p></div>
        <?php else: ?>
        <table>
            <thead><tr><th>Produto</th><th>Unidade</th><th>Estoque Atual</th><th>Mínimo</th><th>Preço Unit.</th><th>Status</th><th>Ações</th></tr></thead>
            <tbody id="tbody-prod">
            <?php $__currentLoopData = $itens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $alerta = $item->quantidade_atual <= $item->quantidade_minima; ?>
            <tr data-nome="<?php echo e(strtolower($item->nome)); ?>">
                <td class="td-primary"><?php echo e($item->nome); ?></td>
                <td><span style="background:rgba(99,102,241,.15);color:#818cf8;padding:2px 8px;border-radius:6px;font-size:11px;font-weight:700"><?php echo e($item->unidade); ?></span></td>
                <td class="td-mono" style="color:<?php echo e($alerta?'#f87171':'#4ade80'); ?>;font-weight:700"><?php echo e(number_format($item->quantidade_atual,3,',','.')); ?></td>
                <td class="td-mono" style="color:var(--muted)"><?php echo e(number_format($item->quantidade_minima,3,',','.')); ?></td>
                <td class="td-mono">R$ <?php echo e(number_format($item->preco_unitario,2,',','.')); ?></td>
                <td>
                    <?php if($item->quantidade_atual <= 0): ?> <span class="badge badge-danger">Esgotado</span>
                    <?php elseif($alerta): ?> <span class="badge badge-warning">Baixo</span>
                    <?php else: ?> <span class="badge badge-success">OK</span>
                    <?php endif; ?>
                </td>
                <td>
                    <div style="display:flex;gap:6px">
                        <button class="btn btn-secondary btn-sm btn-icon"
                            onclick="editProd(<?php echo e($item->id); ?>,'<?php echo e(addslashes($item->nome)); ?>','<?php echo e($item->unidade); ?>',<?php echo e($item->quantidade_minima); ?>,<?php echo e($item->preco_unitario); ?>)">
                            <i class="fas fa-pencil"></i>
                        </button>
                        <form method="POST" action="<?php echo e(route('gerenciar.produtos.destroy',$item)); ?>" onsubmit="return confirm('Remover <?php echo e($item->nome); ?>?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm btn-icon"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<div id="modal-prod" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.7);z-index:999;align-items:center;justify-content:center">
    <div class="panel" style="width:380px;margin:0">
        <div class="panel-header"><div class="panel-title">Editar Produto</div><button onclick="document.getElementById('modal-prod').style.display='none'" class="btn btn-secondary btn-sm btn-icon">×</button></div>
        <form method="POST" id="form-edit-prod"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div class="form-group"><label>Nome</label><input type="text" name="nome" id="ep-nome" class="form-control" required></div>
            <div class="form-row">
                <div class="form-group">
                    <label>Unidade</label>
                    <select name="unidade" id="ep-unidade" class="form-select">
                        <option value="kg">kg</option><option value="un">un</option>
                        <option value="l">L</option><option value="g">g</option>
                        <option value="ml">mL</option><option value="cx">cx</option>
                    </select>
                </div>
                <div class="form-group"><label>Preço Unit.</label><input type="number" name="preco_unitario" id="ep-preco" step="0.01" min="0" class="form-control" required></div>
            </div>
            <div class="form-group"><label>Qtd. Mínima</label><input type="number" name="quantidade_minima" id="ep-min" step="0.001" min="0" class="form-control" required></div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">Salvar</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
function editProd(id,nome,unidade,min,preco) {
    document.getElementById('ep-nome').value = nome;
    document.getElementById('ep-unidade').value = unidade;
    document.getElementById('ep-min').value = min;
    document.getElementById('ep-preco').value = preco;
    document.getElementById('form-edit-prod').action = '/gerenciar/produtos/' + id;
    document.getElementById('modal-prod').style.display = 'flex';
}
document.getElementById('search-prod').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#tbody-prod tr').forEach(r => r.style.display = r.dataset.nome.includes(q)?'':'none');
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project_corrigido\resources\views/gerenciar/produtos.blade.php ENDPATH**/ ?>