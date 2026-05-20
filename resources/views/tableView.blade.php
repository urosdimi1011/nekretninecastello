@extends('layouts.admin')
@section('title', 'Dobrodošli')
@section('page_title', ucfirst($tip))

@section('topbar_actions')
@if(!isset($insertNovog))
<button onclick="openModal(this)"
    data-target="#dodajModal"
    data-url="/admin/{{ $tip }}/create"
    class="btn-admin-primary">
    + Dodaj
</button>
@endif
@endsection
@section('content')

<form class="d-flex mt-5 mb-3 gap-3">
    <form action="{{ url()->current() }}" class="admin-filter-form">
        <div class="input-group w-25">
            <input class="form-control inputForForm" name="keywords" id="search" type="search" placeholder="Pretrazi..." value="{{ request('keywords') }}">
        </div>

        <div class="status-aktivnosti-block">
            <select name="status" class="admin-filter-select">
                <option @if(request('status')=='aktivni' ) selected @endif value="aktivni">Aktivni</option>
                <option @if(request('status')=='svi' ) selected @endif value="svi">Svi</option>
                <option @if(request('status')=='obrisani' ) selected @endif value="obrisani">Obrisani</option>
            </select>
        </div>
        <button type="submit" class="btn-admin-primary">
            <i class="ph ph-magnifying-glass"></i> Primeni filtere
        </button>
    </form>
</form>

<div class="table100 ver1 m-b-110">
    <div class="table100-head">
        <table>
            <thead>
                <tr>
                    @foreach($column as $c)
                    <th class="cell100 {{isset($c['klasa']) ? $c['klasa'] : ''}}" onclick="sortTable({{ $loop->index }})">{{ $c['label'] }} <span id="arrow{{ $loop->{'index'} }}"></span></th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $d)
                <tr>
                    @foreach($column as $c)
                    @if(isset($c['type']))
                    @switch($c['type'])
                    @case('button')
                    <td><button data-target="#{{$c['index']}}Modal" data-url="/admin/{{$tip}}/{{$d['id']}}" onclick="openModal(this,`{{ $d }}`)">@if(isset($d['deleted_at']) && $d['deleted_at'] != null && $c['index'] == 'obrisi') {!! $c['undoIcon'] !!} @else {!!$c['icon'] !!} @endif</button></td>
                    @break
                    @case('ikona')
                    <td>
                        <div class="icon-wrap"><i class="{{$d[$c['index']]}}"></i></div>
                    </td>
                    @break
                    @case('toggle')
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" disabled {{$d[$c['index']] == 1 ? "checked" : ""}} role="switch" id="flexSwitchCheckDefault">
                        </div>
                    </td>
                    @break
                    @case('filteri_modal')
                    <td>
                        <button onclick="openFiltriModal(this)"
                                data-html="{{ $d[$c['index']] }}"
                                title="Pogledaj filtere">
                            {!! $c['icon'] !!}
                        </button>
                    </td>
                    @break
                    @endswitch
                    @else
                    @if($c['index'] == 'slika')
                    <td class="img-cell"><img src="{{ asset("assets/img/".$d[$c['index']]['putanja']) }}" alt="{{ $d[$c['index']]['alt'] }}" /></td>
                    @else
                    @if (strlen($d[$c['index']]) > 100)
                    <td class="zamrzni">{{ strip_tags(substr($d[$c['index']], 0, 100)) }}... </td>
                    @else
                    @php
                    $arguments = strpos($c['index'],"->");
                    if($arguments){
                    $arguments = explode("->",$c['index']);
                    $refClass = new ReflectionClass(get_class($d));
                    $value = $d;
                    foreach ($arguments as $property) {
                    if (is_object($value)) {
                    $value = $value->{$property};
                    } else {
                    $value = null;
                    break;
                    }
                    }
                    }
                    else{
                    $value = $d[$c['index']];
                    }




                    @endphp
                    <td>{{ strip_tags($value) }} </td>
                    @endif
                    @endif
                    @endif
                    @endforeach
                </tr>
                @empty
                <tr>
                    <td colspan="{{ count($column) }}">Nema podataka</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="other-table">
        <div class="mt-5 pag">
            {{$data->withQueryString()->links()}}
        </div>
    </div>
</div>

<div id="izmeniModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <div id="modalContent"></div>
        <div class="ako-ima-greske">
            <p></p>
        </div>
    </div>
</div>

<div id="filteriModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeFiltriModal()">&times;</span>
        <h3 style="margin-bottom:1rem;">Filter kriterijumi</h3>
        <div id="filteriModalContent"></div>
    </div>
</div>

@push('scripts')
<script>
function openFiltriModal(btn) {
    document.getElementById('filteriModalContent').innerHTML = btn.dataset.html;
    document.getElementById('filteriModal').style.display = 'block';
}
function closeFiltriModal() {
    document.getElementById('filteriModal').style.display = 'none';
}
document.getElementById('filteriModal').addEventListener('click', function(e) {
    if (e.target === this) closeFiltriModal();
});
</script>
@endpush
@endsection