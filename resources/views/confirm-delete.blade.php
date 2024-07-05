
<div class="modal-body">
    <p>Da li ste sigurni da želite da obrišete {{$tip}} ?</p>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" onclick="closeModal()" id="close-modal">Ne</button>
    <form action="{{$putanjaZaBrisanje}}" method="POST">
        @csrf
        @method("DELETE")
        <button name="da" type="submit" class="btn btn-danger">Da</button>
    </form>
</div>
