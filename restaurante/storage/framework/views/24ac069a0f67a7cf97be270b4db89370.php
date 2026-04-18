<?php $__env->startSection('page-title'); ?>
Editar Mesa <?php echo e($table->numero); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb', 'Alterar dados da mesa'); ?>
<?php $__env->startSection('content'); ?>
<div class="panel" style="max-width:480px">
    <div class="panel-header"><div class="panel-title">✏️ Editar Mesa <?php echo e($table->numero); ?></div></div>
    <form method="POST" action="<?php echo e(route('mesas.update',$table)); ?>">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <div class="form-group">
            <label>Número da Mesa</label>
            <input type="number" name="numero" class="form-control <?php echo e($errors->has('numero')?'is-invalid':''); ?>" value="<?php echo e(old('numero',$table->numero)); ?>" min="1" required>
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
            <label>Quantidade de Assentos</label>
            <input type="number" name="assentos" class="form-control <?php echo e($errors->has('assentos')?'is-invalid':''); ?>" value="<?php echo e(old('assentos',$table->assentos)); ?>" min="1" max="20" required>
            <?php $__errorArgs = ['assentos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div style="display:flex; gap:10px">
            <button type="submit" class="btn btn-primary">💾 Salvar</button>
            <a href="<?php echo e(route('mesas.index')); ?>" class="btn btn-secondary">✕ Cancelar</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project_corrigido\resources\views/mesas/edit.blade.php ENDPATH**/ ?>