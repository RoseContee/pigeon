@php
$times = old($week, explode(',', empty($item) ? '' : $item[$week]));
@endphp
<div class="row mb-0">
    <div class="col-sm-6">
        @for ($i = 0; $i < 12; $i++)
            @php
                $value = str_pad((string)($i ?: 12), 2, "0", STR_PAD_LEFT).':00 AM';
                $to = str_pad((string)($i + 1 < 12 ? $i + 1 : 12), 2, "0", STR_PAD_LEFT).':00 '.($i < 11 ? 'AM' : 'PM');
                $label = "$value - $to";
            @endphp
            <label class="form-check">
                <input class="form-check-input" type="checkbox" name="{{ $week }}[]" @if(in_array($value, $times)) checked @endif
                       value="{{ $value }}"> {{ $label }}
            </label>
        @endfor
    </div>
    <div class="col-sm-6">
        @for ($i = 0; $i < 12; $i++)
            @php
                $value = str_pad((string)($i ?: 12), 2, "0", STR_PAD_LEFT).':00 PM';
                $to = str_pad((string)($i + 1 < 12 ? $i + 1 : 12), 2, "0", STR_PAD_LEFT).':00 '.($i < 11 ? 'PM' : 'AM');
                $label = "$value - $to";
            @endphp
            <label class="form-check">
                <input class="form-check-input" type="checkbox" name="{{ $week }}[]" @if(in_array($value, $times)) checked @endif
                       value="{{ $value }}"> {{ $label }}
            </label>
        @endfor
    </div>
</div>