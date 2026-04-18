<?php $__env->startSection('page-title', 'Compras'); ?>
<?php $__env->startSection('breadcrumb', 'Registro de entradas de estoque'); ?>
<?php $__env->startSection('content'); ?>
<div style="display:grid; grid-template-columns: 380px 1fr; gap:24px">

    <div class="panel" style="position:sticky; top:80px; align-self:start">
        <div class="panel-header"><div class="panel-title">➕ Nova Compra</div></div>

        <form method="POST" action="<?php echo e(route('compras.store')); ?>" id="form-compra">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label>Item de Estoque</label>
                <select name="stock_item_id" class="form-select <?php echo e($errors->has('stock_item_id')?'is-invalid':''); ?>" required>
                    <option value="">— Selecione —</option>
                    <?php $__currentLoopData = $itens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($item->id); ?>" <?php echo e(old('stock_item_id')==$item->id?'selected':''); ?>>
                        <?php echo e($item->nome); ?> (<?php echo e($item->unidade); ?>)
                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['stock_item_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback">⚠️ <?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Quantidade <span style="color:var(--muted);font-weight:400">(máx. 99.999)</span></label>
                    <input type="number" name="quantidade" id="input-quantidade"
                           step="0.01" min="0.01" max="99999"
                           class="form-control <?php echo e($errors->has('quantidade')?'is-invalid':''); ?>"
                           value="<?php echo e(old('quantidade')); ?>"
                           oninput="validarNumero(this, 99999, 'erro-quantidade')" required>
                    <div id="erro-quantidade" class="campo-erro" style="display:none">
                        ⚠️ Máximo: 99.999
                    </div>
                    <?php $__errorArgs = ['quantidade'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="form-group">
                    <label>Preço Unit. (R$) <span style="color:var(--muted);font-weight:400">(máx. 999.999)</span></label>
                    <input type="number" name="preco_unitario" id="input-preco"
                           step="0.01" min="0.01" max="999999"
                           class="form-control <?php echo e($errors->has('preco_unitario')?'is-invalid':''); ?>"
                           value="<?php echo e(old('preco_unitario')); ?>"
                           oninput="validarNumero(this, 999999, 'erro-preco')" required>
                    <div id="erro-preco" class="campo-erro" style="display:none">
                        ⚠️ Máximo: R$ 999.999,00
                    </div>
                    <?php $__errorArgs = ['preco_unitario'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            
            <div id="preview-total" style="display:none; background:rgba(249,115,22,.08); border:1px solid rgba(249,115,22,.2); border-radius:10px; padding:12px 16px; margin-bottom:18px">
                <span style="color:var(--muted); font-size:13px">Total estimado:</span>
                <span id="valor-total" style="font-weight:800; color:var(--accent); font-family:monospace; font-size:16px; float:right"></span>
            </div>

            <div class="form-group">
                <label>Fornecedor <span style="color:var(--muted);font-weight:400">(apenas letras)</span></label>
                <input type="text" name="fornecedor" id="input-fornecedor"
                       class="form-control <?php echo e($errors->has('fornecedor')?'is-invalid':''); ?>"
                       value="<?php echo e(old('fornecedor')); ?>"
                       placeholder="Nome do fornecedor"
                       oninput="validarFornecedor(this)">
                <div id="erro-fornecedor" class="campo-erro" style="display:none">
                    ⚠️ Apenas letras são permitidas (sem números ou símbolos)
                </div>
                <?php $__errorArgs = ['fornecedor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label>Data de Entrega</label>
                <input type="date" name="data_entrega" class="form-control" value="<?php echo e(old('data_entrega')); ?>">
            </div>
            <div class="form-group">
                <label>Observações</label>
                <textarea name="observacoes" class="form-control" rows="2" placeholder="Observações..."><?php echo e(old('observacoes')); ?></textarea>
            </div>

            <button type="submit" id="btn-submit" class="btn btn-primary" style="width:100%; justify-content:center">
                💾 Registrar Compra
            </button>
        </form>
    </div>

    <div class="table-wrap">
        <div class="table-header">
            <h2>🕐 Histórico (<?php echo e($compras->count()); ?>)</h2>
        </div>
        <?php if($compras->isEmpty()): ?>
            <div class="empty-state">🛒<p>Nenhuma compra registrada</p></div>
        <?php else: ?>
        <table>
            <thead><tr><th>#</th><th>Item</th><th>Qtd</th><th>Preço Unit.</th><th>Total</th><th>Fornecedor</th><th>Data</th><th>Status</th><th></th></tr></thead>
            <tbody>
            <?php $__currentLoopData = $compras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="td-mono td-primary">#<?php echo e($c->id); ?></td>
                <td><?php echo e($c->stockItem->nome ?? '—'); ?></td>
                <td class="td-mono"><?php echo e(number_format($c->quantidade,2,',','.')); ?> <?php echo e($c->stockItem->unidade??''); ?></td>
                <td class="td-mono">R$ <?php echo e(number_format($c->preco_unitario,2,',','.')); ?></td>
                <td class="td-mono" style="color:#4ade80;font-weight:700">R$ <?php echo e(number_format($c->total,2,',','.')); ?></td>
                <td style="color:var(--muted)"><?php echo e($c->fornecedor ?? '—'); ?></td>
                <td style="color:var(--muted);font-size:12px"><?php echo e($c->created_at->format('d/m H:i')); ?></td>
                <td><span class="badge badge-<?php echo e($c->status==='recebido'?'success':($c->status==='cancelado'?'danger':'warning')); ?>"><?php echo e(ucfirst($c->status)); ?></span></td>
                <td>
                    <?php if($c->status==='recebido'): ?>
                    <form method="POST" action="<?php echo e(route('compras.cancelar',$c)); ?>" onsubmit="return confirm('Cancelar esta compra? O estoque será revertido.')">
                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                        <button type="submit" class="btn btn-danger btn-sm btn-icon">✕</button>
                    </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
.campo-erro { color:#f87171; font-size:12px; margin-top:5px; display:none; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
let erros = { quantidade: false, preco: false, fornecedor: false };

function validarNumero(el, max, erroId) {
    const val = parseFloat(el.value);
    const erroEl = document.getElementById(erroId);
    const campo = erroId.replace('erro-', '');
    if (el.value !== '' && (isNaN(val) || val > max)) {
        el.style.borderColor = '#ef4444';
        erroEl.style.display = 'block';
        erros[campo] = true;
    } else {
        el.style.borderColor = '';
        erroEl.style.display = 'none';
        erros[campo] = false;
    }
    atualizarBotao();
    atualizarTotal();
}

function validarFornecedor(el) {
    const val = el.value;
    const erroEl = document.getElementById('erro-fornecedor');
    // Aceita letras (incluindo acentos), espaços, pontos e hífens
    const valido = /^[a-zA-ZÀ-ÿ\s\.\-]*$/.test(val);
    if (!valido) {
        el.style.borderColor = '#ef4444';
        erroEl.style.display = 'block';
        erros.fornecedor = true;
        // Remove o caractere inválido automaticamente
        el.value = val.replace(/[^a-zA-ZÀ-ÿ\s\.\-]/g, '');
        erros.fornecedor = false;
        el.style.borderColor = '';
        erroEl.style.display = 'none';
    } else {
        el.style.borderColor = '';
        erroEl.style.display = 'none';
        erros.fornecedor = false;
    }
    atualizarBotao();
}

function atualizarBotao() {
    const temErro = Object.values(erros).some(v => v);
    const btn = document.getElementById('btn-submit');
    btn.disabled = temErro;
    btn.style.opacity = temErro ? '0.5' : '1';
}

function atualizarTotal() {
    const qtd   = parseFloat(document.getElementById('input-quantidade').value) || 0;
    const preco = parseFloat(document.getElementById('input-preco').value) || 0;
    const preview = document.getElementById('preview-total');
    if (qtd > 0 && preco > 0 && qtd <= 99999 && preco <= 999999) {
        preview.style.display = 'block';
        document.getElementById('valor-total').textContent =
            'R$ ' + (qtd * preco).toLocaleString('pt-BR', {minimumFractionDigits:2, maximumFractionDigits:2});
    } else {
        preview.style.display = 'none';
    }
}

// Última barreira no submit
document.getElementById('form-compra').addEventListener('submit', function(e) {
    const qtd        = parseFloat(document.getElementById('input-quantidade').value);
    const preco      = parseFloat(document.getElementById('input-preco').value);
    const fornecedor = document.getElementById('input-fornecedor').value;
    const fornecedorOk = /^[a-zA-ZÀ-ÿ\s\.\-]*$/.test(fornecedor);
    if (qtd > 99999 || preco > 999999 || !fornecedorOk) {
        e.preventDefault();
        alert('❌ Corrija os campos com erro antes de salvar.');
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project_corrigido\resources\views/dashboard/compras.blade.php ENDPATH**/ ?>