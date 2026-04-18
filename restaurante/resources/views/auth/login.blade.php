<!DOCTYPE html>
<html lang="pt-BR" data-theme="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — RestaurantePRO</title>
<style>
*,*::before,*::after{margin:0;padding:0;box-sizing:border-box}

/* Temas */
[data-theme="dark"]{
  --bg:#0d0f14;--card:#13161e;--border:rgba(255,255,255,.08);
  --text:#e2e8f0;--muted:rgba(255,255,255,.4);
  --input-bg:rgba(255,255,255,.05);--input-border:rgba(255,255,255,.1);
  --left-bg:linear-gradient(135deg,rgba(249,115,22,.15),rgba(168,85,247,.1));
}
[data-theme="light"]{
  --bg:#f0f2f5;--card:#ffffff;--border:rgba(0,0,0,.09);
  --text:#1e293b;--muted:rgba(0,0,0,.45);
  --input-bg:rgba(0,0,0,.03);--input-border:rgba(0,0,0,.12);
  --left-bg:linear-gradient(135deg,rgba(249,115,22,.08),rgba(168,85,247,.05));
}

body{
  font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Arial,sans-serif;
  background:var(--bg);min-height:100vh;
  display:flex;align-items:center;justify-content:center;
  transition:background .25s;
}
body::before{
  content:'';position:fixed;inset:0;z-index:0;
  background-image:linear-gradient(rgba(249,115,22,.04) 1px,transparent 1px),
    linear-gradient(90deg,rgba(249,115,22,.04) 1px,transparent 1px);
  background-size:48px 48px;pointer-events:none;
}

.wrapper{
  position:relative;z-index:1;display:flex;
  max-width:760px;width:100%;margin:20px;
  border-radius:18px;overflow:hidden;
  box-shadow:0 24px 64px rgba(0,0,0,.35);
}

