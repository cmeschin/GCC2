<div class="form-group">
    <label for="{{ $name }}">{{ $title }}</label>
    <div class="form-control">
        <select id="{{ $name }}" name="{{ $name }}[]" class="select2 form-control{{ $errors->has( $name .'[]') ? ' is-invalid' : ''}}" {{$multiple}} required style="width: 100%">
            <option value="">...</option>
            @foreach($values as $value)
                @if (is_array($myvalue))
                    {{--Si myvalue est un tableau (typiquement les fonction d'hôtes) on parcours chaque valeur--}}
                    @foreach($myvalue as $element)
                        @if ( strpos($value['name'],$element))
                            {{--si myvalue correspond à la fonction de la liste, on la sélectionne--}}
                            <option value="{{ $value['id'] }}" selected>{{ $value['alias'] }}</option>
                        @else
                            <option value="{{ $value['id'] }}">{{ $value['alias'] }}</option>
                        @endif
                    @endforeach
                @else
                    @if ( strpos($value['name'],$myvalue))
                        {{--si myvalue correspond à la fonction de la liste, on la sélectionne--}}
                        <option value="{{ $value['id'] }}" selected>{{ $value['alias'] }}</option>
                    @else
                        <option value="{{ $value['id'] }}">{{ $value['alias'] }}</option>
                    @endif
                @endif
            @endforeach

        </select>
        @if ($errors->has($name))
        <div class="invalid-feedback">
            {{ $errors->first($name) }}
        </div>
        @endif
    </div>
</div>