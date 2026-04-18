<?php $__env->startSection('page-title', 'Equipe'); ?>
<?php $__env->startSection('breadcrumb', 'Gerenciar usuários do sistema'); ?>

<?php $__env->startSection('styles'); ?>
<style>
.role-badge { padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; }
.role-gerente  { background:rgba(168,85,247,.15); color:#c084fc; }
.role-garcom   { background:rgba(59,130,246,.15);  color:#60a5fa; }
.role-chef     { background:rgba(249,115,22,.15);  color:#fb923c; }
.role-caixa    { background:rgba(34,197,94,.15);   color:#4ade80; }
.user-avatar {
    width:38px; height:38px; border-radius:10px;
    display:flex; align-items:center; justify-content:center;
    font-weight:800; font-size:15px; color:#fff;
}
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px">
    <div>
        <h2 style="font-size:20px; font-weight:800; color:#fff; margin:0">Equipe</h2>
        <div style="color:var(--muted); font-size:13px; margin-top:2px"><?php echo e($usuarios->count()); ?> usuário(s) cadastrado(s)</div>
    </div>
    <a href="<?php echo e(route('usuarios.create')); ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Novo Usuário
    </a>
</div>


<?php
    $grupos = ['gerente'=>'Gerentes','garcom'=>'Garçons','chef'=>'Chefs','caixa'=>'Caixas'];
    $cores  = ['gerente'=>'#a855f7','garcom'=>'#3b82f6','chef'=>'#f97316','caixa'=>'#22c55e'];
    $icones = ['gerente'=>'fa-crown','garcom'=>'fa-concierge-bell','chef'=>'fa-hat-chef','caixa'=>'fa-cash-register'];
?>

<?php $__currentLoopData = $grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php $grupo = $usuarios->where('role', $role); ?>
<?php if($grupo->isNotEmpty()): ?>
<div class="panel" style="margin-bottom:20px">
    <div class="panel-header">
        <div class="panel-title">
            <i class="fas <?php echo e($icones[$role]); ?>" style="color:<?php echo e($cores[$role]); ?>"></i>
            <?php echo e($label); ?> <span style="color:var(--muted); font-weight:400">(<?php echo e($grupo->count()); ?>)</span>
        </div>
    </div>
    <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(320px,1fr)); gap:12px">
        <?php $__currentLoopData = $grupo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div style="background:var(--bg); border:1px solid var(--border); border-radius:12px; padding:16px; display:flex; align-items:center; gap:14px">
            <div class="user-avatar" style="background:<?php echo e($cores[$role]); ?>20; color:<?php echo e($cores[$role]); ?>">
                <?php echo e(strtoupper(substr($u->name,0,1))); ?>

            </div>
            <div style="flex:1; min-width:0">
                <div style="font-weight:700; color:#fff; font-size:14px"><?php echo e($u->name); ?></div>
                <div style="font-size:12px; color:var(--muted); overflow:hidden; text-overflow:ellipsis; white-space:nowrap"><?php echo e($u->email); ?></div>
                <div style="margin-top:4px">
                    <span class="role-badge role-<?php echo e($u->role); ?>"><?php echo e($label); ?></span>
                    <?php if(!$u->ativo): ?>
                    <span class="badge badge-danger" style="margin-left:4px">Inativo</span>
                    <?php endif; ?>
                </div>
            </div>
            <div style="display:flex; gap:6px; flex-shrink:0">
                <a href="<?php echo e(route('usuarios.edit', $u)); ?>" class="btn btn-secondary btn-sm btn-icon" title="Editar">
                    <i class="fas fa-pencil"></i>
                </a>
                <form method="POST" action="<?php echo e(route('usuarios.toggle', $u)); ?>">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    <button type="submit" class="btn btn-sm btn-icon <?php echo e($u->ativo ? 'btn-warning' : 'btn-success'); ?>"
                            title="<?php echo e($u->ativo ? 'Desativar' : 'Ativar'); ?>"
                            onclick="return confirm('<?php echo e($u->ativo ? 'Desativar' : 'Ativar'); ?> este usuário?')">
                        <i class="fas <?php echo e($u->ativo ? 'fa-ban' : 'fa-check'); ?>"></i>
                    </button>
                </form>
                <?php if($u->id !== Auth::id()): ?>
                <form method="POST" action="<?php echo e(route('usuarios.destroy', $u)); ?>">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger btn-sm btn-icon" title="Excluir"
                            onclick="return confirm('Excluir <?php echo e($u->name); ?>? Esta ação não pode ser desfeita.')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project_corrigido\resources\views/usuarios/index.blade.php ENDPATH**/ ?>