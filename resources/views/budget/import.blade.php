@extends('layouts.admin')
@section('gestion_projet', 'active')
@section('budget', 'active')
@section('content')
<div class=" col-xs-6 block-content ">
    <div class="block full">
            <!-- Block Tabs Title -->
            <div class="block-title">
                <h2><strong>Importer</strong> Le budget</h2>
                <a href={{ asset('/img/import_budget.xlsx') }} class="btn btn-success pull-right"><span><i class="fa fa-plus"></i></span> Télécharger le fichier type</a>

            </div>
        <div class="tab-content" >
    
        <h3>Importer</h3>

        <form method="POST" action="{{ route('budget.import_store') }}" enctype="multipart/form-data" >
            @csrf
            <div class="row">
                <div class="form-group col-md-8" >
                    <label class=" control-label" for="val_username">Date d'effet : </label>
                        <div class="input-group">
                            <input type="text" id="" name="date_deffet" class="form-control datepicker" data-date-format="dd-mm-yyyy" placeholder="Date d'effet .." value="{{old('date_deffet')}}" required >
                        </div>
                </div>
            </div>
            <input type="file" name="fichier" >
            <button type="submit" >Importer</button>
        </form> 
        </div>
    </div>
</div>
<div class=" col-xs-6 block-content ">
    <div class="block full">
            <!-- Block Tabs Title -->
            <div class="block-title">
                <h2><strong>Importer</strong> les previsions budgétaires</h2>
                <a href={{ asset('/img/import_prevision_budget.xlsx') }} class="btn btn-success pull-right"><span><i class="fa fa-plus"></i></span> Télécharger le fichier type</a>

            </div>
        <div class="tab-content" >
    
        <h3>Importer</h3>

        <form method="POST" action="{{ route('budget.import_prevision_store') }}" enctype="multipart/form-data" >
            @csrf
            <div class="row">
                <div class="form-group col-md-8" >
                    <label class=" control-label" for="val_username">Date d'effet : </label>
                        <div class="input-group">
                            <input type="text" id="" name="date_deffet" class="form-control datepicker" data-date-format="dd-mm-yyyy" placeholder="Date d'effet .." value="{{old('date_deffet')}}" required >
                        </div>
                </div>
            </div>
            <input type="file" name="fichier" >
            <button type="submit" >Importer</button>
        </form> 
        </div>
    </div>
</div>
<div class=" col-xs-6 block-content ">
    <div class="block full">
            <!-- Block Tabs Title -->
            <div class="block-title">
                <h2><strong>Importer</strong> le cash flow</h2>
                <a href={{ asset('/img/import_cash_flow.xlsx') }} class="btn btn-success pull-right"><span><i class="fa fa-plus"></i></span> Télécharger le fichier type</a>

            </div>
        <div class="tab-content" >
    
        <h3>Importer</h3>

        <form method="POST" action="{{ route('budget.import_cashflow_store') }}" enctype="multipart/form-data" >
            @csrf
            <div class="row">
                <div class="form-group col-md-8" >
                    <label class=" control-label" for="val_username">Date d'effet : </label>
                        <div class="input-group">
                            <input type="text" id="" name="date_deffet" class="form-control datepicker" data-date-format="dd-mm-yyyy" placeholder="Date d'effet .." value="{{old('date_deffet')}}" required >
                        </div>
                </div>
            </div>
            <input type="file" name="fichier" >
            <button type="submit" >Importer</button>
        </form> 
        </div>
    </div>
</div>
@endsection      