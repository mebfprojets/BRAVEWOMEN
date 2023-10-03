@extends("layouts.public")
@section("main-content")
{{-- @section('classfooter', 'footersearch') --}}
<a href={{ 'assets/img/formulaire.pdf' }} download="Formulaire BRAVE WOMEN Burkina.png">Télécharger formulaire type</a>
<p style="background-color: rgb(231, 179, 179); color">Les champs marqué d'étoile en <span style="color:red; font-size:15px;">*</span> rouge sont obligatoires</p>
<div class="block">

    <div class="block-title">
        <h2><strong>Compléter les informations</h2>
    </div>
<div class="block-content2">
    <form class="form-horizontal form-bordered"  action="{{ route("entreprise.update", $entreprise) }}" method="post" >
        @csrf
        {{ method_field('PUT') }}
        <input type="hidden" id="code_promoteur" name="code_promoteur" value="{{ $promoteur_code }}">
        <input type="hidden" id="entreprise" name="entreprise_id" value="{{ $entreprise->id }}">
        @if ($errors->has('entreprise_id'))
               <span class="help-block text-danger">
                     <strong>Cette entreprise a déja enregistrée son projet </strong>
                </span>
        @endif

                      <!-- END Step Info -->
                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="example-textarea-input">Décrire l'idée de projet<span class="text-danger">*</span> </label>
                                        <div class="col-md-6">
                                            <textarea id="description_projet" name="description_projet" rows="9" maxlength="500" class="form-control" placeholder="en quoi consiste votre projet, quels sont les difficultés auxquelles vous êtes confrontés dans votre activité et qui justifie votre projet ? et quels sont les objectifs du projet ?" autofocus required title="Ce champ est obligatoire">{{old('description_activite') }}</textarea>
                                        </div>
                                    </div>  
                                    <div class="col-md-6">
                                        <div class="form-group" >
                                            <label class=" control-label" for="">Coût du projet <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="number" name="cout_projet" class="form-control" placeholder="préciser le coût estimatif du projet" value="{{old("cout_projet")}}" required>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" >
                                            <label class=" control-label" for="">Montant de la subvention souhaitée <span class="text-danger">*</span><span data-toggle="tooltip" title="Précisez le montant de la subvention souhaitée. NB: vous compléterez le même montant pour la réalisation de votre projet"><i class="fa fa-info-circle"></i></span></label>
                                                <div class="input-group">
                                                    <input type="number" name="subvention_demandee" class="form-control" placeholder="préciser le montant de la subvention souhaitée" value="{{old("montant_projet")}}" required>
                                                </div>
                                        </div>
                                    </div>
                            </div>


                     <div class="col-md-8 col-md-offset-4" style="margin-top:20px">
                        <input type="reset" class="btn btn-sm btn-warning"  value="ANNULER">
                         <input type="submit" id="valider" class="btn btn-sm btn-success" value="ENREGISTRER">
                   </div>
        </form>
                                    <!-- END Wizard with Validation Content -->
       </div>
                                <!-- END Wizard with Validation Block -->


</div>
@endsection
