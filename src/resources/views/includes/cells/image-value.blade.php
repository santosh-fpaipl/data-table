{{-- 
    $label : It ia used as label
    $model : It ia a model object
    Note:- Here we get a single image (primary image)
--}}
{{-- @if(!empty($label) && $model->getImage('s100') != '[]')
    {{ $label }} :
@endif --}}
@if ($model->getImage('s100') != '[]')
    <div class="text-{{ $align }}">
        <div>
            <a href="{{ $model->getImage('s100') }}" target="_blank">
                @if (Str::afterLast($model->getImage('s100'), '.') == 'pdf')
                    Open Pdf
                @else
                    <img src="{{ $model->getImage('s100') }}" class="img-thumbnail" width="50" height="50" />
                @endif
            </a>
        </div>
    </div>
@endif
