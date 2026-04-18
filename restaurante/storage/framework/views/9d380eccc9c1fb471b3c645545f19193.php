<?php $__env->startSection('page-title', 'Gerenciar Cardápio'); ?>
<?php $__env->startSection('breadcrumb', 'Itens do menu'); ?>
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
    <a href="<?php echo e(route('gerenciar.cardapio')); ?>"     class="ger-tab active">🍽️ Cardápio</a>
    <a href="<?php echo e(route('gerenciar.funcionarios')); ?>" class="ger-tab">👥 Funcionários</a>
    <a href="<?php echo e(route('gerenciar.produtos')); ?>"     class="ger-tab">📦 Produtos</a>
</div>

<div style="display:grid;grid-template-columns:360px 1fr;gap:20px;align-items:start">
    <div class="panel" style="position:sticky;top:80px">
        <div class="panel-header"><div class="panel-title"><i class="fas fa-plus"></i> Novo Item</div></div>
        <form method="POST" action="<?php echo e(route('gerenciar.cardapio.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="nome" class="form-control <?php echo e($errors->has('nome')?'is-invalid':''); ?>" value="<?php echo e(old('nome')); ?>" required>
                <?php $__errorArgs = ['nome'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Categoria</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">— Selecione —</option>
                        <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cat->id); ?>" <?php echo e(old('category_id')==$cat->id?'selected':''); ?>><?php echo e($cat->nome); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Preço (R$)</label>
                    <input type="number" name="preco" step="0.01" min="0.01" class="form-control" value="<?php echo e(old('preco')); ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label>Descrição</label>
                <input type="text" name="descricao" class="form-control" value="<?php echo e(old('descricao')); ?>" placeholder="Descrição breve...">
            </div>
            <div class="form-group">
                <label>Ingrediente Principal (estoque)</label>
                <select name="stock_item_id" class="form-select">
                    <option value="">— Nenhum —</option>
                    <?php $__currentLoopData = $estoque; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s->id); ?>" <?php echo e(old('stock_item_id')==$s->id?'selected':''); ?>><?php echo e($s->nome); ?> (<?php echo e($s->unidade); ?>)</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group">
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                    <input type="checkbox" name="disponivel" value="1" checked style="width:16px;height:16px"> Disponível no cardápio
                </label>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
                <i class="fas fa-save"></i> Adicionar Item
            </button>
        </form>
    </div>

    <div class="table-wrap">
        <div class="table-header">
            <h2><i class="fas fa-utensils"></i> Itens do Cardápio (<?php echo e($itens->count()); ?>)</h2>
            <input type="text" id="search-cardapio" placeholder="Buscar..." class="form-control" style="width:200px;padding:7px 12px;font-size:13px">
        </div>
        <?php if($itens->isEmpty()): ?>
            <div class="empty-state"><i class="fas fa-utensils"></i><p>Nenhum item cadastrado</p></div>
        <?php else: ?>
        <table>
            <thead><tr><th>Item</th><th>Categoria</th><th>Preço</th><th>Ingrediente</th><th>Status</th><th>Ações</th></tr></thead>
            <tbody id="tbody-cardapio">
            <?php $__currentLoopData = $itens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr data-nome="<?php echo e(strtolower($item->nome)); ?>">
                <td class="td-primary"><?php echo e($item->nome); ?><div style="font-size:11px;color:var(--muted)"><?php echo e(Str::limit($item->descricao,40)); ?></div></td>
                <td style="color:var(--muted)"><?php echo e($item->category->nome ?? '—'); ?></td>
                <td class="td-mono" style="color:var(--accent);font-weight:700">R$ <?php echo e(number_format($item->preco,2,',','.')); ?></td>
                <td style="font-size:12px;color:var(--muted)"><?php echo e($item->stockItem->nome ?? '—'); ?></td>
                <td><span class="badge badge-<?php echo e($item->disponivel?'success':'danger'); ?>"><?php echo e($item->disponivel?'Disponível':'Indisponível'); ?></span></td>
                <td>
                    <div style="display:flex;gap:6px">
                        <button class="btn btn-secondary btn-sm btn-icon" title="Editar"
                            onclick="editItem(<?php echo e($item->id); ?>,'<?php echo e(addslashes($item->nome)); ?>',<?php echo e($item->category_id); ?>,<?php echo e($item->preco); ?>,'<?php echo e(addslashes($item->descricao??'')); ?>',<?php echo e($item->stock_item_id??'null'); ?>,<?php echo e($item->disponivel?1:0); ?>)">
                            <i class="fas fa-pencil"></i>
                        </button>
                        <form method="POST" action="<?php echo e(route('gerenciar.cardapio.destroy',$item)); ?>" onsubmit="return confirm('Remover <?php echo e($item->nome); ?>?')">
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

<div id="modal-item" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.7);z-index:999;align-items:center;justify-content:center">
    <div class="panel" style="width:420px;margin:0;max-height:90vh;overflow-y:auto">
        <div class="panel-header">
            <div class="panel-title">Editar Item</div>
            <button onclick="document.getElementById('modal-item').style.display='none'" class="btn btn-secondary btn-sm btn-icon">×</button>
        </div>
        <form method="POST" id="form-edit-item">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div class="form-group"><label>Nome</label><input type="text" name="nome" id="ei-nome" class="form-control" required></div>
            <div class="form-row">
                <div class="form-group">
                    <label>Categoria</label>
                    <select name="category_id" id="ei-cat" class="form-select" required>
                        <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->nome); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="form-group"><label>Preço</label><input type="number" name="preco" id="ei-preco" step="0.01" min="0.01" class="form-control" required></div>
            </div>
            <div class="form-group"><label>Descrição</label><input type="text" name="descricao" id="ei-desc" class="form-control"></div>
            <div class="form-group">
                <label>Ingrediente Principal</label>
                <select name="stock_item_id" id="ei-stock" class="form-select">
                    <option value="">— Nenhum —</option>
                    <?php $__currentLoopData = $estoque; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s->id); ?>"><?php echo e($s->nome); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group"><label style="display:flex;align-items:center;gap:8px;cursor:pointer"><input type="checkbox" name="disponivel" id="ei-disp" value="1" style="width:16px;height:16px"> Disponível</label></div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">Salvar</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
function editItem(id,nome,catId,preco,desc,stockId,disp) {
    document.getElementById('ei-nome').value = nome;
    document.getElementById('ei-cat').value = catId;
    document.getElementById('ei-preco').value = preco;
    document.getElementById('ei-desc').value = desc;
    document.getElementById('ei-stock').value = stockId || '';
    document.getElementById('ei-disp').checked = disp == 1;
    document.getElementById('form-edit-item').action = '/gerenciar/cardapio/' + id;
    document.getElementById('modal-item').style.display = 'flex';
}
document.getElementById('search-cardapio').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#tbody-cardapio tr').forEach(r => {
        r.style.display = r.dataset.nome.includes(q) ? '' : 'none';
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project_corrigido\resources\views/gerenciar/cardapio.blade.php ENDPATH**/ ?>