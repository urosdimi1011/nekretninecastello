
<div class="modal-body">
    <p>Da li zelite da vratite {{$tip}} ?</p>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" onclick="closeModal()" id="close-modal">Ne</button>
    <form action="{{$putanja}}" method="GET">
        @csrf
        <button name="da" type="submit" class="btn btn-danger">Da</button>
    </form>
</div>

