
@extends('layouts.admin')
@section('title', 'Dobrodošli')

@section('content')

    <form class="d-flex mt-5 justify-content-between">
        <form action="{{ url()->current() }}">
            <div class="input-group w-25">
                <input class="form-control inputForForm" name="keywords" id="search" type="search" placeholder="Pretrazi..."  value="{{ request('keywords') }}">
            </div>

            <div class="status-aktivnosti-block">
                <select name="status">
                    <option @if(request('status') == 'aktivni') selected @endif value="aktivni">Aktivni</option>
                    <option @if(request('status') == 'svi') selected @endif value="svi">Svi</option>
                    <option @if(request('status') == 'obrisani') selected @endif value="obrisani">Obrisani</option>
                </select>
            </div>

            <span class="input-group-text p-0">
                <button type="submit" class="moje-dugme12">Primeni filtere <i class="fa fa-search"></i></button>
            </span>
        </form>
    </form>
{{--    <form >--}}
{{--        <label for="search">Search for stuff</label>--}}
{{--        <input id="search" type="search" placeholder="Search..." name="keywords" />--}}
{{--        <button type="submit">Go</button>--}}
{{--    </form>--}}

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
                                        <td><button data-target="#{{$c['index']}}Modal" data-url="/admin/{{$tip}}/{{$d['id']}}" onclick="openModal(this,`{{ $d }}`)">@if(isset($d['deleted_at']) && $d['deleted_at'] != null && $c['index'] == 'obrisi') {!! $c['undoIcon'] !!} @else {!!$c['icon']  !!} @endif</button></td>
                                        @break
                                    @case('ikona')
                                        <td><div class="icon-wrap"><i class="{{$d[$c['index']]}}"></i></div></td>
                                        @break
                                    @case('toggle')
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" disabled {{$d[$c['index']] == 1 ? "checked" : ""}} role="switch" id="flexSwitchCheckDefault">
                                            </div>
                                        </td>
                                    @break
                                @endswitch
                            @else
                                @if($c['index'] == 'slika')
                                    <td class="img-cell"><img src="{{ asset("assets/img/".$d[$c['index']]['putanja']) }}" alt="{{ $d[$c['index']]['alt'] }}"/></td>
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
            @if(!isset($insertNovog))
                <button onclick="openModal(this)" data-target="#dodajModal" data-url="/admin/{{$tip}}/create" class="moje-dugme mt-5 btn btn-primary">Dodaj</button>
            @endif
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
@endsection


