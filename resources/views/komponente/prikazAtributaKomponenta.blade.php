<ul class="list-group">
    @forelse($atributi as $a)
    <li class="list-group-item"><div class="icon-wrap me-2 p-2 d-inline-block"><i class="{{$a->ikonica_klasa}}"></i></div>{{$a->naziv}}</li>

    @empty
        <li class="list-group-item fw-bolder">Nema atributa za taj tip</li>
    @endforelse
</ul>
