<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — RestaurantePRO</title>
<style>
*,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
body{
  font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Arial,sans-serif;
  background:#0d0f14;min-height:100vh;
  display:flex;align-items:center;justify-content:center;
}
body::before{
  content:'';position:fixed;inset:0;z-index:0;
  background-image:linear-gradient(rgba(249,115,22,.04) 1px,transparent 1px),
    linear-gradient(90deg,rgba(249,115,22,.04) 1px,transparent 1px);
  background-size:48px 48px;
}
.wrapper{
  position:relative;z-index:1;display:flex;
  max-width:820px;width:100%;margin:20px;
  border-radius:18px;overflow:hidden;
  box-shadow:0 24px 64px rgba(0,0,0,.5);
}
.left{
  flex:1;
  background:linear-gradient(135deg,rgba(249,115,22,.15),rgba(168,85,247,.1));
  border:1px solid rgba(249,115,22,.2);border-right:none;
  padding:40px 32px;display:flex;flex-direction:column;justify-content:space-between;
}
.left h1{font-size:26px;font-weight:800;color:#fff;line-height:1.2}
.left h1 span{color:#f97316}
.left h2{font-size:15px;font-weight:500;color:rgba(255,255,255,.5);margin-top:8px;line-height:1.5}
.cargo-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:28px}
.cargo-chip{
  background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.08);
  border-radius:10px;padding:12px 14px;
  display:flex;align-items:center;gap:8px;
  font-size:13px;font-weight:600;color:rgba(255,255,255,.7);
}
.cargo-chip span{font-size:20px}

