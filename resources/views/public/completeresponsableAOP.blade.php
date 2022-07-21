@extends("layouts.public")
@section('active_souscription', 'active')
@section('class', 'content')
@section("main-content")
<a href={{ asset('/img/Formulaire_de_candidature_type_BRAVE_WOMEN_aop.pdf') }} download="Formulaire BRAVE WOMEN Burkina.png">Télécharger formulaire type</a>
<p style="background-color: rgb(231, 179, 179); color">Les champs marqués d'étoile en <span style="color:red; font-size:15px;">*</span> rouge sont obligatoires</p>
<div class="block">
    <div class="block-title">
        <h2><strong>Compléter les informations sur la/ le responsable </h2>
    </div>
        <div class="block-content2">
            <form  id="" action="{{ route("completeresponsableaop.store") }}" method="post" class="form-horizontal form-bordered" style="padding-left: 20px; border:1px solid black;" enctype="multipart/form-data" >
                @csrf
                            <div class="row">
                               <div class="col-lg-5">
                                         <fieldset>
                                                <legend>Informations générales</legend>
                                            <input type="hidden" name="promoteur" value="{{ $promoteur->id }}">
                                            <input type="hidden" name="afficherproportion" value="{{ $afficherproportion }}">

                                                    <div class="form-group">
                                                        <label class="control-label" for="val_username">Fonction dans l'entreprise AOP <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <input type="text" id="fonction_du_responsable" name="fonction" class="form-control" value="{{old('fonction')}}"placeholder="Entrez la fonction.." required="Ce champ est obligatoire">
                                                            </div>
                                                    </div>
                                                    </fieldset>
                                                        </div>
                                                        <div class="offset-md-1 col-lg-5">
                                        </div>
                                    </div>
                @if($afficherproportion==1)
                <div class="row">
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
                @endif
                    
                       </fieldset>
                            <div class="col-md-8 col-md-offset-4" style="margin-top:20px">
                                <input type="reset" class="btn btn-sm btn-warning"  value="Annuler">
                                    <input type="submit" id=""  class="btn btn-sm btn-success"  value="Valider">
                            </div>            <!-- END Form Buttons -->
                         </form>
                     </div>
                </div>                       <!-- END Wizard with Validation Block -->
@endsection
