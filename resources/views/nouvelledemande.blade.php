@extends('layouts.form_demande')
@section('card')
    @component('components.card')
        @slot('title')
            @lang('Informations générales')
        @endslot
        <form method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}
            <div class="row">
            	<div class="col-md-4">
                @include('partials.form-group', [
                    'title' => __('Demandeur'),
                    'type' => 'text',
                    'name' => 'demandeur',
                    'value' => Auth::user()->username,
                    'required' => true,
                    'readonly' => true,
                    ])
                </div>
                <div class="col-md-4">
                @include('partials.form-group', [
                    'title' => __('Référence de la demande'),
                    'type' => 'text',
                    'name' => 'refdemande',
                    'value' => date("YmdHi") . "_" . Auth::user()->username,
                    'required' => true,
                    'readonly' => true,
                    ])
                </div>
                <div class="col-md-4">
                @include('partials.form-group', [
                    'title' => __('Date de supervision'),
                    'type' => 'date',
                    'name' => 'datedemande',
                    'value' => date("d / m / Y"),
                    'required' => true,
                    'readonly' => false,
                    ])
                </div>
			</div>
            <div class="row">
                <div class="col-md-12">
                @include('partials.form-group', [
                    'title' => __('Liste de diffusion'),
                    'type' => 'email',
                    'name' => 'email',
                    'value' => Auth::user()->email,
                    'required' => true,
                    'readonly' => false,
                    ])
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                <label for="typeDemande">Type de demande</label>
                        <select id="typeDemande" name="typeDemande[]" class="form-control" required>
							<option value="" selected></option>
							<option value="v1">valeur 1</option>
							<option value="v2">valeur 2</option>
							<option value="v3">valeur 3</option>
							<option value="t1">truc 1</option>
							<option value="t2">truc 2</option>
							<option value="t3">truc 3</option>
                        </select>
<!--                 @include('partials.form-select', [
                    'title' => __('Type de demande'),
                    'name' => 'typedemande',
                    'required' => true,
                    'selected' => "",
                    ])
 -->                </div>
                <div class="col-md-9">
                @include('partials.form-group', [
                    'title' => __('Prestation'),
                    'type' => 'text',
                    'name' => 'prestation',
                    'required' => true,
                    'readonly' => false,
                    ])
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
        				<label for="commentaire">Description</label>
        				<textarea id="commentaire" type="text" class="form-control" name="commentaire" rows="3"></textarea>
        				
    				</div>
                </div>
            </div>
            @component('components.button')
                @lang('Inscription')
            @endcomponent
        </form>
    @endcomponent
@endsection

@section('script')
<script>
        $('#tag_list').select2({
            placeholder: "Choisir le type",
            minimumInputLength: 2
        });
    </script>
@endsection