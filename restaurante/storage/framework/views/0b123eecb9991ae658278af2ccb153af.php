<?php $__env->startSection('page-title', 'Novo Pedido'); ?>
<?php $__env->startSection('breadcrumb', 'Criar pedido para mesa'); ?>

<?php $__env->startSection('styles'); ?>
<style>
.order-layout {
    display: flex;
    gap: 20px;
    align-items: flex-start;
    width: 100%;
}
.cardapio-col {
    flex: 1;
    min-width: 0;
}
.resumo-col {
    width: 300px;
    min-width: 300px;
    position: sticky;
    top: 80px;
}
.item-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 10px;
    margin-bottom: 20px;
}
.menu-card {
    background: var(--bg2);
    border: 1.5px solid var(--border);
    border-radius: 12px;
    padding: 14px;
    cursor: pointer;
    transition: all .18s;
    display: flex;
    flex-direction: column;
    gap: 5px;
}
.menu-card:hover  { border-color: rgba(249,115,22,.5); background: rgba(249,115,22,.05); }
.menu-card.active { border-color: var(--accent); background: rgba(249,115,22,.1); }
.menu-card-nome  { font-weight: 700; color: #fff; font-size: 13px; }
.menu-card-desc  { font-size: 11px; color: var(--muted); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.menu-card-preco { font-weight: 800; color: var(--accent); font-size: 14px; }
.menu-card-ctrl  { display: flex; align-items: center; gap: 8px; margin-top: 6px; }
.qty-btn {
    width: 28px; height: 28px; border-radius: 7px; border: none;
    font-size: 18px; font-weight: 700; cursor: pointer;
    display: flex; align-items: center; justify-content: center; transition: .15s;
}
.qty-btn.minus { background: rgba(255,255,255,.08); color: var(--muted); }
.qty-btn.minus:hover { background: rgba(239,68,68,.25); color: #f87171; }
.qty-btn.plus  { background: var(--accent); color: #fff; }
.qty-btn.plus:hover { background: #ea6a0a; }
.qty-num { font-weight: 800; color: #fff; font-size: 15px; min-width: 22px; text-align: center; }
.cat-sep {
    display: flex; align-items: center; gap: 12px; margin: 16px 0 12px;
}
.cat-sep-line { flex: 1; height: 1px; background: var(--border); }
.cat-sep-label { font-size: 11px; font-weight: 800; color: var(--accent); text-transform: uppercase; letter-spacing: 1.5px; white-space: nowrap; }
.resumo-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 7px 0; border-bottom: 1px solid var(--border); font-size: 13px; gap: 8px;
}
.resumo-row:last-child { border-bottom: none; }
.btn-enviar {
    width: 100%; padding: 13px; font-size: 15px; font-weight: 700;
    background: var(--accent); color: #fff; border: none; border-radius: 10px;
    cursor: pointer; transition: .18s;
    display: flex; align-items: center; justify-content: center; gap: 8px;
}
.btn-enviar:hover:not(:disabled) { background: #ea6a0a; }
.btn-enviar:disabled { opacity: .45; cursor: not-allowed; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<form method="POST" action="<?php echo e(route('orders.store')); ?>" id="order-form">
<?php echo csrf_field(); ?>

<div class="order-layout">

    
    <div class="cardapio-col">

        <div class="panel" style="padding:12px 16px; margin-bottom:16px">
            <input type="text" id="search-input" class="form-control"
                   placeholder="🔍  Buscar no cardápio...">
        </div>

        <?php $__empty_1 = true; $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="categoria-block" data-cat="<?php echo e(strtolower($categoria->nome)); ?>">
            <div class="cat-sep">
                <div class="cat-sep-line"></div>
                <span class="cat-sep-label"><?php echo e($categoria->nome); ?></span>
                <div class="cat-sep-line"></div>
            </div>
            <div class="item-grid">
                <?php $__currentLoopData = $categoria->menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="menu-card"
                     id="card-<?php echo e($item->id); ?>"
                     data-id="<?php echo e($item->id); ?>"
                     data-nome="<?php echo e(strtolower($item->nome)); ?>"
                     onclick="addItem(<?php echo e($item->id); ?>)">
                    <div class="menu-card-nome"><?php echo e($item->nome); ?></div>
                    <?php if($item->descricao): ?>
                    <div class="menu-card-desc"><?php echo e($item->descricao); ?></div>
                    <?php endif; ?>
                    <div class="menu-card-preco">R$ <?php echo e(number_format($item->preco,2,',','.')); ?></div>
                    <div class="menu-card-ctrl" onclick="event.stopPropagation()">
                        <button type="button" class="qty-btn minus" onclick="changeQty(<?php echo e($item->id); ?>, -1)">−</button>
                        <span class="qty-num" id="qty-<?php echo e($item->id); ?>">0</span>
                        <button type="button" class="qty-btn plus"  onclick="changeQty(<?php echo e($item->id); ?>, 1)">+</button>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="empty-state" style="margin-top:60px">
            <i class="fas fa-utensils"></i>
            <p>Nenhum item disponível no cardápio</p>
        </div>
        <?php endif; ?>
    </div>

    
    <div class="resumo-col">
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title"><i class="fas fa-clipboard-list"></i> Resumo</div>
                <button type="button" class="btn btn-secondary btn-sm btn-icon" onclick="clearAll()">
                    <i class="fas fa-trash"></i>
                </button>
            </div>

            <div class="form-group">
                <label>Mesa</label>
                <select name="table_id" class="form-select <?php echo e($errors->has('table_id') ? 'is-invalid' : ''); ?>" required>
                    <option value="">— Selecione —</option>
                    <?php $__currentLoopData = $mesas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mesa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($mesa->id); ?>" <?php echo e(old('table_id', $tableId) == $mesa->id ? 'selected' : ''); ?>>
                        Mesa <?php echo e($mesa->numero); ?> · <?php echo e($mesa->assentos); ?> lugares
                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['table_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label>Observações</label>
                <textarea name="observacoes" class="form-control" rows="2"
                          placeholder="Alergias, preferências..."><?php echo e(old('observacoes')); ?></textarea>
            </div>

            <div id="resumo-items" style="margin-bottom:14px; max-height:240px; overflow-y:auto">
                <div style="text-align:center; color:var(--muted); font-size:13px; padding:18px 0">
                    <i class="fas fa-cart-plus" style="font-size:24px; opacity:.25; display:block; margin-bottom:8px"></i>
                    Nenhum item selecionado
                </div>
            </div>

            <div id="hidden-inputs"></div>

            <div style="border-top:1px solid var(--border); padding-top:12px; margin-bottom:14px">
                <div style="display:flex; justify-content:space-between; font-size:18px; font-weight:800; color:#fff">
                    <span>Total</span>
                    <span id="total-display" style="color:var(--accent)">R$ 0,00</span>
                </div>
            </div>

            <?php if($errors->has('itens')): ?>
            <div class="alert alert-error" style="margin-bottom:12px; padding:10px 14px; font-size:13px">
                <i class="fas fa-exclamation-circle"></i> <?php echo e($errors->first('itens')); ?>

            </div>
            <?php endif; ?>

            <button type="submit" id="btn-submit" class="btn-enviar" disabled>
                <i class="fas fa-paper-plane"></i> Enviar Pedido
            </button>
            <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-secondary"
               style="width:100%; margin-top:8px; justify-content:center">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </div>

</div>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
const precos = {
    <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php $__currentLoopData = $cat->menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php echo e($item->id); ?>: { nome: <?php echo json_encode($item->nome, 15, 512) ?>, preco: <?php echo e($item->preco); ?> },
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
};

const qtds = {};

function addItem(id) { changeQty(id, 1); }

function changeQty(id, delta) {
    qtds[id] = Math.max(0, (qtds[id] || 0) + delta);
    document.getElementById('qty-' + id).textContent = qtds[id];
    const card = document.getElementById('card-' + id);
    if (card) card.classList.toggle('active', qtds[id] > 0);
    updateResumo();
}

function clearAll() {
    for (const id in qtds) {
        qtds[id] = 0;
        const el = document.getElementById('qty-' + id);
        if (el) el.textContent = 0;
        const card = document.getElementById('card-' + id);
        if (card) card.classList.remove('active');
    }
    updateResumo();
}

function updateResumo() {
    let total = 0, hasItems = false, resumoHtml = '', hiddenHtml = '';

    for (const id in qtds) {
        if (qtds[id] > 0) {
            hasItems = true;
            const p = precos[id];
            const sub = p.preco * qtds[id];
            total += sub;
            resumoHtml += `<div class="resumo-row">
                <span style="color:var(--text);flex:1;min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">${qtds[id]}× ${p.nome}</span>
                <span style="font-weight:700;color:#fff;white-space:nowrap;margin-left:8px">R$ ${sub.toFixed(2).replace('.',',')}</span>
            </div>`;
            hiddenHtml += `<input type="hidden" name="itens[${id}][menu_item_id]" value="${id}">`;
            hiddenHtml += `<input type="hidden" name="itens[${id}][quantidade]" value="${qtds[id]}">`;
        }
    }

    document.getElementById('resumo-items').innerHTML = hasItems ? resumoHtml
        : '<div style="text-align:center;color:var(--muted);font-size:13px;padding:18px 0">'
        + '<i class="fas fa-cart-plus" style="font-size:24px;opacity:.25;display:block;margin-bottom:8px"></i>'
        + 'Nenhum item selecionado</div>';

    document.getElementById('hidden-inputs').innerHTML = hiddenHtml;
    document.getElementById('total-display').textContent = 'R$ ' + total.toFixed(2).replace('.', ',');
    document.getElementById('btn-submit').disabled = !hasItems;
}

document.getElementById('search-input').addEventListener('input', function () {
    const q = this.value.toLowerCase().trim();
    document.querySelectorAll('.menu-card').forEach(c => {
        c.style.display = (!q || c.dataset.nome.includes(q)) ? '' : 'none';
    });
    document.querySelectorAll('.categoria-block').forEach(b => {
        const vis = [...b.querySelectorAll('.menu-card')].some(c => c.style.display !== 'none');
        b.style.display = vis ? '' : 'none';
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project_corrigido\resources\views/orders/create.blade.php ENDPATH**/ ?>