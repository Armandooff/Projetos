@extends('layouts.app')
@section('page-title', 'Vendas')
@section('breadcrumb', 'Relatório de vendas do mês')
@section('content')
<div class="cards-grid" style="grid-template-columns:repeat(2,1fr)">
    <div class="stat-card" style="--card-color:#22c55e">
        <div class="sc-header"><div class="sc-icon"></div><span class="sc-badge">Hoje</span></div>
        <div class="sc-value">R$ {{ number_format($totalHoje,2,',','.') }}</div>
        <div class="sc-label">Total de hoje</div>
    </div>
    <div class="stat-card" style="--card-color:#3b82f6">
        <div class="sc-header"><div class="sc-icon"></div><span class="sc-badge">Mês</span></div>
        <div class="sc-value">R$ {{ number_format($totalMes,2,',','.') }}</div>
        <div class="sc-label">Total do mês</div>
    </div>
</div>
<div class="table-wrap">
    <div class="table-header"><h2>📈 Vendas do Mês ({{ $vendas->count() }})</h2></div>
    @if($vendas->isEmpty())
        <div class="empty-state">📈<p>Nenhuma venda este mês</p></div>
    @else
    <table>
        <thead><tr><th>Data</th><th>Pedido</th><th>Método</th><th>Valor</th><th>Status</th></tr></thead>
        <tbody>
        @foreach($vendas as $v)
        <tr>
            <td style="color:var(--muted); font-size:12px">{{ $v->created_at->format('d/m/Y H:i') }}</td>
            <td class="td-mono td-primary">#{{ str_pad($v->order_id,4,'0',STR_PAD_LEFT) }}</td>
            <td>
                @php
                    $icones = ['dinheiro'=>'💵','cartao_credito'=>'💳','cartao_debito'=>'💳','pix'=>'📱'];
                    $icone  = $icones[$v->metodo] ?? '';
                    $label  = ucfirst(str_replace('_', ' ', $v->metodo));
                @endphp
                {{ $icone }} {{ $label }}
            </td>
            <td class="td-mono" style="color:#4ade80; font-weight:700">R$ {{ number_format($v->valor_final,2,',','.') }}</td>
            <td><span class="badge badge-{{ $v->status==='confirmado'?'success':'warning' }}">{{ ucfirst($v->status) }}</span></td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
