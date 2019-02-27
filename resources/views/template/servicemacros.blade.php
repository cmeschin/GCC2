@component('components.card')
    @slot('title')
        Arguments
    @endslot
    <div class="row">

        @foreach($service['macros']['result'] as $serviceMacro)
            @php
                $name = 'macroname_' . $numService . "_" .  $serviceMacro['macro_name'];
                $placeholder = "";
                $readonly = '';
                $required = 'true';
                if($serviceMacro['macro_value']){
                    $macro_value = $serviceMacro['macro_value'];
                } else {
                    $macro_value = "NC";
                };
                if ($serviceMacro['is_password']){
                    $type = 'password';
                    $macro_value = base64_encode($macro_value);
                } else {
                    $type = 'text';
                };

                if ($serviceMacro['description']){
                    $title = $serviceMacro['description'];
                    $placeholder = $serviceMacro['description'];
                } else {
                    $title = $serviceMacro['macro_name'];
                };
                if (substr($serviceMacro['macro_name'],0,9) == 'TRANSFORM'){
                    continue;
                } else if ($serviceMacro['macro_name'] == 'EXTRAOPTIONS'){
                    $macro_name = $serviceMacro['macro_name'];
                    $required = '';
                };
            @endphp
            <div class="col-md-11">
                @include('partials.form-group-input', [
                    'title' => $serviceMacro['macro_name'],
                    'type' => $type,
                    'name' => $name,
                    'value' => $macro_value,
                    'placeholder' => $placeholder,
                    'required' => $required,
                    'readonly' => $readonly,
                    ])
                @if ($serviceMacro['is_password'])
                        <span title="Afficher/Masquer le mot de passe" class="fas fa-toggle-on color-tessi-fonce" onclick=""></span>
                @endif
            </div>
            @if ($serviceMacro['is_password'])
                <div class="col-md-1">
                    @component('components.button-simple')
                        {{--@if ($serviceMacro['is_password'])--}}
                            <span title="Afficher/Masquer le mot de passe" class="fas fa-toggle-on color-tessi-fonce" onclick=""></span>
                        {{--@else--}}
                            {{--<span title="Masquer le mot de passe"class="fas fa-toggle-off color-tessi-fonce"></span>--}}
                        {{--@endif--}}
                    @endcomponent
                </div>
            @endif
        @endforeach
    </div>
@endcomponent
