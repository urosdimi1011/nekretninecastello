@props(['field', 'values', 'checkedValues', 'type'])
@php
$stavi = '';
if (is_array($checkedValues)) {
    $stavi = '[]';
}

$triggerLabel = $field['label'];

if ($type === 'radio') {
    $found = collect($values)->firstWhere('id', $checkedValues);
    if ($found) {
        $triggerLabel = $found->naziv ?? $found->tip ?? $field['label'];
    }

} elseif ($type === 'checkbox') {
    if (is_array($checkedValues) && count($checkedValues) > 0) {
        $checkedIds = collect($checkedValues)->pluck('id')->filter()->flip(); // O(1) lookup
        $count = collect($values)->filter(fn($v) => isset($checkedIds[$v->id]))->count();
        if ($count > 0) {
            $triggerLabel = $count . ' ' . ($count === 1 ? 'stavka izabrana' : 'stavke izabrane');
        }
    }

} elseif ($type === 'text') {
    if (is_array($checkedValues)) {
        // Indexed po id-u - O(1) lookup u foreach dole
        $checkedMap = collect($checkedValues)
            ->filter(fn($i) => isset($i->id))
            ->keyBy('id');

        $popunjenih = $checkedMap->filter(
            fn($i) => isset($i->vrednost) && $i->vrednost && $i->vrednost !== 'ne'
        )->count();

        if ($popunjenih > 0) {
            $triggerLabel = $popunjenih . ' ' . ($popunjenih === 1 ? 'atribut popunjen' : 'atributa popunjeno');
        }
    }
}

$hasValue = $triggerLabel !== $field['label'];

if ($type === 'checkbox' && is_array($checkedValues)) {
    $checkedIds = collect($checkedValues)->pluck('id')->filter()->flip();
}
@endphp

<div class="custom-dropdown-field" id="{{ $field['name'] }}Dropdown" data-type="{{ $type }}">
    <button class="custom-dropdown-trigger" type="button" data-dropdown="{{ $field['name'] }}">
        <span class="custom-dropdown-trigger__text" id="{{ $field['name'] }}_label">
            {{ $triggerLabel }}        
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
            if (isset($checkedMap)) {
                // O(1) lookup po id-u umesto array_reduce
                $foundItem = $checkedMap->get($label->id);
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
            @foreach($values as $value => $label)
            @php
            $inputValue = $label->id;
            $isChecked = false;
            if (is_array($checkedValues)) {
                // O(1) lookup umesto in_array po celom array-u
                $isChecked = isset($checkedIds[$label->id]);
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