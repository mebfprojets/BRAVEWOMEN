@extends("layouts.admin")
@section('administration', 'active')
@section('administration-parametre', 'active')
@section('blank')
    <li>Accueil</li>
    <li>Roles</li>
    <li><a href="">liste</a></li>
@endsection
    @section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Form Validation Example Block -->
                <div class="block">
                    <!-- Form Validation Example Title -->
                    <div class="block-title">
                        <h2><strong>Completer les information du promoteur</strong> </h2>
                    </div>
                    <form id="form-validation" method="POST"  action="{{route('proportiondedepense.enr')}}" class="form-horizontal form-bordered">
                            {{ csrf_field() }}
                            <div class="row">
                                <input type="hidden" name="id_promoteur" value="{{ $entreprise->promotrice->id }}">
                              @foreach ($proportiondedepences as $proportiondedepence )
                              <div class="col-md-4">
                              <fieldset>
                                  <legend>{{ $proportiondedepence->description }} {{ $proportiondedepence->libelle }}  <span data-toggle="tooltip" title="{{$proportiondedepence->description}}"><i class="fa fa-info-circle"></i></span></legend>
                                  @foreach ($annees as $annee)
                                      <div class="form-group">
                                          <label class="col-md-4 control-label" for="val_email">En {{ $annee->libelle }}<span class="text-danger">*</span></label>
                                          <div class="col-md-6">
                                              <div class="input-group">
                                                  <input type="number" min=0 max=100 id="num_rccm" name="{{ $proportiondedepence->id }}{{$annee->id }}" value="{{old('{!! $proportiondedepence->id !!}{!! $annee->id !!}')}}" class="form-control" placeholder="Entrez le pourcentage" autofocus required title="Ce champ est obligatoire et doit être compris entre 0 et 100.">
                                              </div>
                                          </div>
                                      </div>
                                  @endforeach
                              </fieldset>
                              </div>
                              @endforeach
                          </div>
                          <div class="row">
                            <input type="hidden" name="id_entreprise" value="{{ $entreprise->id }}">
                            <input type="hidden" name="code_promoteur" value="{{ $entreprise->promotrice->code_promoteur }}">
                            @foreach ($nombre_de_clients as $nombre_de_client )
                            <fieldset>
                                <legend>{{ $nombre_de_client->description }} {{ $nombre_de_client->libelle }}  <span data-toggle="tooltip" title="{{$nombre_de_client->description}}"><i class="fa fa-info-circle"></i></span></legend>
                                @foreach ($annees as $annee)
                                    <div class="form-group col-md-4">
                                        <label class="col-md-4 control-label" for="val_email">En {{ $annee->libelle }}<span class="text-danger">*</span></label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <input type="number" min=0  id="nbre_client" name="{{ $nombre_de_client->id }}{{$annee->id }}" value="{{old('{!! $nombre_de_client->id !!}{!! $annee->id !!}')}}" class="form-control" placeholder="Entrez le nombre" autofocus required title="Ce champ est obligatoire et doit être compris entre 0 et 100.">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </fieldset>
                           
                            @endforeach
                        </div>
                        <div class="form-group form-actions">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-sm btn-sucess"><i class="fa fa-arrow-right"></i> Valider</button>
                            <a href="{{ route('role.index') }}" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Annuler</a>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
