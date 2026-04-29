    <div class="form-container">
        <div class="lds-spinner">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
        @if(isset($insert))
        {!! Form::open(['route' => $tip.".store","enctype"=>"multipart/form-data","id"=>"formaGeneric"]) !!}
        @else
        {!! Form::model($podaci, ['route' => [$tip.".update", $podaci->id], 'method' => 'PATCH',"enctype"=>"multipart/form-data","id"=>"formaGeneric"]) !!}
        @endif
        @foreach($fields as $is => $f)
        <div class="form-group mb-3">
            {!! Form::label($f['name'], $f['label']) !!}

            @if ($f['type'] === 'text')
            {!! Form::text($f['name'], null, ['id' => $f['name'], 'class' => 'form-control']) !!}

            @elseif ($f['type'] === 'number')
            {!! Form::number($f['name'], null, ['id' => $f['name'], 'class' => 'form-control']) !!}

            @elseif ($f['type'] === 'checkbox')
            @php
            $isChecked = isset($podaci->{$f['name']})
            ? filter_var($podaci->{$f['name']}, FILTER_VALIDATE_BOOLEAN)
            : false;
            @endphp

            {!! Form::checkbox($f['name'], '1', $isChecked, ['id' => $f['name']]) !!}

            @elseif ($f['type'] === 'textarea')
            <div id="editor">
                @if(isset($podaci->opis))
                {!! $podaci->opis !!}
                @endif
            </div>

            @elseif ($f['type'] === 'dropdown')
            @php
            $dropdownValues = collect();
            $checkedValue = null;

            if (
            isset($podaci->sviPodaciZaListu) &&
            is_array($podaci->sviPodaciZaListu) &&
            array_key_exists($is, $podaci->sviPodaciZaListu)
            ) {
            $dropdownValues = $podaci->sviPodaciZaListu[$is];
            $source = $podaci->cekiraniTip[$is] ?? null;

            if ($source instanceof \Illuminate\Support\Collection) {
            $checkedValue = $source->pluck('id')->toArray();
            } elseif (is_array($source)) {
            $checkedValue = collect($source)->pluck('id')->filter()->toArray();
            } elseif (is_object($source) && isset($source->id)) {
            $checkedValue = $source->id;
            } else {
            $checkedValue = $source;
            }
            } elseif ($f['name'] === 'id_tip_nekretnine' && isset($podaci->tipovi)) {
            $dropdownValues = $podaci->tipovi;
            }
            @endphp

            <x-forms.dropdown
                :field="$f"
                :values="$dropdownValues"
                :checkedValues="$checkedValue"
                :type="$f['tipDropdown']" />

            @elseif ($f['type'] === 'radio')
            @php
            $checkedValue = isset($podaci->{$f['name']}) ? $podaci->{$f['name']} : null;
            @endphp

            @if($f['name'] === 'mesto_id' && isset($podaci->mesta))
            <div class="d-flex flex-column gap-2">
                @foreach($podaci->mesta as $mesto)
                <label class="d-flex align-items-center gap-2">
                    {!! Form::radio($f['name'], $mesto->id, (string) $checkedValue === (string) $mesto->id) !!}
                    <span>{{ $mesto->naziv }}</span>
                </label>
                @endforeach
            </div>
            @endif

            @elseif ($f['type'] === 'file')
            @if(isset($f['options']))
            {!! Form::file($f['name'], [
            'id' => isset($f['id']) ? $f['id'] : $f['name'],
            $f['options'] => true,
            'class' => 'form-control'
            ]) !!}

            @if(isset($podaci->slike))
            <div class="swiper">
                <div class="swiper-wrapper">
                    @foreach($podaci->slike as $s)
                    <div class="swiper-slide">
                        <img class="slika_preview" src="{{ asset('assets/img/' . $s->putanja) }}" />
                    </div>
                    @endforeach
                </div>

                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>

            <div id="graficki-prikaz-slika"></div>
            @else
            <div id="graficki-prikaz-slika"></div>
            @endif
            @else
            {!! Form::file($f['name'], [
            'id' => isset($f['id']) ? $f['id'] : $f['name'],
            'class' => 'form-control'
            ]) !!}

            @if(isset($podaci->slika))
            <div class="block-za-sliku">
                <img id="slika_preview" src="{{ asset('assets/img/' . $podaci->slika) }}" />
            </div>
            @else
            <div class="block-za-sliku">
                <img id="slika_preview" src="" />
            </div>
            @endif
            @endif
            @endif

            @if($errors->has($f['name']))
            <span class="error">* {{ $errors->first($f['name']) }}</span>
            @endif

            @error($f['name'])
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        @endforeach

        @if(isset($dogadjaj))

        {!! Form::hidden('id', $podaci->id) !!}
        {!! Form::submit('Submit',['onclick'=> $dogadjaj]) !!}

        @else
        {!! Form::submit(isset($insert) ? "Dodaj" : "Izmeni",["class"=>"forma-admin-klik"]) !!}
        @endif
        {!! Form::close() !!}
    </div>