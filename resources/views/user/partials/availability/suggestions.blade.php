@if (empty($suggestions))
    <span class="text-success">Available.</span>
@else
    <span class="text-danger">Not available.</span> We are suggesting:
    @foreach ($suggestions as $suggestion)
        <a href="javascript:void(0);"
           onclick="$('#link').val($(this).text());
           $(this).parent().remove();
           $('#submit').removeAttr('disabled');">{{ $suggestion }}</a>,
    @endforeach
@endif