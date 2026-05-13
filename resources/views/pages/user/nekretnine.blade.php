@extends('layouts.user')

@php
$s = "Nekretnine";
$s_genitiv = "nekretnina";

$padezi = [
'Stanovi' => 'stanova',
'Kuće' => 'kuća',
'Placevi' => 'placa',
'Lokali' => 'poslovnog prostora',
'Garaže' => 'garaža',
'Poljoprivredno zemljište' => 'poljoprivrednog zemljišta',
'Poljoprivredna zemljišta' => 'poljoprivrednog zemljišta',
'Poljoprivredno zamljiste' => 'poljoprivrednog zemljišta'
];

foreach($tipoviNekretnina as $n){
$requestTip = strtolower(request("tip"));

$matchTip = str_replace('_', ' ', $requestTip);

if (strpos($matchTip, 'ku') === 0) {
$matchTip = str_replace("c", "ć", $matchTip);
}

$dbTip = strtolower($n->tip);


if($matchTip == $dbTip){
$s = ($n->tip == "Lokali") ? "Poslovni prostor" : $n->tip;
$s_genitiv = $padezi[$n->tip] ?? strtolower($s);
}
}
@endphp

@section('title', $s . ' Vršac | Prodaja ' . $s_genitiv . ' u Vršcu | Castello Nekretnine')
@section('description', 'Pogledajte najbolju ponudu za ' . strtolower($s) . ' u Vršcu. Castello Nekretnine nudi proverene ' . $s_genitiv . ' na prodaju. Pozovite: 065 823 4501')
@section('keywords',
strtolower($s) . ' vrsac, ' .
strtolower($s) . ' na prodaju vrsac, ' .
'prodaja ' . strtolower($s_genitiv) . ' vrsac, ' .
'castello nekretnine vrsac, ' .
'nekretnine vrsac, ' .
'agencija za nekretnine vrsac'
)
@section('content')
<div class="slika-pozadina">
    <div class="banner-kontakt bg-fixed">
        <div class="inner-banner-kontakt">
            <h1>
                {{ __('nekretnine.banner') }}
                <span class="tip-naslov @if(request('tip')===null) tip-naslov--prazan @endif">
                    @if(request("tip") !== null)
                        @foreach($tipoviNekretnina as $n)
                        @php $tipSaDonjomCrtom = strtolower(str_replace('_', ' ', request("tip"))); @endphp
                        @if(strtolower(strpos($tipSaDonjomCrtom, 'ku') === 0 ? str_replace("c","ć",$tipSaDonjomCrtom) : $tipSaDonjomCrtom) == strtolower($n->tip))
                            {{ $n->tip }}
                        @endif
                        @endforeach
                    @endif
                </span>
            </h1>
        </div>
    </div>

    <div class="container pt-5">
        <div class="filter-bar">
            <span class="filter-bar__count">
                <span class="rez">{{ $nekretnine->total() }}</span> {{ __('nekretnine.rezultata') }}
            </span>
            <div class="filter-bar__selects">
                <div class="filter-group">
                    <label>{{ __('nekretnine.tip_label') }}</label>
                    <select class="custom-select sources tipNekretnine-select"
                        placeholder="{{ __('nekretnine.tip_placeholder') }}">
                        <option value="">{{ __('nekretnine.sve_nekretnine') }}</option>
                        @foreach($tipoviNekretnina as $n)
                            @if($n->tip == "Beograd") @break @endif
                            <option
                                @if(request("tip")==$n->id || ucfirst(str_replace("c","ć",request("tip"))) == $n->tip) selected @endif
                                value="{{ $n->id }}">{{ $n->prevod()->tip }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-divider"></div>
                <div class="filter-group">
                    <label>{{ __('nekretnine.sort_label') }}</label>
                    <select class="custom-select sources"
                        placeholder="{{ __('nekretnine.sort_placeholder') }}">
                        <option value="cena-asc">{{ __('nekretnine.sort_cena_asc') }}</option>
                        <option value="cena-desc">{{ __('nekretnine.sort_cena_desc') }}</option>
                        <option value="created_at-asc">{{ __('nekretnine.sort_datum_asc') }}</option>
                        <option value="created_at-desc" selected>{{ __('nekretnine.sort_datum_desc') }}</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="row row-gap nekretnine-sve-js">
                    @forelse($nekretnine as $n)
                    <div class="col-12 col-md-6 col-lg-4">
                        <x-nekretnina :nekretnina="$n" />
                    </div>
                    @empty
                    <div class="col-12 text-center ako-nema-nekretnina-poruka">
                        <p>{{ __('nekretnine.prazno') }}</p>
                    </div>
                    @endforelse
                </div>
                <div class="mt-5 pag justify-content-center">
                    {{ $nekretnine->withQueryString()->links('partials.custom-pagination') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        { "@type": "ListItem", "position": 1, "name": "{{ __('nekretnine.breadcrumb_pocetna') }}", "item": "{{ url('/') }}" },
        { "@type": "ListItem", "position": 2, "name": "{{ $s }} Vršac", "item": "{{ url()->current() }}" }
    ]
}
</script>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "SearchResultsPage",
    "name": "{{ $s }} Vršac – Castello Nekretnine",
    "url": "{{ url()->current() }}",
    "description": "{{ strtolower($s_genitiv) }}",
    "provider": { "@id": "{{ url('/') }}#agency" }
}
</script>
@endpush