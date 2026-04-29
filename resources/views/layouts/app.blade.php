<!DOCTYPE html>
<html lang="pt-BR" data-theme="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Font Awesome 6 (recomendado) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<title>@yield('page-title', 'Restaurante')</title>
<style>
*,*::before,*::after{margin:0;padding:0;box-sizing:border-box}

/* ===== TEMA ESCURO (padrão) ===== */
:root,[data-theme="dark"]{
  --bg:#0d0f14;--bg2:#13161e;--bg3:#1a1e2a;
  --border:rgba(255,255,255,.08);
  --accent:#f97316;--green:#22c55e;--red:#ef4444;
  --yellow:#eab308;--blue:#3b82f6;--purple:#a855f7;
  --text:#e2e8f0;--muted:#64748b;
  --sidebar:250px;--radius:12px;
  --shadow:0 4px 24px rgba(0,0,0,.4);
  --topbar-bg:rgba(13,15,20,.95);
  --input-bg:rgba(255,255,255,.05);
  --input-border:rgba(255,255,255,.1);
  --card-hover:rgba(255,255,255,.02);
  --scrollbar:#1a1e2a;
}

/* ===== TEMA CLARO ===== */
[data-theme="light"]{
  --bg:#f0f2f5;--bg2:#ffffff;--bg3:#f8f9fb;
  --border:rgba(0,0,0,.09);
  --accent:#f97316;--green:#16a34a;--red:#dc2626;
  --yellow:#ca8a04;--blue:#2563eb;--purple:#9333ea;
  --text:#1e293b;--muted:#64748b;
  --shadow:0 4px 24px rgba(0,0,0,.08);
  --topbar-bg:rgba(255,255,255,.96);
  --input-bg:rgba(0,0,0,.03);
  --input-border:rgba(0,0,0,.12);
  --card-hover:rgba(0,0,0,.02);
  --scrollbar:#e2e8f0;
}
[data-theme="light"] body{background:var(--bg);color:var(--text)}
[data-theme="light"] .sidebar{background:var(--bg2);border-color:var(--border)}
[data-theme="light"] .sidebar nav a{color:var(--muted)}
[data-theme="light"] .sidebar nav a:hover{background:rgba(249,115,22,.07);color:#1e293b}
[data-theme="light"] .sidebar nav a.active{background:rgba(249,115,22,.12);color:var(--accent)}
[data-theme="light"] .sb-user{background:var(--bg3)}
[data-theme="light"] .topbar{background:var(--topbar-bg);border-color:var(--border);box-shadow:0 1px 8px rgba(0,0,0,.06)}
[data-theme="light"] .panel{background:var(--bg2);border-color:var(--border)}
[data-theme="light"] .table-wrap{background:var(--bg2);border-color:var(--border)}
[data-theme="light"] thead th{background:rgba(0,0,0,.02)}
[data-theme="light"] tbody tr:hover{background:var(--card-hover)}
[data-theme="light"] .form-control,[data-theme="light"] .form-select{background:var(--input-bg);border-color:var(--input-border);color:var(--text)}
[data-theme="light"] .form-select option{background:var(--bg2);color:var(--text)}
[data-theme="light"] .stat-card{background:var(--bg2);border-color:var(--border)}
[data-theme="light"] .btn-secondary{background:var(--bg3);color:var(--text);border-color:var(--border)}
[data-theme="light"] .btn-secondary:hover{background:rgba(0,0,0,.06)}
[data-theme="light"] .empty-state{color:var(--muted)}
[data-theme="light"] .td-primary{color:var(--text)}
[data-theme="light"] .sb-brand-name{color:#1e293b}
[data-theme="light"] .sb-brand-sub{color:var(--muted)}
[data-theme="light"] .sb-uname{color:#1e293b}
[data-theme="light"] .nav-ic{background:rgba(0,0,0,.04)}
[data-theme="light"] .topbar h1{color:#1e293b}
[data-theme="light"] .kpi{background:var(--bg2);border-color:var(--border)}
[data-theme="light"] .badge-secondary{background:rgba(100,116,139,.1);color:#475569}
[data-theme="light"] .alert-success{background:rgba(22,163,74,.08);border-color:rgba(22,163,74,.2)}
[data-theme="light"] .alert-error{background:rgba(220,38,38,.08);border-color:rgba(220,38,38,.2)}
[data-theme="light"] .mesa-card{background:var(--bg2);border-color:var(--border)}
[data-theme="light"] .mc-num{color:#1e293b}

html,body{height:100%}
body{
  font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Arial,sans-serif;
  background:var(--bg);color:var(--text);
  display:flex;min-height:100vh;font-size:14px;line-height:1.5;
  transition:background .25s,color .25s;
}
::-webkit-scrollbar{width:4px}
::-webkit-scrollbar-track{background:var(--bg)}
::-webkit-scrollbar-thumb{background:var(--scrollbar);border-radius:4px}

/* ===== SIDEBAR ===== */
.sidebar{
  width:var(--sidebar);background:var(--bg2);
  border-right:1px solid var(--border);
  position:fixed;top:0;left:0;height:100vh;
  display:flex;flex-direction:column;z-index:100;overflow-y:auto;
  transition:transform .28s cubic-bezier(.4,0,.2,1),background .25s;
  scroll-behavior:smooth;
}
.sb-brand{
  padding:18px 16px;border-bottom:1px solid var(--border);
  display:flex;align-items:center;gap:12px;flex-shrink:0;
}
.sb-logo{
  width:40px;height:40px;border-radius:10px;flex-shrink:0;
  background:linear-gradient(135deg,#f97316,#f59e0b);
  display:flex;align-items:center;justify-content:center;font-size:20px;
}
.sb-brand-name{font-size:14px;font-weight:800;color:#fff}
.sb-brand-sub{font-size:11px;color:var(--muted)}
.sb-user{
  margin:10px;padding:10px 12px;
  background:var(--bg3);border:1px solid var(--border);border-radius:10px;
  display:flex;align-items:center;gap:10px;flex-shrink:0;
}
.sb-avatar{
  width:34px;height:34px;border-radius:8px;flex-shrink:0;
  background:linear-gradient(135deg,var(--accent),var(--purple));
  display:flex;align-items:center;justify-content:center;
  font-weight:800;font-size:14px;color:#fff;
}
.sb-uname{font-size:13px;font-weight:600;color:#fff}
.sb-urole{font-size:11px;color:var(--accent);font-weight:600}
.sb-section{
  padding:12px 14px 4px;font-size:10px;font-weight:700;
  color:var(--muted);text-transform:uppercase;letter-spacing:1px;
}
.sidebar nav{flex:1;padding:4px 8px}
.sidebar nav a{
  display:flex;align-items:center;gap:10px;
  padding:9px 10px;color:var(--muted);text-decoration:none;
  font-size:13px;font-weight:500;border-radius:8px;
  transition:all .15s;margin-bottom:2px;
}
.sidebar nav a:hover{background:rgba(255,255,255,.05);color:#fff}
.sidebar nav a.active{background:rgba(249,115,22,.12);color:#fff}
.nav-ic{
  width:28px;height:28px;border-radius:6px;
  background:rgba(255,255,255,.04);
  display:flex;align-items:center;justify-content:center;
  font-size:14px;flex-shrink:0;
}
.sidebar nav a.active .nav-ic{background:rgba(249,115,22,.15)}
.sb-footer{padding:10px;border-top:1px solid var(--border);flex-shrink:0}
.btn-sair{
  width:100%;background:rgba(239,68,68,.08);
  border:1px solid rgba(239,68,68,.2);color:#f87171;
  padding:9px;border-radius:8px;font-size:13px;font-weight:600;
  font-family:inherit;cursor:pointer;
  display:flex;align-items:center;justify-content:center;gap:8px;
  transition:.15s;
}
.btn-sair:hover{background:rgba(239,68,68,.18);color:#fff}

/* ===== TOPBAR ===== */
.main{margin-left:var(--sidebar);width:calc(100% - var(--sidebar));display:flex;flex-direction:column;min-height:100vh}
.topbar{
  background:var(--topbar-bg);backdrop-filter:blur(10px);
  padding:12px 24px;display:flex;align-items:center;justify-content:space-between;
  border-bottom:1px solid var(--border);position:sticky;top:0;z-index:50;
  transition:background .25s;
}
.topbar h1{font-size:16px;font-weight:700;color:var(--text)}
.topbar .bc{font-size:11px;color:var(--muted);margin-top:2px}
.topbar-actions{display:flex;align-items:center;gap:10px}

/* Botão tema */
.btn-theme{
  width:36px;height:36px;border-radius:8px;border:1px solid var(--border);
  background:var(--bg3);color:var(--muted);cursor:pointer;
  display:flex;align-items:center;justify-content:center;font-size:16px;
  transition:all .15s;flex-shrink:0;
}
.btn-theme:hover{border-color:var(--accent);color:var(--accent)}

/* Botão hamburger (mobile) */
.btn-hamburger{
  display:none;width:36px;height:36px;border-radius:8px;
  border:1px solid var(--border);background:var(--bg3);
  color:var(--text);cursor:pointer;
  align-items:center;justify-content:center;font-size:18px;
  transition:all .15s;flex-shrink:0;
}
.btn-hamburger:hover{border-color:var(--accent);color:var(--accent)}

/* Botão Sair topbar */
.btn-topbar-sair{
  display:inline-flex;align-items:center;gap:7px;
  padding:8px 16px;border-radius:8px;
  background:rgba(239,68,68,.1);color:#f87171;
  font-size:13px;font-weight:700;font-family:inherit;
  cursor:pointer;border:1px solid rgba(239,68,68,.22);transition:all .15s;
}
.btn-topbar-sair:hover{background:rgba(239,68,68,.22);color:#fff}

/* Overlay mobile */
.sidebar-overlay{
  display:none;position:fixed;inset:0;background:rgba(0,0,0,.6);
  z-index:99;backdrop-filter:blur(2px);
}
.sidebar-overlay.open{display:block}

.content{padding:22px 24px;flex:1;min-width:0;overflow:visible}

/* ===== ALERTS ===== */
.alert{
  padding:12px 16px;border-radius:10px;margin-bottom:18px;
  display:flex;align-items:center;gap:10px;
  font-size:13px;font-weight:500;animation:fadeIn .3s ease;
}
@keyframes fadeIn{from{opacity:0;transform:translateY(-4px)}to{opacity:1;transform:none}}
.alert-success{background:rgba(34,197,94,.1);color:#4ade80;border:1px solid rgba(34,197,94,.2)}
.alert-error{background:rgba(239,68,68,.1);color:#f87171;border:1px solid rgba(239,68,68,.2)}
.alert-warning{background:rgba(234,179,8,.1);color:#facc15;border:1px solid rgba(234,179,8,.2)}
.alert .cls{margin-left:auto;cursor:pointer;background:none;border:none;color:inherit;font-size:18px;opacity:.6;line-height:1;font-family:inherit}

/* ===== PANELS ===== */
.panel{background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius);padding:20px;margin-bottom:20px;transition:background .25s,border-color .25s}
.panel-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;padding-bottom:12px;border-bottom:1px solid var(--border)}
.panel-title{font-size:14px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:8px}

/* ===== CARDS ===== */
.cards-grid{display:grid;gap:14px;grid-template-columns:repeat(auto-fit,minmax(190px,1fr));margin-bottom:22px}
.stat-card{
  background:var(--bg2);border:1px solid var(--border);
  border-radius:var(--radius);padding:18px;
  position:relative;overflow:hidden;
  transition:transform .15s,border-color .15s,background .25s;
  text-decoration:none;display:block;
}
.stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:var(--cc,var(--accent))}
.stat-card:hover{transform:translateY(-2px);border-color:rgba(255,255,255,.14)}
.sc-head{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px}
.sc-icon{width:38px;height:38px;border-radius:8px;background:rgba(255,255,255,.05);display:flex;align-items:center;justify-content:center;font-size:16px}
.sc-val{font-size:24px;font-weight:800;color:var(--text);letter-spacing:-1px}
.sc-lbl{font-size:12px;color:var(--muted);margin-top:3px}

/* ===== TABLES ===== */
.table-wrap{background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:20px;transition:background .25s}
.table-header{padding:14px 18px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid var(--border)}
.table-header h2{font-size:14px;font-weight:700;color:var(--text)}
table{width:100%;border-collapse:collapse}
thead th{background:rgba(255,255,255,.03);padding:9px 14px;text-align:left;font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;font-weight:600;border-bottom:1px solid var(--border)}
tbody td{padding:11px 14px;border-bottom:1px solid rgba(255,255,255,.04)}
tbody tr:last-child td{border-bottom:none}
tbody tr:hover{background:var(--card-hover)}
.td-primary{color:var(--text);font-weight:600}
.td-mono{font-family:monospace}

/* ===== BADGES ===== */
.badge{padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;display:inline-block}
.badge-success{background:rgba(34,197,94,.12);color:#4ade80}
.badge-warning{background:rgba(234,179,8,.12);color:#facc15}
.badge-danger{background:rgba(239,68,68,.12);color:#f87171}
.badge-info{background:rgba(59,130,246,.12);color:#60a5fa}
.badge-secondary{background:rgba(100,116,139,.12);color:#94a3b8}
.badge-primary{background:rgba(249,115,22,.12);color:var(--accent)}
.badge-purple{background:rgba(168,85,247,.12);color:#c084fc}

/* ===== BUTTONS ===== */
.btn{
  display:inline-flex;align-items:center;gap:6px;
  padding:8px 16px;border-radius:8px;
  font-size:13px;font-weight:600;font-family:inherit;
  cursor:pointer;text-decoration:none;border:none;
  transition:all .15s;white-space:nowrap;
}
.btn-primary{background:var(--accent);color:#fff}
.btn-primary:hover{background:#ea6b10}
.btn-primary:disabled{opacity:.5;cursor:not-allowed;transform:none!important}
.btn-secondary{background:var(--bg3);color:var(--text);border:1px solid var(--border)}
.btn-secondary:hover{background:rgba(255,255,255,.07);color:var(--text)}
.btn-success{background:rgba(34,197,94,.12);color:#4ade80;border:1px solid rgba(34,197,94,.2)}
.btn-success:hover{background:rgba(34,197,94,.22)}
.btn-danger{background:rgba(239,68,68,.12);color:#f87171;border:1px solid rgba(239,68,68,.2)}
.btn-danger:hover{background:rgba(239,68,68,.22)}
.btn-warning{background:rgba(234,179,8,.12);color:#facc15;border:1px solid rgba(234,179,8,.2)}
.btn-warning:hover{background:rgba(234,179,8,.22)}
.btn-sm{padding:5px 10px;font-size:12px;border-radius:6px}
.btn-icon{width:32px;height:32px;padding:0;justify-content:center;border-radius:7px}

/* ===== FORMS ===== */
.form-group{margin-bottom:15px}
.form-group label{display:block;margin-bottom:5px;font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.5px}
.form-control,.form-select{
  width:100%;padding:9px 12px;
  background:var(--input-bg);border:1px solid var(--input-border);
  border-radius:9px;font-size:13px;color:var(--text);font-family:inherit;transition:.15s;
}
.form-control::placeholder{color:var(--muted)}
.form-control:focus,.form-select:focus{outline:none;border-color:var(--accent);box-shadow:0 0 0 3px rgba(249,115,22,.1)}
.form-select option{background:var(--bg2);color:var(--text)}
.form-row{display:grid;gap:12px;grid-template-columns:repeat(auto-fit,minmax(150px,1fr))}
.invalid-feedback{color:#f87171;font-size:12px;margin-top:4px}
.is-invalid{border-color:#ef4444!important}

/* ===== MESAS ===== */
.mesas-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:12px}
.mesa-card{
  background:var(--bg2);border:1px solid var(--border);
  border-radius:var(--radius);padding:18px 12px;
  text-align:center;cursor:pointer;transition:all .15s;
  position:relative;overflow:hidden;text-decoration:none;display:block;
}
.mesa-card::after{content:'';position:absolute;bottom:0;left:0;right:0;height:3px;background:var(--mc,var(--muted))}
.mesa-card:hover{transform:translateY(-2px);border-color:rgba(255,255,255,.14)}
.mesa-card.disponivel{--mc:var(--green)}
.mesa-card.ocupada{--mc:var(--red)}
.mesa-card.reservada{--mc:var(--yellow)}
.mc-num{font-size:28px;font-weight:800;color:var(--text)}
.mc-seats{font-size:11px;color:var(--muted);margin:4px 0 8px}

/* ===== MISC ===== */
.empty-state{text-align:center;padding:48px 24px;color:var(--muted)}
.empty-state .es-icon{font-size:40px;display:block;margin-bottom:12px;opacity:.3}
.empty-state p{font-size:14px}
hr,.divider{border:none;border-top:1px solid var(--border);margin:16px 0}
.campo-erro{color:#f87171;font-size:12px;margin-top:5px;display:none}
.kpi-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:14px;margin-bottom:20px}
.kpi{background:var(--bg2);border:1px solid var(--border);border-radius:12px;padding:16px;position:relative;overflow:hidden;transition:background .25s}
.kpi::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:var(--kc,var(--accent))}
.kpi-val{font-size:24px;font-weight:900;color:var(--text);margin:6px 0 4px}
.kpi-lbl{font-size:12px;color:var(--muted)}
.sc-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px}
.sc-icon{width:38px;height:38px;border-radius:8px;background:rgba(255,255,255,.05);display:flex;align-items:center;justify-content:center;font-size:16px}
.sc-badge{font-size:10px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;background:rgba(255,255,255,.05);padding:3px 8px;border-radius:6px}
.sc-value{font-size:28px;font-weight:900;color:var(--text);line-height:1.1;margin-bottom:4px}
.sc-label{font-size:12px;color:var(--muted)}

/* ===== MOBILE RESPONSIVE ===== */
@media(max-width:768px){
  :root{--sidebar:260px}
  .sidebar{transform:translateX(-100%)}
  .sidebar.open{transform:translateX(0)}
  .main{margin-left:0;width:100%}
  .btn-hamburger{display:flex}
  .content{padding:16px}
  .topbar{padding:10px 16px}
  .cards-grid{grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:10px}
  .stat-card{padding:14px}
  .sc-value{font-size:22px}
  .panel{padding:16px}
  /* Tabelas responsive */
  .table-wrap{overflow-x:auto}
  table{min-width:600px}
  /* Grid forms mobile */
  .form-row{grid-template-columns:1fr}
  /* 2 colunas em grids de produtos/gerenciar */
  [style*="grid-template-columns:360px"]{display:block!important}
  [style*="grid-template-columns:340px"]{display:block!important}
  [style*="grid-template-columns:1fr 1fr"]{grid-template-columns:1fr!important}
  /* Topbar actions */
  .btn-topbar-sair span{display:none}
  .btn-topbar-sair{padding:8px 10px}
}
@media(max-width:480px){
  .cards-grid{grid-template-columns:1fr 1fr}
  .mesas-grid{grid-template-columns:repeat(auto-fill,minmax(120px,1fr))}
  .table-header{flex-direction:column;align-items:flex-start;gap:10px}
  .topbar h1{font-size:14px}
}
</style>
@yield('styles')
</head>
<body>

{{-- Overlay para fechar sidebar no mobile --}}
<div class="sidebar-overlay" id="sidebar-overlay" onclick="toggleSidebar()"></div>

<aside class="sidebar" id="sidebar">
  <div class="sb-brand">
    <div class="sb-logo">🍳</div>
    <div>
      <div class="sb-brand-name">RestaurantePRO</div>
      <div class="sb-brand-sub">Sistema de Gestão</div>
    </div>
  </div>

  <div class="sb-user">
    <div class="sb-avatar">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</div>
    <div>
      <div class="sb-uname">{{ Auth::user()->name }}</div>
      <div class="sb-urole">
        @php $rl=['gerente'=>'Gerente','garcom'=>'Garçom','chef'=>'Chef','caixa'=>'Caixa'] @endphp
        {{ $rl[Auth::user()->role] ?? Auth::user()->role }}
      </div>
    </div>
  </div>

  <nav id="sidebar-nav">
    <div class="sb-section">Principal</div>
    <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
      <div class="nav-ic">🏠</div> Início
    </a>
    <a href="{{ route('dashboard.pedidos') }}" class="{{ request()->routeIs('dashboard.pedidos','orders.show') ? 'active' : '' }}">
      <div class="nav-ic">🧾</div> Pedidos
    </a>

    @if(in_array(Auth::user()->role,['gerente','garcom']))
    <div class="sb-section">Salão</div>
    <a href="{{ route('mesas.index') }}" class="{{ request()->routeIs('mesas.*') ? 'active' : '' }}">
      <div class="nav-ic">🪑</div> Mesas
    </a>
    @endif

    @if(Auth::user()->role === 'garcom')
    <a href="{{ route('orders.create') }}" class="{{ request()->routeIs('orders.create') ? 'active' : '' }}">
      <div class="nav-ic">➕</div> Novo Pedido
    </a>
    @endif

    @if(Auth::user()->role === 'chef')
    <div class="sb-section">Cozinha</div>
    <a href="{{ route('chef.preparo') }}" class="{{ request()->routeIs('chef.preparo') ? 'active' : '' }}">
      <div class="nav-ic">🔥</div> Preparo
    </a>
    <a href="{{ route('chef.estoque') }}" class="{{ request()->routeIs('chef.estoque') ? 'active' : '' }}">
      <div class="nav-ic">📦</div> Estoque
    </a>
    @endif

    @if(in_array(Auth::user()->role,['caixa','gerente']))
    <div class="sb-section">Financeiro</div>
    <a href="{{ route('caixa.pagar-mesa') }}" class="{{ request()->routeIs('caixa.*') ? 'active' : '' }}">
      <div class="nav-ic">💰</div> Caixa
    </a>
    <a href="{{ route('dashboard.estoque') }}" class="{{ request()->routeIs('dashboard.estoque') ? 'active' : '' }}">
      <div class="nav-ic">📦</div> Estoque
    </a>
    @endif

    @if(Auth::user()->role === 'gerente')
    <div class="sb-section">Cadastros</div>
    <a href="{{ route('gerenciar.mesas') }}"        class="{{ request()->routeIs('gerenciar.mesas') ? 'active' : '' }}">
      <div class="nav-ic">🪑</div> Mesas
    </a>
    <a href="{{ route('gerenciar.cardapio') }}"     class="{{ request()->routeIs('gerenciar.cardapio*') ? 'active' : '' }}">
      <div class="nav-ic">🍽️</div> Cardápio
    </a>
    <a href="{{ route('gerenciar.funcionarios') }}" class="{{ request()->routeIs('gerenciar.funcionarios') ? 'active' : '' }}">
      <div class="nav-ic">👥</div> Funcionários
    </a>
    <a href="{{ route('gerenciar.produtos') }}"     class="{{ request()->routeIs('gerenciar.produtos*') ? 'active' : '' }}">
      <div class="nav-ic">📦</div> Produtos
    </a>

    <div class="sb-section">Relatórios</div>
    <a href="{{ route('gestao.relatorios') }}"      class="{{ request()->routeIs('gestao.relatorios') ? 'active' : '' }}">
      <div class="nav-ic">📊</div> Gestão
    </a>
    <a href="{{ route('dashboard.relatorios') }}"   class="{{ request()->routeIs('dashboard.relatorios') ? 'active' : '' }}">
      <div class="nav-ic">📄</div> Período
    </a>
    <a href="{{ route('dashboard.vendas') }}"       class="{{ request()->routeIs('dashboard.vendas') ? 'active' : '' }}">
      <div class="nav-ic">📈</div> Vendas
    </a>

    <div class="sb-section">Estoque</div>
    <a href="{{ route('controle.estoque') }}"       class="{{ request()->routeIs('controle.estoque*') ? 'active' : '' }}">
      <div class="nav-ic">🔄</div> Controle
    </a>
    <a href="{{ route('dashboard.estoque') }}"      class="{{ request()->routeIs('dashboard.estoque') ? 'active' : '' }}">
      <div class="nav-ic">📦</div> Inventário
    </a>
    <a href="{{ route('compras.index') }}"          class="{{ request()->routeIs('compras.*') ? 'active' : '' }}">
      <div class="nav-ic">🛒</div> Compras
    </a>
    @endif
  </nav>

  <div class="sb-footer">
    <form method="POST" action="{{ route('logout') }}">@csrf
      <button type="submit" class="btn-sair">🚪 Sair do Sistema</button>
    </form>
  </div>
</aside>

<div class="main">
  <div class="topbar">
    <div style="display:flex;align-items:center;gap:12px">
      <button class="btn-hamburger" id="btn-hamburger" onclick="toggleSidebar()">☰</button>
      <div>
        <h1>@yield('page-title','Dashboard')</h1>
        <div class="bc">@yield('breadcrumb','Sistema de Gestão')</div>
      </div>
    </div>
    <div class="topbar-actions">
      <button class="btn-theme" id="btn-theme" onclick="toggleTheme()" title="Alternar tema">🌙</button>
      <form method="POST" action="{{ route('logout') }}" style="margin:0">@csrf
        <button type="submit" class="btn-topbar-sair">🚪 <span>Sair</span></button>
      </form>
    </div>
  </div>

  <div class="content">
    @if(session('success'))
    <div class="alert alert-success">
      ✅ <span>{{ session('success') }}</span>
      <button class="cls" onclick="this.parentElement.remove()">×</button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error">
      ❌ <span>{{ session('error') }}</span>
      <button class="cls" onclick="this.parentElement.remove()">×</button>
    </div>
    @endif
    @if($errors->any())
    <div class="alert alert-error">
      ❌ <span>{{ $errors->first() }}</span>
      <button class="cls" onclick="this.parentElement.remove()">×</button>
    </div>
    @endif

    @yield('content')
  </div>
</div>

<script>
// ===== TEMA CLARO/ESCURO =====
(function(){
  const saved = localStorage.getItem('rp-theme') || 'dark';
  applyTheme(saved);
})();

function applyTheme(theme){
  document.documentElement.setAttribute('data-theme', theme);
  const btn = document.getElementById('btn-theme');
  if(btn) btn.textContent = theme === 'dark' ? '🌙' : '☀️';
}
function toggleTheme(){
  const cur = document.documentElement.getAttribute('data-theme') || 'dark';
  const next = cur === 'dark' ? 'light' : 'dark';
  localStorage.setItem('rp-theme', next);
  applyTheme(next);
}

// ===== SIDEBAR MOBILE =====
function toggleSidebar(){
  const sb = document.getElementById('sidebar');
  const ov = document.getElementById('sidebar-overlay');
  sb.classList.toggle('open');
  ov.classList.toggle('open');
  document.body.style.overflow = sb.classList.contains('open') ? 'hidden' : '';
}

// Fechar sidebar ao clicar em link (mobile)
document.querySelectorAll('#sidebar-nav a').forEach(function(a){
  a.addEventListener('click', function(){
    if(window.innerWidth <= 768){
      const sb = document.getElementById('sidebar');
      const ov = document.getElementById('sidebar-overlay');
      sb.classList.remove('open');
      ov.classList.remove('open');
      document.body.style.overflow = '';
    }
  });
});

// ===== MANTER POSIÇÃO DA SIDEBAR =====
// Salva e restaura a posição de scroll da sidebar
(function(){
  const nav = document.getElementById('sidebar');
  if(!nav) return;
  const saved = sessionStorage.getItem('sb-scroll');
  if(saved) nav.scrollTop = parseInt(saved);
  nav.addEventListener('scroll', function(){
    sessionStorage.setItem('sb-scroll', nav.scrollTop);
  });
})();

// ===== AUTO-DISMISS ALERTS =====
setTimeout(function(){
  document.querySelectorAll('.alert').forEach(function(el){
    el.style.transition='opacity .5s';el.style.opacity='0';
    setTimeout(function(){el.remove()},500);
  });
},6000);
</script>
@yield('scripts')
</body>
</html>
