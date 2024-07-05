@props(['field', 'values', 'checkedValues','type'])
@php
$stavi = '';
    if(is_array($checkedValues)){
        $stavi = '[]';
    }
@endphp
<div class="dropdown-checkboxes">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="{{ $field['name'] }}Dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ $field['label'] }}
    </button>
    <div class="dropdown-menu" aria-labelledby="{{ $field['name'] }}Dropdown">
        @foreach($values as $value => $label)
            <div class="form-check">
                @php
                $foundValue = 'ne';
                    if(is_array($checkedValues)){
                         $foundItem = array_reduce($checkedValues, function ($carry, $item) use ($label) {
                             if(isset($item->id)){
                                return $item->id === $label->id ? $item : $carry;
                             }
                             else{
                                return $item === $label->id ? $item : $carry;
                             }

                            }, null);
                                                                           dd($foundItem);
                         $foundValue = $foundItem ? (isset($foundItem->vrednost)?$foundItem->vrednost:$foundItem) : 'ne';
                                                  dd($foundValue);
                    }
                                $value = ($type == "text") ?  $foundValue : $label->id;


                                $value = trim($value);

                @endphp
                <input class="@if($type!="text") form-check-input @endif"
                       type="{{$type}}" @if($type=="text") data-id="{{$label->id}}" @endif name="{{ $field['name'] }}{{$stavi}}"
                       value="{{ $value }}"
                       @if(is_array($checkedValues) && (in_array(NULL,collect($checkedValues)->pluck("id")->toArray()))?in_array($label->id, $checkedValues) : in_array($label->id, collect($checkedValues)->pluck("id")->toArray()))
                           checked
                       @elseif($label->id == $checkedValues)
                           checked
                    @endif />

                <label class="form-check-label" for="{{ $field['name'] }}_{{ $value }}">
                    {{ $label->naziv ?? $label->tip }}
                </label>
            </div>
        @endforeach
    </div>
</div>
