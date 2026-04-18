<?php $__env->startSection('page-title', 'Gerenciar Funcionários'); ?>
<?php $__env->startSection('breadcrumb', 'Equipe do restaurante'); ?>
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
    <a href="<?php echo e(route('gerenciar.funcionarios')); ?>" class="ger-tab active">👥 Funcionários</a>
    <a href="<?php echo e(route('gerenciar.produtos')); ?>"     class="ger-tab">📦 Produtos</a>
</div>

<div style="display:grid;grid-template-columns:340px 1fr;gap:20px;align-items:start">
    <div class="panel" style="position:sticky;top:80px">
        <div class="panel-header"><div class="panel-title"><i class="fas fa-user-plus"></i> Novo Funcionário</div></div>
        <form method="POST" action="<?php echo e(route('usuarios.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="name" class="form-control <?php echo e($errors->has('name')?'is-invalid':''); ?>" value="<?php echo e(old('name')); ?>" placeholder="Nome completo" required oninput="this.value=this.value.replace(/[^a-zA-ZÀ-ÿ\s]/g,'')">
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-group">
                <label>E-mail</label>
                <input type="email" name="email" id="email-input" class="form-control <?php echo e($errors->has('email')?'is-invalid':''); ?>" value="<?php echo e(old('email')); ?>" required
                       pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}"
                       title="E-mail inválido. Ex: nome@empresa.com"
                       oninput="validarEmail(this)">
                <div id="email-hint" style="font-size:11px;margin-top:4px;display:none"></div>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-group">
                <label>Cargo</label>
                <select name="role" class="form-select" required>
                    <option value="">— Selecione —</option>
                    <option value="garcom"  <?php echo e(old('role')=='garcom' ?'selected':''); ?>>🍽️ Garçom</option>
                    <option value="chef"    <?php echo e(old('role')=='chef'   ?'selected':''); ?>>👨‍🍳 Chef</option>
                    <option value="caixa"   <?php echo e(old('role')=='caixa'  ?'selected':''); ?>>💰 Caixa</option>
                    <option value="gerente" <?php echo e(old('role')=='gerente'?'selected':''); ?>>👑 Gerente</option>
                </select>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Senha</label>
                    <input type="password" name="password" class="form-control" placeholder="Mín. 6 caracteres" required>
                </div>
                <div class="form-group">
                    <label>Confirmar</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Repita" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
                <i class="fas fa-save"></i> Cadastrar
            </button>
        </form>
    </div>

    <div>
        <?php $grupos=['gerente'=>['label'=>'Gerentes','icon'=>'👑','cor'=>'#a855f7'],'garcom'=>['label'=>'Garçons','icon'=>'🍽️','cor'=>'#3b82f6'],'chef'=>['label'=>'Chefs','icon'=>'👨‍🍳','cor'=>'#f97316'],'caixa'=>['label'=>'Caixas','icon'=>'💰','cor'=>'#22c55e']]; ?>
        <?php $__currentLoopData = $grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role => $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $grupo = $usuarios->where('role',$role); ?>
        <?php if($grupo->isNotEmpty()): ?>
        <div class="panel" style="margin-bottom:16px">
            <div class="panel-header">
                <div class="panel-title"><?php echo e($g['icon']); ?> <?php echo e($g['label']); ?> <span style="color:var(--muted);font-weight:400">(<?php echo e($grupo->count()); ?>)</span></div>
            </div>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:10px">
                <?php $__currentLoopData = $grupo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="background:var(--bg);border:1px solid var(--border);border-radius:10px;padding:14px;display:flex;align-items:center;gap:12px">
                    <div style="width:36px;height:36px;border-radius:9px;background:<?php echo e($g['cor']); ?>20;color:<?php echo e($g['cor']); ?>;font-weight:800;font-size:15px;display:flex;align-items:center;justify-content:center;flex-shrink:0"><?php echo e(strtoupper(substr($u->name,0,1))); ?></div>
                    <div style="flex:1;min-width:0">
                        <div style="font-weight:700;color:#fff;font-size:13px"><?php echo e($u->name); ?></div>
                        <div style="font-size:11px;color:var(--muted);overflow:hidden;text-overflow:ellipsis;white-space:nowrap"><?php echo e($u->email); ?></div>
                        <?php if(!$u->ativo): ?><span class="badge badge-danger" style="font-size:10px">Inativo</span><?php endif; ?>
                    </div>
                    <div style="display:flex;gap:5px;flex-shrink:0">
                        <a href="<?php echo e(route('usuarios.edit',$u)); ?>" class="btn btn-secondary btn-sm btn-icon"><i class="fas fa-pencil"></i></a>
                        <form method="POST" action="<?php echo e(route('usuarios.toggle',$u)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                            <button type="submit" class="btn btn-sm btn-icon <?php echo e($u->ativo?'btn-warning':'btn-success'); ?>" title="<?php echo e($u->ativo?'Desativar':'Ativar'); ?>">
                                <i class="fas <?php echo e($u->ativo?'fa-ban':'fa-check'); ?>"></i>
                            </button>
                        </form>
                        <?php if($u->id !== Auth::id()): ?>
                        <form method="POST" action="<?php echo e(route('usuarios.destroy',$u)); ?>" onsubmit="return confirm('Excluir <?php echo e($u->name); ?>?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm btn-icon"><i class="fas fa-trash"></i></button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function validarEmail(input) {
    const hint = document.getElementById('email-hint');
    const val = input.value.trim();
    const re = /^[a-zA-Z0-9][a-zA-Z0-9._%+\-]{1,}@[a-zA-Z0-9\-]+(\.[a-zA-Z0-9\-]+)*\.(com|net|org|edu|gov|br|io|co|info|biz|me|tv|app|dev|tech|online|store|site|email|mail)(\.br)?$/i;
    if (!hint) return;
    if (val.length === 0) { hint.style.display = 'none'; input.style.borderColor = ''; return; }
    if (re.test(val)) {
        hint.textContent = '✅ E-mail válido';
        hint.style.color = '#4ade80';
        hint.style.display = 'block';
        input.style.borderColor = '#4ade80';
    } else {
        hint.textContent = '❌ E-mail inválido. Ex: nome@empresa.com';
        hint.style.color = '#f87171';
        hint.style.display = 'block';
        input.style.borderColor = '#f87171';
    }
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project_corrigido\resources\views/gerenciar/funcionarios.blade.php ENDPATH**/ ?>