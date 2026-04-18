<?php $__env->startSection('page-title', 'Gerenciar Mesas'); ?>
<?php $__env->startSection('breadcrumb', 'Cadastro e configuração de mesas'); ?>
<?php $__env->startSection('styles'); ?>
<style>
.ger-tabs { display:flex; gap:8px; margin-bottom:24px; flex-wrap:wrap; }
.ger-tab  { padding:8px 18px; border-radius:8px; text-decoration:none; font-size:13px; font-weight:700; color:var(--muted); background:var(--bg2); border:1px solid var(--border); transition:.15s; }
.ger-tab.active, .ger-tab:hover { background:rgba(249,115,22,.12); color:var(--accent); border-color:rgba(249,115,22,.3); }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="ger-tabs">
    <a href="<?php echo e(route('gerenciar.mesas')); ?>"        class="ger-tab active">🪑 Mesas</a>
    <a href="<?php echo e(route('gerenciar.cardapio')); ?>"     class="ger-tab">🍽️ Cardápio</a>
    <a href="<?php echo e(route('gerenciar.funcionarios')); ?>" class="ger-tab">👥 Funcionários</a>
    <a href="<?php echo e(route('gerenciar.produtos')); ?>"     class="ger-tab">📦 Produtos</a>
</div>

<div style="display:grid; grid-template-columns:340px 1fr; gap:20px; align-items:start">
    <div class="panel" style="position:sticky; top:80px">
        <div class="panel-header"><div class="panel-title"><i class="fas fa-plus"></i> Nova Mesa</div></div>
        <form method="POST" action="<?php echo e(route('mesas.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-row">
                <div class="form-group">
                    <label>Número</label>
                    <input type="number" name="numero" class="form-control <?php echo e($errors->has('numero')?'is-invalid':''); ?>" min="1" value="<?php echo e(old('numero')); ?>" required>
                    <?php $__errorArgs = ['numero'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="form-group">
                    <label>Assentos</label>
                    <input type="number" name="assentos" class="form-control" min="1" max="20" value="<?php echo e(old('assentos',4)); ?>" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
                <i class="fas fa-save"></i> Criar Mesa
            </button>
        </form>
    </div>

    <div class="table-wrap">
        <div class="table-header">
            <h2><i class="fas fa-chair"></i> Mesas Cadastradas (<?php echo e($mesas->count()); ?>)</h2>
        </div>
        <?php if($mesas->isEmpty()): ?>
            <div class="empty-state"><i class="fas fa-chair"></i><p>Nenhuma mesa cadastrada</p></div>
        <?php else: ?>
        <table>
            <thead><tr><th>Número</th><th>Assentos</th><th>Status</th><th>Ações</th></tr></thead>
            <tbody>
            <?php $__currentLoopData = $mesas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mesa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="td-primary td-mono">Mesa <?php echo e($mesa->numero); ?></td>
                <td><?php echo e($mesa->assentos); ?> lugares</td>
                <td><span class="badge badge-<?php echo e($mesa->status==='disponivel'?'success':($mesa->status==='ocupada'?'danger':'warning')); ?>"><?php echo e(ucfirst($mesa->status)); ?></span></td>
                <td>
                    <div style="display:flex;gap:6px">
                        <button class="btn btn-secondary btn-sm btn-icon" onclick="editMesa(<?php echo e($mesa->id); ?>,<?php echo e($mesa->numero); ?>,<?php echo e($mesa->assentos); ?>)" title="Editar"><i class="fas fa-pencil"></i></button>
                        <form method="POST" action="<?php echo e(route('mesas.destroy',$mesa)); ?>" onsubmit="return confirm('Deletar Mesa <?php echo e($mesa->numero); ?>?')">
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


<div id="modal-edit" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.7);z-index:999;display:none;align-items:center;justify-content:center">
    <div class="panel" style="width:360px;margin:0">
        <div class="panel-header"><div class="panel-title">Editar Mesa</div><button onclick="document.getElementById('modal-edit').style.display='none'" class="btn btn-secondary btn-sm btn-icon">×</button></div>
        <form method="POST" id="form-edit-mesa">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div class="form-row">
                <div class="form-group"><label>Número</label><input type="number" name="numero" id="edit-numero" class="form-control" required></div>
                <div class="form-group"><label>Assentos</label><input type="number" name="assentos" id="edit-assentos" class="form-control" required></div>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">Salvar</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
function editMesa(id, num, ass) {
    document.getElementById('edit-numero').value = num;
    document.getElementById('edit-assentos').value = ass;
    document.getElementById('form-edit-mesa').action = '/mesas/' + id;
    document.getElementById('modal-edit').style.display = 'flex';
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project_corrigido\resources\views/gerenciar/mesas.blade.php ENDPATH**/ ?>