<div class="form-group {{ $week }}">
    Apply to:<br>
    @if (in_array($week, ['mon']))
        <label class="form-check ml-3 tue">
            <input class="form-check-input apply-to"
                   @if (empty(Globals::$tue) && !empty($item) && $item[$week] == $item['tue']) <?php Globals::$tue = 'hidden'; ?> checked @endif
                   type="checkbox" name="{{ $week }}_applies[]" value="tue">Tuesday
        </label>
    @endif
    @if (in_array($week, ['mon', 'tue']))
        <label class="form-check ml-3 wed">
            <input class="form-check-input apply-to"
                   @if (empty(Globals::$wed) && !empty($item) && $item[$week] == $item['wed']) <?php Globals::$wed = 'hidden'; ?> checked @endif
                   type="checkbox" name="{{ $week }}_applies[]" value="wed">Wednesday
        </label>
    @endif
    @if (in_array($week, ['mon', 'tue', 'wed']))
        <label class="form-check ml-3 thu">
            <input class="form-check-input apply-to"
                   @if (empty(Globals::$thu) && !empty($item) && $item[$week] == $item['thu']) <?php Globals::$thu = 'hidden'; ?> checked @endif
                   type="checkbox" name="{{ $week }}_applies[]" value="thu">Thursday
        </label>
    @endif
    @if (in_array($week, ['mon', 'tue', 'wed', 'thu']))
        <label class="form-check ml-3 fri">
            <input class="form-check-input apply-to"
                   @if (empty(Globals::$fri) && !empty($item) && $item[$week] == $item['fri']) <?php Globals::$fri = 'hidden'; ?> checked @endif
                   type="checkbox" name="{{ $week }}_applies[]" value="fri">Friday
        </label>
    @endif
    @if (in_array($week, ['mon', 'tue', 'wed', 'thu', 'fri']))
        <label class="form-check ml-3 sat">
            <input class="form-check-input apply-to"
                   @if (empty(Globals::$sat) && !empty($item) && $item[$week] == $item['sat']) <?php Globals::$sat = 'hidden'; ?> checked @endif
                   type="checkbox" name="{{ $week }}_applies[]" value="sat">Saturday
        </label>
    @endif
    @if (in_array($week, ['mon', 'tue', 'wed', 'thu', 'fri', 'sat']))
        <label class="form-check ml-3 sun">
            <input class="form-check-input apply-to"
                   @if (empty(Globals::$sun) && !empty($item) && $item[$week] == $item['sun']) <?php Globals::$sun = 'hidden'; ?> checked @endif
                   type="checkbox" name="{{ $week }}_applies[]" value="sun">Sunday
        </label>
    @endif
</div>