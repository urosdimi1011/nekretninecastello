@props(['field', 'values', 'checkedValues', 'type'])
@php
$stavi = '';
if (is_array($checkedValues)) {
$stavi = '[]';
}
@endphp

<div class="custom-dropdown-field" id="{{ $field['name'] }}Dropdown">
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
            @foreach($values as $value => $label)
            @php
            $foundValue = 'ne';
            if (is_array($checkedValues)) {
            $foundItem = array_reduce($checkedValues, function ($carry, $item) use ($label) {
            if (isset($item->id)) {
            return $item->id == $label->id ? $item : $carry;
            } else {
            return $item == $label->id ? $item : $carry;
            }
            }, null);
            $foundValue = $foundItem ? (isset($foundItem->vrednost) ? $foundItem->vrednost : $foundItem) : 'ne';
            }
            $inputValue = ($type == "text") ? $foundValue : $label->id;
            $inputValue = trim($inputValue);

            $isChecked = false;
            if (is_array($checkedValues)) {
            $plucked = collect($checkedValues)->pluck('id')->toArray();
            if (in_array(null, $plucked)) {
            $isChecked = in_array($label->id, $checkedValues);
            } else {
            $isChecked = in_array($label->id, $plucked);
            }
            } elseif ($label->id == $checkedValues) {
            $isChecked = true;
            }

            $displayLabel = $label->naziv ?? $label->tip ?? '';
            @endphp

            <label class="custom-dropdown-opcija {{ $isChecked ? 'is-checked' : '' }}"
                data-label="{{ $displayLabel }}">
                <input
                    type="{{ $type }}"
                    @if($type==='text' ) data-id="{{ $label->id }}" @endif
                    name="{{ $field['name'] }}{{ $stavi }}"
                    value="{{ $inputValue }}"
                    @if($isChecked) checked @endif
                    @if($type !=='text' ) class="custom-dropdown-input" @endif />
                <span class="custom-dropdown-opcija__indicator"></span>
                <span class="custom-dropdown-opcija__tekst">{{ $displayLabel }}</span>
            </label>

            @endforeach
        </div>
    </div>
</div>