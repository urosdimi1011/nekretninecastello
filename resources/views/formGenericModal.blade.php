<form id="dynamicForm" action="{{ $action }}" method="POST">
    @csrf
    @foreach ($fields as $field)
        <div class="form-group">
            <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
            @if ($field['type'] === 'textarea')
                <textarea id="{{ $field['name'] }}" name="{{ $field['name'] }}" class="form-control"></textarea>
            @else
                <input type="{{$field['type']}}" id="{{ $field['name'] }}" name="{{ $field['name'] }}" class="form-control">
            @endif
        </div>
    @endforeach
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
