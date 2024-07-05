    <div class="form-container">
        <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
        @if(isset($insert))
            {!! Form::open(['route' => $tip.".store","enctype"=>"multipart/form-data","id"=>"formaGeneric"]) !!}
        @else
            {!! Form::model($podaci, ['route' => [$tip.".update", $podaci->id], 'method' => 'PATCH',"enctype"=>"multipart/form-data","id"=>"formaGeneric"]) !!}
        @endif
        @foreach($fields as $is=>$f)
        <div class="form-group mb-3">
            {!! Form::label($f['name'], $f['label']) !!}
        @if ($f['type'] === 'text')
                {!! Form::text($f['name'], null, ['id' => $f['name'],"class"=>"form-control"]) !!}
            @elseif ($f['type'] === 'number')
                {!! Form::number($f['name'], null, ['id' => $f['name'],"class"=>"form-control" ]) !!}
            @elseif ($f['type'] === 'checkbox')
                @php
                        if(isset($podaci->{$f['name']})){
                              $isChecked = filter_var($podaci->{$f['name']}, FILTER_VALIDATE_BOOLEAN);
                        }
                        else{
                            $isChecked = false;
                        }
                @endphp
                {!! Form::checkbox($f['name'], "1",$isChecked, ['id' => $f['name'] ]) !!}
            @elseif ($f['type'] === 'textarea')
                <div id="editor">
                    @if(isset($podaci->opis))
                {!! $podaci->opis !!}
                    @endif
                </div>
{{--                {!! Form::textarea($f['name'], null, ['id' => $f['name'],"class"=>"form-control"]) !!}--}}
            @elseif($f['type']==="dropdown")
                @if (isset($podaci->sviPodaciZaListu) && is_array($podaci->sviPodaciZaListu))
                        @php
                            $checkedValue = $podaci->cekiraniTip[$is]['id'] ?? null;
                            if($checkedValue == null && is_array($podaci->cekiraniTip[$is])) {
                                if(count($podaci->cekiraniTip[$is]) > 0){
                                    if($podaci->cekiraniTip[$is] instanceof  \Illuminate\Support\Collection){

                                        $checkedValue = $podaci->cekiraniTip[$is]->pluck('id')->toArray();
                                    }
                                    else{
                                        if($f['tipDropdown'] == 'text'){
                                            //ovde kada je text treba da bude id i vrednost kao propertiji objekta
                                            $checkedValue = $podaci->cekiraniTip[$is];

                                        }
                                        else{
                                            $checkedValue = collect($podaci->cekiraniTip[$is])->pluck('id')->toArray();
                                        }

                                    }
                                }
                                else{
                                    $checkedValue = null;
                                }

                            }
                        @endphp
                        <x-forms.dropdown :field="$f" :values="$podaci->sviPodaciZaListu[$is]" :checkedValues="$checkedValue" :type="$f['tipDropdown']"/>
                @elseif(isset($podaci->sviPodaciZaListu))
                    @php
                        $checkedValue = $podaci->cekiraniTip['id'] ?? null;
                        if($checkedValue == null) {
                            $checkedValue = $podaci->cekiraniTip->pluck('id')->toArray();
                        }
                    @endphp
                    <x-forms.dropdown :field="$f" :values="$podaci->sviPodaciZaListu" :checkedValues="$checkedValue" :type="$f['tipDropdown']"/>

                @else
                    <x-forms.dropdown :field="$f" :values="$podaci" :checkedValues="null" :type="$f['tipDropdown']"/>
                @endif


        @elseif ($f['type'] === 'file')
            @if(isset($f['options']))
                {!! Form::file($f['name'], ['id' => isset($f['id']) ? $f['id'] : $f['name'],$f['options']=>true,"class"=>"form-control"]) !!}


                @if(isset($podaci->slike))
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                @foreach($podaci->slike as $s)
                                    <div class="swiper-slide"> <img class="slika_preview"  src="{{asset("assets/img/".$s->putanja)}}"/></div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>

                        </div>
                        <div id="graficki-prikaz-slika">
                        </div>
                    @else
                        <div id="graficki-prikaz-slika">
                        </div>
                    @endif
            @else
                {!! Form::file($f['name'], ['id' => isset($f['id']) ? $f['id'] : $f['name'],"class"=>"form-control"]) !!}
                    @if(isset($podaci->slika))
                        <div class="block-za-sliku">
                            <img id="slika_preview"  src="{{asset("assets/img/".$podaci->slika)}}"/>
                        </div>
                    @else
                        <div class="block-za-sliku">
                            <img id="slika_preview"  src=""/>
                        </div>
                    @endif
            @endif
        @endif

            @if($errors->has($f['name']))
                <span class="error">* {{$errors->first($f['name'])}}</span>
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

