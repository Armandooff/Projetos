<?php $__env->startSection('page-title', 'Novo Usuário'); ?>
<?php $__env->startSection('breadcrumb', 'Cadastrar funcionário'); ?>
<?php $__env->startSection('content'); ?>
<div style="max-width:520px; margin:0 auto">
<div class="panel">
    <div class="panel-header">
        <div class="panel-title"><i class="fas fa-user-plus"></i> Cadastrar Usuário</div>
    </div>
    <form method="POST" action="<?php echo e(route('usuarios.store')); ?>">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label>Nome completo</label>
            <input type="text" name="name" class="form-control <?php echo e($errors->has('name')?'is-invalid':''); ?>"
                   value="<?php echo e(old('name')); ?>" placeholder="Nome do funcionário" required
                   oninput="this.value=this.value.replace(/[^a-zA-ZÀ-ÿ\s]/g,'')">
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
            <input type="email" name="email" class="form-control <?php echo e($errors->has('email')?'is-invalid':''); ?>"
                   value="<?php echo e(old('email')); ?>" placeholder="email@restaurante.com" required>
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
            <select name="role" class="form-select <?php echo e($errors->has('role')?'is-invalid':''); ?>" required>
                <option value="">— Selecione —</option>
                <option value="garcom"  <?php echo e(old('role')=='garcom' ?'selected':''); ?>>🍽️ Garçom</option>
                <option value="chef"    <?php echo e(old('role')=='chef'   ?'selected':''); ?>>👨‍🍳 Chef</option>
                <option value="caixa"   <?php echo e(old('role')=='caixa'  ?'selected':''); ?>>💰 Caixa</option>
                <option value="gerente" <?php echo e(old('role')=='gerente'?'selected':''); ?>>👑 Gerente</option>
            </select>
            <?php $__errorArgs = ['role'];
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
                <label>Senha</label>
                <input type="password" name="password" class="form-control <?php echo e($errors->has('password')?'is-invalid':''); ?>"
                       placeholder="Mínimo 6 caracteres" required>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-group">
                <label>Confirmar Senha</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Repita a senha" required>
            </div>
        </div>
        <div style="display:flex; gap:10px; margin-top:8px">
            <button type="submit" class="btn btn-primary" style="flex:1; justify-content:center">
                <i class="fas fa-save"></i> Cadastrar
            </button>
            <a href="<?php echo e(route('usuarios.index')); ?>" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project_corrigido\resources\views/usuarios/create.blade.php ENDPATH**/ ?>