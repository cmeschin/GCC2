@component('components.card')
    @slot('title')
        Arguments
    @endslot
    <div class="row">
    @foreach($service['macros']['result'] as $serviceMacro)
        @if (substr($serviceMacro['macro_name'],0,9) == 'TRANSFORM')
            @continue
        @elseif ($serviceMacro['macro_name'] == 'EXTRAOPTIONS')
                <div class="col-md-11">
                    @include('partials.form-group-input', [
                        'title' => $serviceMacro['macro_name'],
                        'type' => 'text',
                        'name' => 'macroname' . $serviceMacro['macro_name'] . $numService,
                        'value' => $serviceMacro['macro_value'],
                        'placeholder' => "",
                        'required' => false,
                        'readonly' => false,
                        ])
                </div>
        @elseif ($serviceMacro['is_password'])
            <div class="col-md-11">
                @include('partials.form-group-input', [
                    'title' => $serviceMacro['macro_name'],
                    'type' => 'password',
                    'name' => 'macroname' . $serviceMacro['macro_name'] . $numService,
                    'value' => base64_encode($serviceMacro['macro_value']),
                    'placeholder' => "",
                    'required' => true,
                    'readonly' => false,
                    ])
            </div>
        @else
            <div class="col-md-11">
                @include('partials.form-group-input', [
                    'title' => $serviceMacro['macro_name'],
                    'type' => 'text',
                    'name' => 'macroname' . $serviceMacro['macro_name'] . $numService,
                    'value' => $serviceMacro['macro_value'],
                    'placeholder' => "",
                    'required' => true,
                    'readonly' => false,
                    ])
            </div>

        @endif
        <div class="col-md-1">
            @component('components.button')
                @if ($serviceMacro['is_password'])
                    <span title="Décocher si ce n'est pas un mot de passe" class="fas fa-toggle-on color-tessi-fonce"></span>
                @else
                    <span title="Cocher si c'est un mot de passe"class="fas fa-toggle-off color-tessi-fonce"></span>
                @endif
            @endcomponent

            {{--@include('partials.form-group-input', [--}}
                {{--'title' => __('Password'),--}}
                {{--'type' => 'checkbox',--}}
                {{--'name' => 'macroPassword' . $serviceMacro['macro_name'] . $numService,--}}
                {{--'value' => $serviceMacro['is_password'],--}}
                {{--'placeholder' => "",--}}
                {{--'required' => false,--}}
                {{--'readonly' => false,--}}
                {{--])--}}
        </div>
    @endforeach
    </div>
@endcomponent
