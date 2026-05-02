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
            $dd = isset($podaci) ? ($podaci->dropdowns[$f['name']] ?? null) : null;
            //Znaci ne ovako, morao bih konstantno da sirim ovaj deo ukoliko mi dodje nesto novo! (Ovo dole je za arhivu!)
            // dd($podaci->sviPodaciZaListu,$podaci->cekiraniTip->id,is_object($podaci->sviPodaciZaListu),$f);
            // if (
            // isset($podaci->sviPodaciZaListu) &&
            // is_object($podaci->sviPodaciZaListu) &&
            // array_key_exists($is, $podaci->sviPodaciZaListu)
            // ) {
            // $dropdownValues = $podaci->sviPodaciZaListu[$is];
            // $source = $podaci->cekiraniTip[$is] ?? null;

            // if ($source instanceof \Illuminate\Support\Collection) {
            // $checkedValue = $source->pluck('id')->toArray();
            // } elseif (is_array($source)) {
            // $checkedValue = collect($source)->pluck('id')->filter()->toArray();
            // } elseif (is_object($source) && isset($source->id)) {
            // $checkedValue = $source->id;
            // } else {
            // $checkedValue = $source;
            // }
            // } elseif ($f['name'] === 'id_tip_nekretnine' && isset($podaci->tipovi)) {
            // $dropdownValues = $podaci->tipovi;
            // }
            @endphp


        <x-forms.dropdown
            :field="$f"
            :values="$dd ? $dd->getValues() : collect()"
            :checkedValues="$dd ? $dd->getCheckedValues() : null"
            :type="$f['tipDropdown']" />

            @elseif ($f['type'] === 'radio')
            @php
            $checkedValue = isset($podaci->{$f['name']}) ? $podaci->{$f['name']} : null;
            @endphp

            @if($f['name'] === 'mesto_id' && isset($podaci->mesta))
            <div class="d-flex flex-column gap-2" data-field="{{ $f['name'] }}">
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



            @elseif ($f['type'] === 'video_upload')
            <div class="video-upload-wrapper" data-field="{{ $f['name'] }}">
                <label class="video-drop-zone" id="videoDropZone" for="{{ $f['name'] }}">
                    <div class="video-drop-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M15 10l4.553-2.276A1 1 0 0121 8.723v6.554a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z" />
                        </svg>
                    </div>
                    <div class="video-drop-text">
                        <span class="video-drop-primary">Prevucite video ovde</span>
                        <span class="video-drop-secondary">ili kliknite da izaberete fajl</span>
                        <span class="video-drop-formats">MP4, MOV, OGG &bull; max 50MB</span>
                    </div>
                    {!! Form::file($f['name'], ['id' => $f['name'], 'class' => 'video-file-input', 'accept' => 'video/mp4,video/quicktime,video/ogg']) !!}
                </label>

                <div class="video-preview-box" id="videoPreviewBox" style="display:none;">
                    <video id="videoPreview" controls></video>
                    <div class="video-preview-info">
                        <div class="video-status-badge" id="videoStatusBadge">
                            <span class="video-status-dot"></span>
                            <span id="videoStatusTekst">Spreman za upload</span>
                        </div>
                        <span class="video-preview-name" id="videoFileName"></span>
                        <span class="video-preview-size" id="videoFileSize"></span>
                    </div>
                    <button type="button" class="video-remove-btn" id="videoRemoveBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                        Ukloni video
                    </button>
                </div>
            </div>
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
    <script>
        (function() {
            const dropZone = document.getElementById('videoDropZone');
            const previewBox = document.getElementById('videoPreviewBox');
            const videoEl = document.getElementById('videoPreview');
            const fileName = document.getElementById('videoFileName');
            const fileSize = document.getElementById('videoFileSize');
            const removeBtn = document.getElementById('videoRemoveBtn');

            if (!dropZone || !previewBox) return;

            // Nađi input unutar drop zone, ne po ID-u
            const fileInput = dropZone.querySelector('input[type="file"]');
            if (!fileInput) return;

            function showPreview(file) {
                const url = URL.createObjectURL(file);
                videoEl.src = url;
                fileName.textContent = file.name;
                fileSize.textContent = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
                dropZone.style.display = 'none';
                previewBox.style.display = 'block';

                const badge = document.getElementById('videoStatusBadge');
                const tekst = document.getElementById('videoStatusTekst');
                if (badge && tekst) {
                    badge.className = 'video-status-badge';
                    tekst.textContent = 'Odabran – čeka slanje';
                }
            }

            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) showPreview(this.files[0]);
            });

            dropZone.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('dragover');
            });

            dropZone.addEventListener('dragleave', function() {
                this.classList.remove('dragover');
            });

            dropZone.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
                const file = e.dataTransfer.files[0];
                if (file && file.type.startsWith('video/')) {
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    fileInput.files = dt.files;
                    showPreview(file);
                }
            });

            if (removeBtn) {
                removeBtn.addEventListener('click', function() {
                    videoEl.src = '';
                    fileInput.value = '';
                    previewBox.style.display = 'none';
                    dropZone.style.display = 'flex';

                    const badge = document.getElementById('videoStatusBadge');
                    const tekst = document.getElementById('videoStatusTekst');
                    if (badge && tekst) {
                        badge.className = 'video-status-badge';
                        tekst.textContent = 'Spreman za upload';
                    }
                });
            }
        })();
    </script>