/* Botão tema no canto */
.btn-theme-login{
  position:fixed;top:16px;right:16px;z-index:10;
  width:38px;height:38px;border-radius:10px;
  border:1px solid var(--border);background:var(--card);
  color:var(--text);cursor:pointer;font-size:18px;
  display:flex;align-items:center;justify-content:center;
  transition:all .15s;box-shadow:0 2px 8px rgba(0,0,0,.2);
}
.btn-theme-login:hover{border-color:#f97316;color:#f97316}

/* --- Lado esquerdo limpo (sem cards de cargo sem funcionalidade) --- */
.left{
  flex:1;
  background:var(--left-bg);
  border:1px solid rgba(249,115,22,.18);border-right:none;
  padding:44px 36px;display:flex;flex-direction:column;justify-content:center;gap:28px;
}
.left-logo{display:flex;align-items:center;gap:12px}
.left-icon{
  width:52px;height:52px;background:linear-gradient(135deg,#f97316,#fb923c);
  border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:26px;
  box-shadow:0 8px 24px rgba(249,115,22,.35);flex-shrink:0;
}
.left-title{font-size:24px;font-weight:900;color:var(--text);line-height:1.2}
.left-title span{color:#f97316}
.left-sub{font-size:14px;color:var(--muted);line-height:1.6}

.features{display:flex;flex-direction:column;gap:12px}
.feat-item{display:flex;align-items:center;gap:10px;font-size:13px;color:var(--muted)}
.feat-dot{width:6px;height:6px;border-radius:50%;background:#f97316;flex-shrink:0}

/* --- Lado direito (formulário) --- */
.right{
  width:360px;min-width:320px;
  background:var(--card);
  border:1px solid var(--border);border-left:none;
  padding:40px 32px;
  transition:background .25s;
}
.brand{display:flex;align-items:center;gap:10px;margin-bottom:28px}
.brand-icon{
  width:40px;height:40px;background:linear-gradient(135deg,#f97316,#fb923c);
  border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:19px;
}
.brand-name{font-size:17px;font-weight:800;color:var(--text)}
.brand-sub{font-size:11px;color:var(--muted)}

.step-title{font-size:20px;font-weight:800;color:var(--text);margin-bottom:4px}
.step-sub{font-size:13px;color:var(--muted);margin-bottom:22px}

/* Cards de cargo */
.cargos-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:20px}
.cargo-card{
  background:var(--input-bg);border:2px solid var(--input-border);
  border-radius:12px;padding:14px 10px;text-align:center;cursor:pointer;
  transition:all .18s;display:flex;flex-direction:column;align-items:center;gap:6px;
}
.cargo-card:hover{border-color:rgba(249,115,22,.4);background:rgba(249,115,22,.06)}
.cargo-card.selected{border-color:#f97316;background:rgba(249,115,22,.1)}
.cargo-card .ic{font-size:26px}
.cargo-card .lbl{font-size:12px;font-weight:700;color:var(--muted)}
.cargo-card.selected .lbl{color:#f97316}

/* Chip cargo selecionado */
#cargo-selecionado{
  display:none;align-items:center;gap:10px;
  background:rgba(249,115,22,.08);border:1px solid rgba(249,115,22,.2);
  border-radius:10px;padding:10px 14px;margin-bottom:18px;cursor:pointer;
}
#cargo-selecionado .cs-ic{font-size:20px}
#cargo-selecionado .cs-nome{font-size:13px;font-weight:700;color:var(--text)}
#cargo-selecionado .cs-trocar{font-size:11px;color:#f97316}

/* Campos */
.fg{margin-bottom:15px}
.fg label{display:block;font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.6px;margin-bottom:6px}
.fg input,.fg select{
  width:100%;padding:11px 14px;border-radius:9px;
  background:var(--input-bg);border:1px solid var(--input-border);
  color:var(--text);font-size:14px;font-family:inherit;transition:.15s;
}
.fg input:focus,.fg select:focus{outline:none;border-color:#f97316;box-shadow:0 0 0 3px rgba(249,115,22,.1)}
.fg input.invalid{border-color:#ef4444!important;box-shadow:0 0 0 3px rgba(239,68,68,.1)}
.fg select option{background:var(--card)}

#usuario-wrap{display:none}
.inv{color:#f87171;font-size:12px;margin-top:5px}

.btn-login{
  width:100%;padding:13px;border-radius:10px;border:none;
  background:linear-gradient(135deg,#f97316,#fb923c);
  color:#fff;font-size:15px;font-weight:700;cursor:pointer;
  transition:all .18s;margin-top:4px;
}
.btn-login:hover{opacity:.88;transform:translateY(-1px)}

/* ===== MOBILE ===== */
@media(max-width:620px){
  body{align-items:flex-start;padding-top:0}
  .wrapper{
    margin:0;border-radius:0;min-height:100vh;
    flex-direction:column;
  }
  .left{
    padding:28px 24px 20px;gap:16px;
    border:none;border-bottom:1px solid rgba(249,115,22,.18);
  }
  .features{display:none}
  .right{
    width:100%;min-width:unset;border:none;
    padding:28px 24px;flex:1;
  }
  .cargos-grid{gap:8px}
  .cargo-card{padding:12px 8px}
  .cargo-card .ic{font-size:22px}
}
</style>
</head>
<body>

<button class="btn-theme-login" id="btn-theme" onclick="toggleTheme()" title="Alternar tema">🌙</button>

<div class="wrapper">
  {{-- Lado esquerdo — apenas branding e features --}}
  <div class="left">
    <div>
      <div class="left-logo">
        <div class="left-icon">🍳</div>
        <div>
          <div class="left-title">Restaurante<span>PRO</span></div>
          <div class="left-sub" style="font-size:12px;margin-top:2px">Sistema de Gestão</div>
        </div>
      </div>
      <p class="left-sub" style="margin-top:16px">Gerencie seu restaurante com eficiência e controle total.</p>
    </div>
    <div class="features">
      <div class="feat-item"><div class="feat-dot"></div> Controle completo de estoque</div>
      <div class="feat-item"><div class="feat-dot"></div> Gestão de pedidos em tempo real</div>
      <div class="feat-item"><div class="feat-dot"></div> Relatórios financeiros detalhados</div>
      <div class="feat-item"><div class="feat-dot"></div> Múltiplos perfis de acesso</div>
    </div>
    <p style="font-size:11px;color:var(--muted)">© {{ date('Y') }} RestaurantePRO</p>
  </div>

  {{-- Lado direito — formulário --}}
  <div class="right">
    <div class="brand">
      <div class="brand-icon">🍳</div>
      <div>
        <div class="brand-name">RestaurantePRO</div>
        <div class="brand-sub">Faça seu login</div>
      </div>
    </div>

    @if($errors->any())
    <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.2);border-radius:9px;padding:10px 14px;margin-bottom:16px;font-size:13px;color:#f87171">
      ❌ {{ $errors->first() }}
    </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}" id="form-login" novalidate>
      @csrf
      <input type="hidden" name="role" id="role-input" value="{{ old('role') }}">
      <input type="hidden" name="user_id" id="user-id-input" value="{{ old('user_id') }}">

      {{-- PASSO 1: Selecionar cargo --}}
      <div id="step-cargo" style="display:{{ old('role') ? 'none' : 'block' }}">
        <div class="step-title">Bem-vindo! 👋</div>
        <div class="step-sub">Selecione seu cargo</div>
        <div class="cargos-grid">
          <div class="cargo-card {{ old('role')==='gerente'?'selected':'' }}" onclick="selecionarCargo('gerente','👔','Gerente')">
            <div class="ic">👔</div><div class="lbl">Gerente</div>
          </div>
          <div class="cargo-card {{ old('role')==='garcom'?'selected':'' }}" onclick="selecionarCargo('garcom','🍽️','Garçom')">
            <div class="ic">🍽️</div><div class="lbl">Garçom</div>
          </div>
          <div class="cargo-card {{ old('role')==='chef'?'selected':'' }}" onclick="selecionarCargo('chef','👨‍🍳','Chef')">
            <div class="ic">👨‍🍳</div><div class="lbl">Chef</div>
          </div>
          <div class="cargo-card {{ old('role')==='caixa'?'selected':'' }}" onclick="selecionarCargo('caixa','💰','Caixa')">
            <div class="ic">💰</div><div class="lbl">Caixa</div>
          </div>
        </div>
      </div>

      {{-- PASSO 2: Email + Senha --}}
      <div id="step-senha" style="display:{{ old('role') ? 'block' : 'none' }}">

        <div id="cargo-selecionado" style="display:{{ old('role') ? 'flex' : 'none' }}" onclick="trocarCargo()">
          <div class="cs-ic" id="cs-ic">{{ old('role') === 'gerente' ? '👔' : (old('role') === 'garcom' ? '🍽️' : (old('role') === 'chef' ? '👨‍🍳' : '💰')) }}</div>
          <div style="flex:1">
            <div class="cs-nome" id="cs-nome">{{ old('role') === 'gerente' ? 'Gerente' : (old('role') === 'garcom' ? 'Garçom' : (old('role') === 'chef' ? 'Chef' : 'Caixa')) }}</div>
            <div class="cs-trocar">↩ Trocar cargo</div>
          </div>
        </div>

        <div class="fg">
          <label>E-mail</label>
          <input type="email" name="email" id="email-input"
                 value="{{ old('email') }}" placeholder="seu@email.com"
                 autocomplete="email" oninput="validarEmail(this)" required>
          <div class="inv" id="email-erro" style="display:none">Informe um e-mail válido.</div>
          @error('email')<div class="inv">{{ $message }}</div>@enderror
        </div>

        <div class="fg" id="usuario-wrap">
          <label>Quem é você?</label>
          <select id="usuario-select" onchange="document.getElementById('user-id-input').value=this.value">
            <option value="">— Selecione seu nome —</option>
          </select>
        </div>

        <div class="fg">
          <label>Senha</label>
          <input type="password" name="password" id="senha-input"
                 placeholder="••••••••" autocomplete="current-password">
          @error('password')<div class="inv">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn-login" onclick="return validarForm()">Entrar →</button>
      </div>
    </form>
  </div>
</div>

<script>
// Tema
(function(){
  const t = localStorage.getItem('rp-theme') || 'dark';
  document.documentElement.setAttribute('data-theme', t);
  const btn = document.getElementById('btn-theme');
  if(btn) btn.textContent = t === 'dark' ? '🌙' : '☀️';
})();
function toggleTheme(){
  const cur = document.documentElement.getAttribute('data-theme') || 'dark';
  const next = cur === 'dark' ? 'light' : 'dark';
  localStorage.setItem('rp-theme', next);
  document.documentElement.setAttribute('data-theme', next);
  document.getElementById('btn-theme').textContent = next === 'dark' ? '🌙' : '☀️';
}

// Login
@if(old('role'))
  document.getElementById('step-cargo').style.display = 'none';
  carregarUsuarios('{{ old("role") }}');
@endif

function validarEmail(input){
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const erroEl = document.getElementById('email-erro');
  if(!input.value || re.test(input.value)){
    input.classList.remove('invalid');
    erroEl.style.display = 'none';
    return true;
  }
  input.classList.add('invalid');
  erroEl.style.display = 'block';
  return false;
}
function validarForm(){
  const ei = document.getElementById('email-input');
  if(!ei.value.trim()){
    ei.classList.add('invalid');
    document.getElementById('email-erro').textContent = 'O e-mail é obrigatório.';
    document.getElementById('email-erro').style.display = 'block';
    ei.focus(); return false;
  }
  return validarEmail(ei) ? true : (ei.focus(), false);
}
async function selecionarCargo(role, ic, nome){
  document.querySelectorAll('.cargo-card').forEach(c => c.classList.remove('selected'));
  event.currentTarget.classList.add('selected');
  document.getElementById('role-input').value = role;
  document.getElementById('user-id-input').value = '';
  document.getElementById('cs-ic').textContent = ic;
  document.getElementById('cs-nome').textContent = nome;
  document.getElementById('cargo-selecionado').style.display = 'flex';
  document.getElementById('step-cargo').style.display = 'none';
  document.getElementById('step-senha').style.display = 'block';
  await carregarUsuarios(role);
  document.getElementById('email-input').focus();
}
async function carregarUsuarios(role){
  try{
    const res = await fetch(`/login/usuarios?role=${role}`);
    const data = await res.json();
    const wrap = document.getElementById('usuario-wrap');
    const sel = document.getElementById('usuario-select');
    if(data.length > 1){
      sel.innerHTML = '<option value="">— Selecione seu nome —</option>';
      data.forEach(u => {
        const opt = document.createElement('option');
        opt.value = u.id; opt.textContent = u.name;
        @if(old('user_id')) if(u.id == {{ old('user_id',0) }}) opt.selected = true; @endif
        sel.appendChild(opt);
      });
      wrap.style.display = 'block';
    } else {
      wrap.style.display = 'none';
      if(data.length === 1) document.getElementById('user-id-input').value = data[0].id;
    }
  } catch(e){ console.error(e); }
}
function trocarCargo(){
  document.getElementById('step-cargo').style.display = 'block';
  document.getElementById('step-senha').style.display = 'none';
  document.getElementById('cargo-selecionado').style.display = 'none';
  document.getElementById('usuario-wrap').style.display = 'none';
  document.getElementById('role-input').value = '';
  document.getElementById('user-id-input').value = '';
  document.querySelectorAll('.cargo-card').forEach(c => c.classList.remove('selected'));
}
</script>
</body>
</html>
