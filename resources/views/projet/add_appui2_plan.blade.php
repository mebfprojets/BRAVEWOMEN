@extends("layouts.espace_beneficiaire")
@section('pca', 'active')
@section('content')
        <div class="row mt">
          <div class="col-lg-12">
            <div class="form-panel">
                <h4 class="mb"><i class="fa fa-angle-right" style="text-align: center"></i> Enregistrement les lignes d'investissement du deuxieme appui</h4>
                <hr>
            <form id="progress-wizard" action="{{ route('projet.store_plan_appui2') }}" method="post" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label class=" control-label" for="example-chosen">Selectionner le projet<span class="text-danger">*</span></label>
                        <select id="entreprise" name="projet"  value="" class="form-control select-select2"  data-placeholder="Selectionner le projet concernée par cet appuis .." style="width: 80%;" required>
                            <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                            @foreach ($projets as $projet )
                                {{-- @if(!$entreprise->projet) --}}
                                    <option value="{{ $projet->id  }}" {{ old('coach') == $projet->id ? 'selected' : '' }}>{{ $projet->titre_du_projet }} </option>
                                {{-- @endif --}}
                            @endforeach
                        </select>
                </div>
                <h3>Plan  d'investissement deuxieme appui (Ajouter les lignes d'investissements)</h3>
                <div class="row" style="text-weight:bold;">
                    <span class="col-md-2">Categorie</span>
                    <span class="col-md-3">Coût</span>
                    <span class="col-md-3">Subvention</span>
                    <span class="col-md-3">Contrepartie</span>
                </div>
                <div class="field_wrapper2">
                    <div >
                        <select class="col-md-2" name="designation[]"  class="select-select2" data-placeholder="designation" required>
                                <option></option>
                                @foreach ($categorie_investissments as  $categorie_investissment)
                                    <option value='{{ $categorie_investissment->id}}'>{{ getlibelle($categorie_investissment->id) }}</option>
                                @endforeach
                        </select>
                        <input class="col-md-3" type="text" name="cout[]"  value=""  placeholder="Le prix" id="cout0"  required />
                        <input class="col-md-3" type="text" name="subvention[]"  value="" placeholder="Subvention demandée" id="sub0" required onChange="deux_somme_complementaire('sub0','apport0','cout0')"  />
                        <input class="col-md-3" type="text" name="apport_perso[]" value=""  placeholder="Apport personne" id="apport0" required />
                        <a href="javascript:void(0);" class="add_button2" title="Add field"><span><i class="fa fa-plus"></i></span></a>
                    </div>
                </div>
                    <div class="col-md-12">
                        <h2>Joindre les documents</h2>
                        <div class="form-group{{ $errors->has('plan_de_continute') ? ' has-error' : '' }}">
                            <label class="control-label col-md-4" for="plan_de_continute">Plan de Continuité des Activités revu  <span class="text-danger">*</span></label>
                            <div class="input-group col-md-6">
                                <input class="form-control col-md-6" type="file" name="plan_de_continute_revu" id="plan_de_continute" accept=".pdf, .jpeg, .png"   placeholder="Joindre le plan de continuité des activité" required  onchange="VerifyUploadSizeIsOK('plan_de_continute');" >
                                <span class="input-group-addon"><i class="gi gi-file"></i></span>
                                <span class="input-group-addon"><a href="#" class="empty_field" onclick="empty_input_file('plan_de_continute')">Vider le champ</a></span>
                            </div>
                            @if ($errors->has('plan_de_continute_revu'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('plan_de_continute_revu') }}</strong>
                                </span>
                                @endif
                        </div>
                        <div class="form-group{{ $errors->has('synthese_plan_de_continute') ? ' has-error' : '' }}">
                            <label class="control-label col-md-4" for="synthese_plan_de_continute">Synthèse du plan de continuité revu <span class="text-danger">*</span></label>
                            <div class="input-group col-md-6">
                                <input class="form-control col-md-6" type="file" name="synthese_plan_de_continute_revu" id="synthese_plan_de_continute" accept=".pdf, .jpeg, .png"   placeholder="Joindre la synthèse du plan de continuité des activité" required onchange="VerifyUploadSizeIsOK('synthese_plan_de_continute');">
                                <span class="input-group-addon"><i class="gi gi-file"></i></span>
                                <span class="input-group-addon"><a href="#" class="empty_field" onclick="empty_input_file('synthese_plan_de_continute')">Vider le champ</a></span>
                            </div>
                            @if ($errors->has('synthese_plan_de_continute_revu'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('synthese_plan_de_continute_revu') }}</strong>
                                </span>
                                @endif
                        </div>
                        <div class="form-group{{ $errors->has('devis_des_investissements') ? ' has-error' : '' }}">
                            <label class="control-label col-md-4" for="devis_des_investissements">Devis des équipements et matériels à acquérir  <span class="text-success">*</span></label>
                            <div class="input-group col-md-6">
                                <input class="form-control col-md-6" type="file" name="devis_des_investissements" id="devis_des_investissements" accept=".pdf, .jpeg, .png"   placeholder="Joindre le dévis des équipements du plan d'investissement" onchange="VerifyUploadSizeIsOK('devis_des_investissements');" >
                                <span class="input-group-addon"><i class="gi gi-file"></i></span>
                                <span class="input-group-addon"><a href="#" class="empty_field" onclick="empty_input_file('devis_des_investissements')">Vider le champ</a></span>
                            </div>
                            @if ($errors->has('devis_des_investissements'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('devis_des_investissements') }}</strong>
                                </span>
                                @endif
                        </div>
                        <div class="form-group{{ $errors->has('copie_document_foncier') ? ' has-error' : '' }}">
                            <label class="control-label col-md-4" for="copie_document_foncier">Copie PUH, titre foncier ou tout document foncier   <span class="text-success">*</span></label>
                            <div class="input-group col-md-6">
                                <input class="form-control col-md-6" type="file" name="copie_document_foncier" id="copie_document_foncier" accept=".pdf, .jpeg, .png"   placeholder="joindre une copie du document foncier si vous souhaiter faire un investissement de type construction" onchange="VerifyUploadSizeIsOK('copie_document_foncier');">
                                <span class="input-group-addon"><i class="gi gi-file"></i></span>
                                <span class="input-group-addon">
                                <a href="#" class="empty_field" onclick="empty_input_file('copie_document_foncier')">
                                    Vider le champ
                                  </a></span>
                               
                            </div>
                            @if ($errors->has('copie_document_foncier'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('copie_document_foncier') }}</strong>
                                </span>
                                @endif
                        </div>
                
                    </div>
           
                <!-- END Third Step -->
        
                <!-- Form Buttons -->
                <div class="form-group form-actions button_formulaire">
                    <div class="col-md-8 col-md-offset-4">
                        <input type="reset" class="btn btn-sm btn-warning" id="back3" value="Back">
                        <input id='tester' type="submit" class="btn btn-sm btn-success " id="next3" value="Next">
                    </div>
                </div>
                <!-- END Form Buttons -->
            </form>
          </div>
        </div>
        </div>
