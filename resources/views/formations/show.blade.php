@extends('layouts.admin')
@section('formation', 'active')
@section('formation-sessions', 'active')
@section('content')
<div class="col-md-10">
        <!-- Basic Form Elements Title -->

                <!-- Form Validation Example Block -->
                <div class="block">
                    <!-- Form Validation Example Title -->
                    <div class="block-title">
                        <h2> Details de la <strong>Session de Formation</strong></h2>
                    </div>
                    <div class="row">
                        <div class="form-group ">
                            <p class="col-md-4 control-label labdetail"> <span class="labdetail">Libelle de la formation : </span> </p>
                            <p class="col-md-6" >
                            <span class="valdetail">
                                @empty($formation->libelle)
                                    Informations non disponible
                                @endempty
                                {{$formation->libelle}}
                            </span>
                        </p>
                        </div>
                        <div class="form-group ">
                            <p class="col-md-4 control-label labdetail"> <span class="labdetail">Type de la formation : </span> </p>
                            <p class="col-md-6" >
                            <span class="valdetail">
                                @empty($formation->libelle)
                                    Informations non disponible
                                @endempty
                                {{getlibelle($formation->type)}}
                            </span>
                        </p>
                    </div>
                    <div class="form-group ">
                        <p class="col-md-4 control-label labdetail"> <span class="labdetail">Commence le: </span> </p>
                        <p class="col-md-6" >
                        <span class="valdetail">
                            @empty($formation->date_debut)
                                Informations non disponible
                            @endempty
                            {{format_date($formation->date_debut) }}
                        </span>
                    </p>
                    </div>
                    <div class="form-group ">
                        <p class="col-md-4 control-label labdetail"> <span class="labdetail">Fini le: </span> </p>
                        <p class="col-md-6" >
                        <span class="valdetail">
                            @empty($formation->date_fin)
                                Informations non disponible
                            @endempty
                            {{format_date($formation->date_fin)}}
                        </span>
                    </p>
                    </div>
                </div>
            </div>
            <hr>
            <div class="block">
                <!-- Form Validation Example Title -->
                <div class="block-title">
                    <h2>  <strong> Liste des participants à la session</strong></h2>
                </div>
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-vcenter table-condensed table-bordered listepdf">
                    <thead>
                        <tr>
                            <th>Denomination</th>
                            <th>code_promoteur</th>
                            <th>telephone_promoteur</th>
                        </tr>
                </thead>
                <tbody>
                @foreach($participants as $participant)
                    <tr @if($participant->present=='oui')
                        style="color:green;"
                    @endif>
                        <td>{{$participant->denomination}}</td>
                        <td>{{$participant->promotrice->code_promoteur}}</td>
                        <td>{{$participant->promotrice->telephone_promoteur}}</td>
                    </tr>
                @endforeach
                    </tbody>
                </table>
            </div>
            </div>

            </div>
 </div>

@endsection