.right{
  width:360px;min-width:360px;
  background:#13161e;
  border:1px solid rgba(255,255,255,.06);border-left:none;
  padding:40px 32px;
}
.brand{display:flex;align-items:center;gap:10px;margin-bottom:28px}
.brand-icon{
  width:42px;height:42px;background:linear-gradient(135deg,#f97316,#fb923c);
  border-radius:10px;display:flex;align-items:center;justify-content:center;
  font-size:20px;
}
.brand-name{font-size:18px;font-weight:800;color:#fff}
.brand-sub{font-size:11px;color:rgba(255,255,255,.35)}

.step-title{font-size:20px;font-weight:800;color:#fff;margin-bottom:4px}
.step-sub{font-size:13px;color:rgba(255,255,255,.4);margin-bottom:24px}

/* Cards de cargo */
.cargos-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:20px}
.cargo-card{
  background:rgba(255,255,255,.04);
  border:2px solid rgba(255,255,255,.07);
  border-radius:12px;padding:16px 12px;
  text-align:center;cursor:pointer;
  transition:all .18s;
  display:flex;flex-direction:column;align-items:center;gap:6px;
}
.cargo-card:hover{border-color:rgba(249,115,22,.4);background:rgba(249,115,22,.06)}
.cargo-card.selected{border-color:#f97316;background:rgba(249,115,22,.1)}
.cargo-card .ic{font-size:28px}
.cargo-card .lbl{font-size:12px;font-weight:700;color:rgba(255,255,255,.7)}
.cargo-card.selected .lbl{color:#f97316}

/* Input oculto do cargo */
#role-input{display:none}

/* Campos */
.fg{margin-bottom:16px}
.fg label{display:block;font-size:11px;font-weight:700;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:.6px;margin-bottom:6px}
.fg select,.fg input{
  width:100%;padding:11px 14px;border-radius:9px;
  background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);
  color:#fff;font-size:14px;
}
.fg select option{background:#13161e}
.fg select:focus,.fg input:focus{outline:none;border-color:#f97316;box-shadow:0 0 0 3px rgba(249,115,22,.1)}

/* Seletor de usuário (aparece quando há múltiplos) */
#usuario-wrap{display:none}

.inv{color:#f87171;font-size:12px;margin-top:5px}

.btn-login{
  width:100%;padding:13px;border-radius:10px;border:none;
  background:linear-gradient(135deg,#f97316,#fb923c);
  color:#fff;font-size:15px;font-weight:700;cursor:pointer;
  transition:all .18s;margin-top:4px;
}
.btn-login:hover{opacity:.88;transform:translateY(-1px)}
.btn-login:disabled{opacity:.4;cursor:not-allowed;transform:none}

.hint{margin-top:20px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06);border-radius:10px;padding:12px 14px}
.hint p{font-size:12px;color:rgba(255,255,255,.35);line-height:1.6}
.hint strong{display:block;font-size:10px;text-transform:uppercase;letter-spacing:.5px;color:rgba(255,255,255,.5);margin-bottom:6px}

/* Chip do cargo selecionado */
#cargo-selecionado{
  display:none;
  align-items:center;gap:10px;
  background:rgba(249,115,22,.08);border:1px solid rgba(249,115,22,.2);
  border-radius:10px;padding:10px 14px;margin-bottom:20px;cursor:pointer;
}
#cargo-selecionado .cs-ic{font-size:22px}
#cargo-selecionado .cs-info{flex:1}
#cargo-selecionado .cs-nome{font-size:13px;font-weight:700;color:#fff}
#cargo-selecionado .cs-trocar{font-size:11px;color:#f97316}
</style>
</head>
<body>

<div class="wrapper">
  
  <div class="left">
    <div>
      <h1>Restaurante<span>PRO</span></h1>
      <h2>Sistema completo de gestão para o seu restaurante</h2>
      <div class="cargo-grid">
        <div class="cargo-chip"><span>👔</span> Gerente</div>
        <div class="cargo-chip"><span>🍽️</span> Garçom</div>
        <div class="cargo-chip"><span>👨‍🍳</span> Chef</div>
        <div class="cargo-chip"><span>💰</span> Caixa</div>
      </div>
    </div>
    <p style="font-size:12px;color:rgba(255,255,255,.2)">© <?php echo e(date('Y')); ?> RestaurantePRO</p>
  </div>

  
  <div class="right">
    <div class="brand">
      <div class="brand-icon">🍳</div>
      <div>
        <div class="brand-name">RestaurantePRO</div>
        <div class="brand-sub">Sistema de Gestão</div>
      </div>
    </div>

    
    <?php if($errors->any()): ?>
    <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.2);border-radius:9px;padding:10px 14px;margin-bottom:16px;font-size:13px;color:#f87171">
      ❌ <?php echo e($errors->first()); ?>

    </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('login.post')); ?>" id="form-login">
      <?php echo csrf_field(); ?>
      <input type="hidden" name="role" id="role-input" value="<?php echo e(old('role')); ?>">
      <input type="hidden" name="user_id" id="user-id-input" value="<?php echo e(old('user_id')); ?>">

      
      <div id="step-cargo">
        <div class="step-title">Bem-vindo! 👋</div>
        <div class="step-sub">Selecione seu cargo para entrar</div>

        <div class="cargos-grid">
          <div class="cargo-card <?php echo e(old('role')==='gerente'?'selected':''); ?>" onclick="selecionarCargo('gerente','👔','Gerente')">
            <div class="ic">👔</div>
            <div class="lbl">Gerente</div>
          </div>
          <div class="cargo-card <?php echo e(old('role')==='garcom'?'selected':''); ?>" onclick="selecionarCargo('garcom','🍽️','Garçom')">
            <div class="ic">🍽️</div>
            <div class="lbl">Garçom</div>
          </div>
          <div class="cargo-card <?php echo e(old('role')==='chef'?'selected':''); ?>" onclick="selecionarCargo('chef','👨‍🍳','Chef')">
            <div class="ic">👨‍🍳</div>
            <div class="lbl">Chef</div>
          </div>
          <div class="cargo-card <?php echo e(old('role')==='caixa'?'selected':''); ?>" onclick="selecionarCargo('caixa','💰','Caixa')">
            <div class="ic">💰</div>
            <div class="lbl">Caixa</div>
          </div>
        </div>
      </div>

      
      <div id="step-senha" style="display:<?php echo e(old('role') ? 'block' : 'none'); ?>">

        
        <div id="cargo-selecionado" style="display:<?php echo e(old('role') ? 'flex' : 'none'); ?>" onclick="trocarCargo()">
          <div class="cs-ic" id="cs-ic"><?php echo e(old('role') === 'gerente' ? '👔' : (old('role') === 'garcom' ? '🍽️' : (old('role') === 'chef' ? '👨‍🍳' : '💰'))); ?></div>
          <div class="cs-info">
            <div class="cs-nome" id="cs-nome"><?php echo e(old('role') === 'gerente' ? 'Gerente' : (old('role') === 'garcom' ? 'Garçom' : (old('role') === 'chef' ? 'Chef' : 'Caixa'))); ?></div>
            <div class="cs-trocar">↩ Trocar cargo</div>
          </div>
        </div>

        
        <div class="fg" id="usuario-wrap" style="display:none">
          <label>Quem é você?</label>
          <select id="usuario-select" onchange="document.getElementById('user-id-input').value = this.value">
            <option value="">— Selecione seu nome —</option>
          </select>
        </div>

        <div class="fg">
          <label>Sua Senha</label>
          <input type="password" name="password" id="senha-input"
                 placeholder="••••••••" autocomplete="current-password"
                 autofocus>
          <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="inv"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <button type="submit" class="btn-login" id="btn-entrar">
          Entrar →
        </button>
      </div>

    </form>

    <div class="hint">
      <strong>Dica</strong>
      <p>Selecione seu cargo e digite sua senha. Cada pessoa tem uma senha individual.</p>
    </div>
  </div>
</div>

<script>
const cargos = {
  gerente: { ic: '👔', nome: 'Gerente' },
  garcom:  { ic: '🍽️', nome: 'Garçom' },
  chef:    { ic: '👨‍🍳', nome: 'Chef' },
  caixa:   { ic: '💰', nome: 'Caixa' },
};

// Se voltou com erro, cargo já estava selecionado
<?php if(old('role')): ?>
  document.getElementById('step-cargo').style.display = 'none';
  carregarUsuarios('<?php echo e(old("role")); ?>');
<?php endif; ?>

async function selecionarCargo(role, ic, nome) {
  // Marcar card
  document.querySelectorAll('.cargo-card').forEach(c => c.classList.remove('selected'));
  event.currentTarget.classList.add('selected');

  // Setar input hidden
  document.getElementById('role-input').value = role;
  document.getElementById('user-id-input').value = '';

  // Mostrar chip do cargo
  document.getElementById('cs-ic').textContent   = ic;
  document.getElementById('cs-nome').textContent  = nome;
  document.getElementById('cargo-selecionado').style.display = 'flex';

  // Esconder step-cargo, mostrar step-senha
  document.getElementById('step-cargo').style.display = 'none';
  document.getElementById('step-senha').style.display  = 'block';

  await carregarUsuarios(role);

  document.getElementById('senha-input').focus();
}

async function carregarUsuarios(role) {
  try {
    const res  = await fetch(`/login/usuarios?role=${role}`);
    const data = await res.json();

    const wrap = document.getElementById('usuario-wrap');
    const sel  = document.getElementById('usuario-select');

    if (data.length > 1) {
      sel.innerHTML = '<option value="">— Selecione seu nome —</option>';
      data.forEach(u => {
        const opt = document.createElement('option');
        opt.value = u.id;
        opt.textContent = u.name;
        <?php if(old('user_id')): ?>
        if (u.id == <?php echo e(old('user_id', 0)); ?>) opt.selected = true;
        <?php endif; ?>
        sel.appendChild(opt);
      });
      wrap.style.display = 'block';
    } else {
      wrap.style.display = 'none';
      if (data.length === 1) {
        document.getElementById('user-id-input').value = data[0].id;
      }
    }
  } catch(e) {
    console.error('Erro ao carregar usuários:', e);
  }
}

function toggleSenha() {
  const input = document.getElementById('senha-input');
  const btn   = document.getElementById('btn-toggle-senha');
  if (input.type === 'password') {
    input.type = 'text';
    btn.style.color = '#f97316';
  } else {
    input.type = 'password';
    btn.style.color = 'rgba(255,255,255,.4)';
  }
}

function trocarCargo() {
  document.getElementById('step-cargo').style.display  = 'block';
  document.getElementById('step-senha').style.display   = 'none';
  document.getElementById('cargo-selecionado').style.display = 'none';
  document.getElementById('usuario-wrap').style.display = 'none';
  document.getElementById('role-input').value           = '';
  document.getElementById('user-id-input').value        = '';
  document.querySelectorAll('.cargo-card').forEach(c => c.classList.remove('selected'));
}
</script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\project_corrigido\resources\views/auth/login.blade.php ENDPATH**/ ?>