@endsection
@section('script_additionnel')
<script>
    function empty_input_file(input) {
        $('#'+ input).val('');
}
</script>
<script type="text/javascript">

    $(document).ready(function(){
        var maxField = 5; //Input fields increment limitation
        var addButton = $('.add_button2'); //Add button selector
        var wrapper2 = $('.field_wrapper2'); //Input field wrapper
        //var fieldHTML = '<div><label for="">Ligne dinvestissement:</label> <select  name="designation[]" data-placeholder="designation" > <option></option> @foreach ($categorie_investissments as  $categorie_investissment)<option value="{{ $categorie_investissment->id}}">{{ getlibelle($categorie_investissment->id) }}</option>@endforeach </select> <input type="number" name="cout[]"  placeholder="cout" min="1000" required/> <input type="number" name="subvention[]"  min="1000" placeholder="Subvention demandée"  required/> <input type="number" name="apport_perso[]"  min="1000" placeholder="Apport personne" required />   <a href="javascript:void(0);" class="remove_button"><span> <i class="fa fa-minus"></i></a></div>';
        //var fieldHTML2 = '<div><input type="text" name="field_name1[]" value=""/><a href="javascript:void(0);" class="remove_button"><img src="remove-icon.png"/></a></div>'; //New input field html
        var x = 0; //Initial field counter is 1
        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){
                x++; //Increment field counter
                var desi="desi"+x;
                var cout='cout'+x ;
                var fieldHTML = '<div> <select class="col-md-2"  name="designation[]"  data-placeholder="designation" > <option></option> @foreach ($categorie_investissments as  $categorie_investissment)<option value="{{ $categorie_investissment->id}}">{{ getlibelle($categorie_investissment->id) }}</option>@endforeach </select> <input class="col-md-3" type="text" name="cout[]"  placeholder="cout"  id="' + cout + '"  required/> <input  class="col-md-3" type="text" name="subvention[]"  placeholder="Subvention demandée" id="sub' + x +'"  onChange=deux_somme_complementaire("sub' + x +'","apport' + x +'","' + cout + '")  required/> <input class="col-md-3" type="text" name="apport_perso[]"   placeholder="Apport personne" id="apport' + x +'"   required />   <a href="javascript:void(0);" class="remove_button"><span> <i class="fa fa-minus"></i></a></div>';
                $(wrapper2).append(fieldHTML);
            }
        });
        $('#cout1').change(function(){
  alert("The text has been changed.");
}); 
        //Once remove button is clicked
        $(wrapper2).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });
    </script>
 
@endsection

