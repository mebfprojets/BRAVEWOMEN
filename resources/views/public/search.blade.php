@extends("layouts.public")
@section("main-content")
@section("class", "content")
@section('classfooter', 'footersearch')
<div class="block">
    <!-- Wizard with Validation Title -->
    <div class="block-title">
        <h2><strong>Poursuivre la souscription </h2>
    </div>
    <p>Veillez entre le code promoteur: Ex: BWBF-7222XXX</p>
    <form action="{{ route('search') }}" method="post">
        @csrf
    <div class="row">
        <div class="form-group">
            <input id="code_promoteur" class="form-control" type="text" name="code_promoteur">
            <button type="submit" class="btn btn-success">Poursuivre</button>
        </div>
    </div>

    </form>
</div>
@endsection
