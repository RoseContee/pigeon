<div class="row align-items-center">
    <div class="col-6">
        @if ($event['active'])
            <a href="{{ route('user-event', ['name' => Auth::user()->slug, 'event' => $event['slug']]) }}"
               target="_blank" class="d-block ellipsis">/{{ $event['slug'] }}</a>
        @else
            <span class="d-block ellipsis text-gray">/{{ $event['slug'] }}</span>
        @endif
    </div>
    <div class="col-6">
        @if ($event['active'])
            <button class="btn btn-default btn-block text-primary" onclick="copyClipboard($(this))"
                    data-link="{{ route('user-event', ['name' => Auth::user()->slug, 'event' => $event['slug']]) }}">Copy Link</button>
        @else
            <button class="btn btn-default btn-block text-gray" disabled>Copy Link</button>
        @endif
    </div>
</div>