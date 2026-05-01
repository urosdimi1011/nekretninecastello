@props(['field', 'values', 'checkedValues', 'type'])
@php
$stavi = '';
if (is_array($checkedValues)) {
$stavi = '[]';
}
@endphp

<div class="custom-dropdown-field" id="{{ $field['name'] }}Dropdown" data-type="{{ $type }}">
    <button class="custom-dropdown-trigger" type="button" data-dropdown="{{ $field['name'] }}">
        <span class="custom-dropdown-trigger__text" id="{{ $field['name'] }}_label">
            {{ $field['label'] }}
        </span>
        <svg class="custom-dropdown-trigger__arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="6 9 12 15 18 9" />
        </svg>
    </button>

    <div class="custom-dropdown-panel" id="{{ $field['name'] }}_panel">
        <div class="custom-dropdown-opcije">

            @if($type === 'text')
            @foreach($values as $value => $label)
            @php
            $foundValue = '';
            if (is_array($checkedValues)) {
            $foundItem = array_reduce($checkedValues, function ($carry, $item) use ($label) {
            if (isset($item->id) && $item->id == $label->id) return $item;
            return $carry;
            }, null);
            if ($foundItem) {
            $foundValue = $foundItem->vrednost ?? '';
            if ($foundValue === 'ne') $foundValue = '';
            }
            }
            $displayLabel = $label->naziv ?? $label->tip ?? '';
            @endphp

            <div class="atribut-red {{ $foundValue ? 'atribut-red--popunjen' : '' }}">
                <span class="atribut-red__naziv">{{ $displayLabel }}</span>
                <input
                    class="atribut-red__input"
                    type="text"
                    id="atribut_{{ $label->id }}"
                    data-id="{{ $label->id }}"
                    name="{{ $field['name'] }}{{ $stavi }}"
                    value="{{ $foundValue }}"
                    placeholder="Unesite vrednost..." />
            </div>

            @endforeach

            @else
            {{-- RADIO / CHECKBOX tip --}}
            @foreach($values as $value => $label)
            @php
            $inputValue = $label->id;

            $isChecked = false;
            if (is_array($checkedValues)) {
            $plucked = collect($checkedValues)->pluck('id')->toArray();
            $isChecked = in_array(null, $plucked)
            ? in_array($label->id, $checkedValues)
            : in_array($label->id, $plucked);
            } elseif ($label->id == $checkedValues) {
            $isChecked = true;
            }

            $displayLabel = $label->naziv ?? $label->tip ?? '';
            @endphp

            <label class="custom-dropdown-opcija {{ $isChecked ? 'is-checked' : '' }}"
                data-label="{{ $displayLabel }}">
                <input
                    type="{{ $type }}"
                    name="{{ $field['name'] }}{{ $stavi }}"
                    value="{{ $inputValue }}"
                    @if($isChecked) checked @endif
                    class="custom-dropdown-input" />
                <span class="custom-dropdown-opcija__indicator"></span>
                <span class="custom-dropdown-opcija__tekst">{{ $displayLabel }}</span>
            </label>

            @endforeach
            @endif

        </div>

        {{-- Dugme zatvori za text tip --}}
        @if($type === 'text')
        <div class="custom-dropdown-footer">
            <button type="button" class="custom-dropdown-zatvori" data-dropdown="{{ $field['name'] }}">
                Potvrdi
            </button>
        </div>
        @endif
    </div>
</div>