<!DOCTYPE html>
<html lang="pt-BR" data-theme="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<title>Login — RestaurantePRO</title>
<style>
*, *::before, *::after {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

/* ============================================
   TEMAS DARK / LIGHT
   ============================================ */
[data-theme="dark"] {
  --bg-base: #0a0c12;
  --card-bg: #11151e;
  --border-light: rgba(255, 255, 255, 0.08);
  --text-primary: #edf2f7;
  --text-secondary: #a0aec0;
  --text-muted: #718096;
  --accent: #f97316;
  --accent-hover: #fb923c;
  --accent-glow: rgba(249, 115, 22, 0.25);
  --input-bg: rgba(255, 255, 255, 0.04);
  --input-border: rgba(255, 255, 255, 0.1);
  --shadow-md: 0 25px 45px -12px rgba(0, 0, 0, 0.5);
  --gradient-accent: linear-gradient(135deg, #f97316 0%, #fdba74 100%);
}

[data-theme="light"] {
  --bg-base: #f1f5f9;
  --card-bg: #ffffff;
  --border-light: rgba(0, 0, 0, 0.08);
  --text-primary: #0f172a;
  --text-secondary: #334155;
  --text-muted: #64748b;
  --accent: #ea580c;
  --accent-hover: #f97316;
  --accent-glow: rgba(234, 88, 12, 0.12);
  --input-bg: #f8fafc;
  --input-border: #e2e8f0;
  --shadow-md: 0 20px 35px -10px rgba(0, 0, 0, 0.1);
  --gradient-accent: linear-gradient(135deg, #ea580c, #f97316);
}

body {
  font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, Helvetica, sans-serif;
  background: var(--bg-base);
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background 0.25s ease;
  padding: 1.5rem;
}

/* fundo sutil */
body::before {
  content: '';
  position: fixed;
  inset: 0;
  background-image: 
    radial-gradient(circle at 20% 30%, var(--accent-glow) 0.8px, transparent 1px);
  background-size: 32px 32px;
  opacity: 0.4;
  pointer-events: none;
}

/* container principal - apenas o card de login */
.login-wrapper {
  width: 100%;
  max-width: 460px;
  margin: 0 auto;
}

.login-card {
  background: var(--card-bg);
  border-radius: 2rem;
  padding: 2.2rem 1.8rem;
  box-shadow: var(--shadow-md);
  border: 1px solid var(--border-light);
  transition: all 0.25s;
  backdrop-filter: blur(2px);
}

/* cabeçalho */
.card-header {
  text-align: center;
  margin-bottom: 2rem;
}

.logo-badge {
  display: inline-block;
  background: rgba(249, 115, 22, 0.12);
  padding: 0.3rem 1rem;
  border-radius: 40px;
  font-size: 0.7rem;
  font-weight: 700;
  color: var(--accent);
  letter-spacing: 0.5px;
  margin-bottom: 1rem;
}

.card-header h1 {
  font-size: 1.8rem;
  font-weight: 800;
  background: linear-gradient(135deg, var(--text-primary) 30%, var(--accent) 80%);
  background-clip: text;
  -webkit-background-clip: text;
  color: transparent;
  letter-spacing: -0.3px;
}

.card-header p {
  color: var(--text-muted);
  font-size: 0.85rem;
  margin-top: 0.5rem;
}

/* alerta de erro */
.alert-error {
  background: rgba(239, 68, 68, 0.12);
  border-left: 3px solid #ef4444;
  padding: 0.75rem 1rem;
  border-radius: 1rem;
  margin-bottom: 1.5rem;
  font-size: 0.8rem;
  color: #fca5a5;
  display: flex;
  gap: 8px;
  align-items: center;
}

/* cards de seleção de cargo */
.role-section {
  margin-bottom: 0.5rem;
}

.section-label {
  font-size: 0.7rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.6px;
  color: var(--text-muted);
  margin-bottom: 0.8rem;
  display: block;
}

.role-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 10px;
  margin-bottom: 0.5rem;
}

.role-card {
  background: var(--input-bg);
  border: 1.5px solid var(--input-border);
  border-radius: 1rem;
  padding: 0.9rem 0.4rem;
  text-align: center;
  cursor: pointer;
  transition: all 0.2s ease;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 6px;
}

.role-card:hover {
  border-color: var(--accent);
  background: rgba(249, 115, 22, 0.08);
  transform: translateY(-2px);
}

.role-card.selected {
  border-color: var(--accent);
  background: rgba(249, 115, 22, 0.12);
  box-shadow: 0 4px 12px rgba(249, 115, 22, 0.15);
}

.role-emoji {
  font-size: 1.8rem;
}

.role-name {
  font-size: 0.75rem;
  font-weight: 700;
  color: var(--text-secondary);
}

.role-card.selected .role-name {
  color: var(--accent);
}

/* chip de cargo selecionado (estilo moderno) */
.selected-chip {
  display: flex;
  align-items: center;
  gap: 12px;
  background: rgba(249, 115, 22, 0.12);
  border-radius: 60px;
  padding: 0.6rem 1.2rem;
  margin-bottom: 1.5rem;
  border: 1px solid rgba(249, 115, 22, 0.3);
  cursor: pointer;
  transition: 0.15s;
}

.selected-chip:hover {
  background: rgba(249, 115, 22, 0.2);
}

.chip-emoji {
  font-size: 1.5rem;
}

.chip-text {
  flex: 1;
}

.chip-role {
  font-weight: 800;
  font-size: 0.9rem;
  color: var(--text-primary);
}

.chip-action {
  font-size: 0.7rem;
  color: var(--accent);
  font-weight: 600;
}

/* campos de input */
.input-group {
  margin-bottom: 1.2rem;
}

.input-group label {
  display: block;
  font-size: 0.7rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: var(--text-muted);
  margin-bottom: 0.5rem;
}

.input-group input,
.input-group select {
  width: 100%;
  padding: 0.85rem 1rem;
  background: var(--input-bg);
  border: 1px solid var(--input-border);
  border-radius: 1rem;
  font-size: 0.9rem;
  color: var(--text-primary);
  transition: all 0.2s;
  font-family: inherit;
}

.input-group input:focus,
.input-group select:focus {
  outline: none;
  border-color: var(--accent);
  box-shadow: 0 0 0 3px var(--accent-glow);
}

.input-group input.invalid {
  border-color: #ef4444;
}

.error-msg {
  color: #f87171;
  font-size: 0.7rem;
  margin-top: 5px;
  display: flex;
  align-items: center;
  gap: 4px;
}

/* botão principal */
.btn-login {
  background: var(--gradient-accent);
  border: none;
  width: 100%;
  padding: 0.9rem;
  border-radius: 2rem;
  font-weight: 800;
  font-size: 0.9rem;
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  cursor: pointer;
  transition: all 0.2s ease;
  margin-top: 0.5rem;
  box-shadow: 0 6px 14px rgba(249, 115, 22, 0.3);
}

.btn-login:hover {
  filter: brightness(1.05);
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(249, 115, 22, 0.35);
}

/* botão tema flutuante */
.theme-toggle {
  position: fixed;
  bottom: 20px;
  right: 20px;
  width: 44px;
  height: 44px;
  border-radius: 30px;
  background: var(--card-bg);
  border: 1px solid var(--border-light);
  backdrop-filter: blur(8px);
  color: var(--text-primary);
  font-size: 1.3rem;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 99;
  transition: 0.2s;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.theme-toggle:hover {
  border-color: var(--accent);
  transform: scale(1.05);
}

/* responsividade */
@media (max-width: 500px) {
  body { padding: 1rem; }
  .login-card { padding: 1.8rem 1.4rem; border-radius: 1.5rem; }
  .role-grid { gap: 8px; }
  .role-emoji { font-size: 1.5rem; }
  .card-header h1 { font-size: 1.6rem; }
}
</style>
</head>
<body>

<button class="theme-toggle" id="themeToggleBtn" aria-label="Alternar tema">🌙</button>

<div class="login-wrapper">
  <div class="login-card">
    
    <div class="card-header">
      <div class="logo-badge">✦ RESTAURANTEPRO</div>
      <h1>Acesse sua conta</h1>
      <p>Informe suas credenciais para continuar</p>
    </div>

    @if($errors->any())
    <div class="alert-error">
      <span>⚠️</span> {{ $errors->first() }}
    </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}" id="loginForm" novalidate>
      @csrf
      <input type="hidden" name="role" id="roleHidden" value="{{ old('role') }}">
      <input type="hidden" name="user_id" id="userIdHidden" value="{{ old('user_id') }}">

      <!-- PASSO 1: Selecionar cargo -->
      <div id="stepRole" style="display: {{ old('role') ? 'none' : 'block' }};">
        <div class="role-section">
          <span class="section-label">👥 Selecione seu perfil</span>
          <div class="role-grid">
            <div class="role-card {{ old('role')==='gerente' ? 'selected' : '' }}" data-role="gerente" data-icon="👔" data-name="Gerente">
              <div class="role-emoji">👔</div>
              <div class="role-name">Gerente</div>
            </div>
            <div class="role-card {{ old('role')==='garcom' ? 'selected' : '' }}" data-role="garcom" data-icon="🍽️" data-name="Garçom">
              <div class="role-emoji">🍽️</div>
              <div class="role-name">Garçom</div>
            </div>
            <div class="role-card {{ old('role')==='chef' ? 'selected' : '' }}" data-role="chef" data-icon="👨‍🍳" data-name="Chef">
              <div class="role-emoji">👨‍🍳</div>
              <div class="role-name">Chef</div>
            </div>
            <div class="role-card {{ old('role')==='caixa' ? 'selected' : '' }}" data-role="caixa" data-icon="💰" data-name="Caixa">
              <div class="role-emoji">💰</div>
              <div class="role-name">Caixa</div>
            </div>
          </div>
        </div>
      </div>

      <!-- PASSO 2: Credenciais (email, usuário, senha) -->
      <div id="stepCredentials" style="display: {{ old('role') ? 'block' : 'none' }};">
        
        <!-- Chip do cargo selecionado (clique para trocar) -->
        <div id="selectedChip" class="selected-chip" onclick="resetRoleSelection()" style="display: {{ old('role') ? 'flex' : 'none' }};">
          <div class="chip-emoji" id="chipEmoji">{{ old('role') === 'gerente' ? '👔' : (old('role') === 'garcom' ? '🍽️' : (old('role') === 'chef' ? '👨‍🍳' : '💰')) }}</div>
          <div class="chip-text">
            <div class="chip-role" id="chipRoleName">{{ old('role') === 'gerente' ? 'Gerente' : (old('role') === 'garcom' ? 'Garçom' : (old('role') === 'chef' ? 'Chef' : 'Caixa')) }}</div>
            <div class="chip-action">↺ Trocar perfil</div>
          </div>
        </div>

        <!-- E-mail -->
        <div class="input-group">
          <label>📧 E-mail</label>
          <input type="email" name="email" id="emailField" value="{{ old('email') }}" placeholder="seu@email.com" autocomplete="email" oninput="validateEmail(this)">
          <div class="error-msg" id="emailError" style="display: none;">❌ Informe um e-mail válido</div>
          @error('email')<div class="error-msg">{{ $message }}</div>@enderror
        </div>

        <!-- Select de usuários (caso múltiplos para o cargo) -->
        <div class="input-group" id="userGroup" style="display: none;">
          <label>👤 Colaborador</label>
          <select id="userSelect" onchange="syncUser()">
            <option value="">— Selecione seu nome —</option>
          </select>
        </div>

        <!-- Senha -->
        <div class="input-group">
          <label>🔒 Senha</label>
          <input type="password" name="password" id="passwordField" placeholder="••••••••" autocomplete="current-password">
          @error('password')<div class="error-msg">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn-login" onclick="return validateForm()">
          ✨ Entrar →
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  // ========== TEMA ==========
  (function() {
    const savedTheme = localStorage.getItem('rp_theme_simple') || 'dark';
    document.documentElement.setAttribute('data-theme', savedTheme);
    const themeBtn = document.getElementById('themeToggleBtn');
    if(themeBtn) themeBtn.textContent = savedTheme === 'dark' ? '🌙' : '☀️';
  })();
  
  function toggleTheme() {
    const current = document.documentElement.getAttribute('data-theme');
    const next = current === 'dark' ? 'light' : 'dark';
    localStorage.setItem('rp_theme_simple', next);
    document.documentElement.setAttribute('data-theme', next);
    const btn = document.getElementById('themeToggleBtn');
    if(btn) btn.textContent = next === 'dark' ? '🌙' : '☀️';
  }
  document.getElementById('themeToggleBtn')?.addEventListener('click', toggleTheme);

  // ========== LÓGICA DE LOGIN ==========
  let currentRoleVal = "{{ old('role') }}";
  let currentRoleIcon = "{{ old('role') === 'gerente' ? '👔' : (old('role') === 'garcom' ? '🍽️' : (old('role') === 'chef' ? '👨‍🍳' : '💰')) }}";
  let currentRoleDisplay = "{{ old('role') === 'gerente' ? 'Gerente' : (old('role') === 'garcom' ? 'Garçom' : (old('role') === 'chef' ? 'Chef' : 'Caixa')) }}";

  // se já houver role antiga (validação falhou), carrega usuários
  @if(old('role'))
    document.addEventListener('DOMContentLoaded', () => loadUsers("{{ old('role') }}"));
  @endif

  // seleção de cargo via cards
  document.querySelectorAll('.role-card').forEach(card => {
    card.addEventListener('click', async function(e) {
      const role = this.getAttribute('data-role');
      const icon = this.getAttribute('data-icon');
      const name = this.getAttribute('data-name');
      
      document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
      this.classList.add('selected');
      
      currentRoleVal = role;
      currentRoleIcon = icon;
      currentRoleDisplay = name;
      
      document.getElementById('roleHidden').value = role;
      document.getElementById('userIdHidden').value = '';
      
      // atualiza chip
      document.getElementById('chipEmoji').textContent = icon;
      document.getElementById('chipRoleName').textContent = name;
      document.getElementById('selectedChip').style.display = 'flex';
      
      // troca telas
      document.getElementById('stepRole').style.display = 'none';
      document.getElementById('stepCredentials').style.display = 'block';
      
      await loadUsers(role);
      document.getElementById('emailField').focus();
    });
  });

  async function loadUsers(role) {
    try {
      const res = await fetch(`/login/usuarios?role=${role}`);
      const data = await res.json();
      const userGroupDiv = document.getElementById('userGroup');
      const selectEl = document.getElementById('userSelect');
      
      if(data && data.length > 1) {
        selectEl.innerHTML = '<option value="">— Selecione seu nome —</option>';
        data.forEach(user => {
          const opt = document.createElement('option');
          opt.value = user.id;
          opt.textContent = user.name;
          @if(old('user_id')) if(user.id == {{ old('user_id',0) }}) opt.selected = true; @endif
          selectEl.appendChild(opt);
        });
        userGroupDiv.style.display = 'block';
        if(selectEl.value) document.getElementById('userIdHidden').value = selectEl.value;
      } else if(data && data.length === 1) {
        userGroupDiv.style.display = 'none';
        document.getElementById('userIdHidden').value = data[0].id;
      } else {
        userGroupDiv.style.display = 'none';
        document.getElementById('userIdHidden').value = '';
      }
    } catch(err) {
      console.warn("Erro ao carregar usuários:", err);
    }
  }

  function syncUser() {
    const select = document.getElementById('userSelect');
    document.getElementById('userIdHidden').value = select ? select.value : '';
  }

  // validação de email em tempo real
  function validateEmail(input) {
    const regex = /^[^\s@]+@([^\s@]+\.)+[^\s@]+$/;
    const errorSpan = document.getElementById('emailError');
    if(!input.value.trim()) {
      input.classList.remove('invalid');
      errorSpan.style.display = 'none';
      return false;
    }
    if(regex.test(input.value.trim())) {
      input.classList.remove('invalid');
      errorSpan.style.display = 'none';
      return true;
    } else {
      input.classList.add('invalid');
      errorSpan.style.display = 'flex';
      return false;
    }
  }

  function validateForm() {
    const emailInput = document.getElementById('emailField');
    const passwordInput = document.getElementById('passwordField');
    let isValid = true;
    
    // valida email
    if(!emailInput.value.trim()) {
      emailInput.classList.add('invalid');
      const errSpan = document.getElementById('emailError');
      errSpan.innerHTML = '❌ O e-mail é obrigatório';
      errSpan.style.display = 'flex';
      isValid = false;
    } else if(!validateEmail(emailInput)) {
      isValid = false;
    }
    
    // valida senha
    if(!passwordInput.value.trim()) {
      passwordInput.classList.add('invalid');
      isValid = false;
    } else {
      passwordInput.classList.remove('invalid');
    }
    
    if(!currentRoleVal) {
      alert("Por favor, selecione um cargo antes de continuar.");
      isValid = false;
    }
    
    return isValid;
  }

  function resetRoleSelection() {
    document.getElementById('stepRole').style.display = 'block';
    document.getElementById('stepCredentials').style.display = 'none';
    document.getElementById('selectedChip').style.display = 'none';
    document.getElementById('userGroup').style.display = 'none';
    document.getElementById('roleHidden').value = '';
    document.getElementById('userIdHidden').value = '';
    currentRoleVal = '';
    document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
  }
</script>
</body>
</html>