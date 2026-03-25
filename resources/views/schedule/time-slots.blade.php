@forelse($time_slots as $time_slot)
    <div class="col-lg-2 col-sm-3 col-6">
        <a href="javascript:void(0);" class="card" onclick="openBookingModal($(this))"
           data-date="{{ $booking_date }}" data-from="{{ $time_slot[0] }}" data-to="{{ $time_slot[1] }}" data-schedule="{{ date('l, F j, Y', strtotime($booking_date)) }}">
            <div class="card-body p-2">
                {{ $time_slot[0] }}
            </div>
        </a>
    </div>
@empty
    <div class="col-12">
        No available times.
    </div>
@endforelse