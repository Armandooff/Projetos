@extends('layouts.app')
@section('page-title', 'Gerenciar Funcionários')
@section('breadcrumb', 'Equipe do restaurante')
@section('styles')
<style>
.ger-tabs{display:flex;gap:8px;margin-bottom:24px;flex-wrap:wrap}
.ger-tab{padding:8px 18px;border-radius:8px;text-decoration:none;font-size:13px;font-weight:700;color:var(--muted);background:var(--bg2);border:1px solid var(--border);transition:.15s}
.ger-tab.active,.ger-tab:hover{background:rgba(249,115,22,.12);color:var(--accent);border-color:rgba(249,115,22,.3)}
.btn-edit{display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:7px;border:1px solid rgba(59,130,246,.3);background:rgba(59,130,246,.1);color:#60a5fa;font-size:12px;font-weight:600;font-family:inherit;cursor:pointer;transition:all .15s;white-space:nowrap;text-decoration:none}
.btn-edit:hover{background:rgba(59,130,246,.2);border-color:rgba(59,130,246,.5)}
.btn-del{display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:7px;border:1px solid rgba(239,68,68,.3);background:rgba(239,68,68,.1);color:#f87171;font-size:12px;font-weight:600;font-family:inherit;cursor:pointer;transition:all .15s;white-space:nowrap}
.btn-del:hover{background:rgba(239,68,68,.2);border-color:rgba(239,68,68,.5)}
.btn-toggle{display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:7px;border:1px solid rgba(234,179,8,.3);background:rgba(234,179,8,.1);color:#facc15;font-size:12px;font-weight:600;font-family:inherit;cursor:pointer;transition:all .15s;white-space:nowrap}
.btn-toggle:hover{background:rgba(234,179,8,.2)}
.btn-toggle.ativo{border-color:rgba(239,68,68,.3);background:rgba(239,68,68,.1);color:#f87171}
.btn-toggle.ativo:hover{background:rgba(239,68,68,.2)}
@media(max-width:768px){[style*="grid-template-columns:360px"]{display:block!important}[style*="grid-template-columns:340px"]{display:block!important}.panel[style*="sticky"]{position:static!important}}
</style>
@endsection
@section('content')
<div class="ger-tabs">
    <a href="{{ route('gerenciar.mesas') }}"        class="ger-tab">🪑 Mesas</a>
    <a href="{{ route('gerenciar.cardapio') }}"     class="ger-tab">🍽️ Cardápio</a>
    <a href="{{ route('gerenciar.funcionarios') }}" class="ger-tab active">👥 Funcionários</a>
    <a href="{{ route('gerenciar.produtos') }}"     class="ger-tab">📦 Produtos</a>
</div>

<div style="display:grid;grid-template-columns:340px 1fr;gap:20px;align-items:start">
    <div class="panel" style="position:sticky;top:80px">
        <div class="panel-header"><div class="panel-title"><i class="fas fa-user-plus"></i> Novo Funcionário</div></div>
        <form method="POST" action="{{ route('usuarios.store') }}">
            @csrf
            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="name" class="form-control {{ $errors->has('name')?'is-invalid':'' }}" value="{{ old('name') }}" placeholder="Nome completo" required oninput="this.value=this.value.replace(/[^a-zA-ZÀ-ÿ\s]/g,'')">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>E-mail</label>
                <input type="email" name="email" id="email-input" class="form-control {{ $errors->has('email')?'is-invalid':'' }}" value="{{ old('email') }}" required
                       pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}"
                       title="E-mail inválido. Ex: nome@empresa.com"
                       oninput="validarEmail(this)">
                <div id="email-hint" style="font-size:11px;margin-top:4px;display:none"></div>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Cargo</label>
                <select name="role" class="form-select" required>
                    <option value="">— Selecione —</option>
                    <option value="garcom"  {{ old('role')=='garcom' ?'selected':'' }}>🍽️ Garçom</option>
                    <option value="chef"    {{ old('role')=='chef'   ?'selected':'' }}>👨‍🍳 Chef</option>
                    <option value="caixa"   {{ old('role')=='caixa'  ?'selected':'' }}>💰 Caixa</option>
                    <option value="gerente" {{ old('role')=='gerente'?'selected':'' }}>👑 Gerente</option>
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
        @php $grupos=['gerente'=>['label'=>'Gerentes','icon'=>'👑','cor'=>'#a855f7'],'garcom'=>['label'=>'Garçons','icon'=>'🍽️','cor'=>'#3b82f6'],'chef'=>['label'=>'Chefs','icon'=>'👨‍🍳','cor'=>'#f97316'],'caixa'=>['label'=>'Caixas','icon'=>'💰','cor'=>'#22c55e']]; @endphp
        @foreach($grupos as $role => $g)
        @php $grupo = $usuarios->where('role',$role); @endphp
        @if($grupo->isNotEmpty())
        <div class="panel" style="margin-bottom:16px">
            <div class="panel-header">
                <div class="panel-title">{{ $g['icon'] }} {{ $g['label'] }} <span style="color:var(--muted);font-weight:400">({{ $grupo->count() }})</span></div>
            </div>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:10px">
                @foreach($grupo as $u)
                <div style="background:var(--bg);border:1px solid var(--border);border-radius:10px;padding:14px;display:flex;align-items:center;gap:12px">
                    <div style="width:36px;height:36px;border-radius:9px;background:{{ $g['cor'] }}20;color:{{ $g['cor'] }};font-weight:800;font-size:15px;display:flex;align-items:center;justify-content:center;flex-shrink:0">{{ strtoupper(substr($u->name,0,1)) }}</div>
                    <div style="flex:1;min-width:0">
                        <div style="font-weight:700;color:#fff;font-size:13px">{{ $u->name }}</div>
                        <div style="font-size:11px;color:var(--muted);overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $u->email }}</div>
                        @if(!$u->ativo)<span class="badge badge-danger" style="font-size:10px">Inativo</span>@endif
                    </div>
                    <div style="display:flex;gap:5px;flex-shrink:0">
                        <a href="{{ route('usuarios.edit',$u) }}" class="btn-edit">✏️ Editar</a>
                        <form method="POST" action="{{ route('usuarios.toggle',$u) }}">@csrf @method('PATCH')
                            <button type="submit" class="btn-toggle {{ $u->ativo?'ativo':'' }}">{{ $u->ativo?'🚫 Desativar':'✅ Ativar' }}</button>
                        </form>
                        @if($u->id !== Auth::id())
                        <form method="POST" action="{{ route('usuarios.destroy',$u) }}" onsubmit="return confirm('Excluir {{ $u->name }}?')">@csrf @method('DELETE')
                            <button type="submit" class="btn-del">🗑️ Excluir</button>
                        </form>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
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
@endsection