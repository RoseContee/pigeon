<h3><strong>Hi {{ $name }}</strong></h3>

<p>A new event has been scheduled.</p>

<p><strong>Event Type</strong>:<br>{{ $event['name'] }}</p>

@if (!empty($data['name']))
    <p><strong>Invitee</strong>:<br>{{ $data['name'] }}</p>
@endif

@if (!empty($data['email']))
    <p><strong>Invitee Email</strong>:<br>{{ $data['email'] }}</p>
@endif

@if (!empty($data['phone']))
    <p><strong>Invitee Phone</strong>:<br>{{ $data['phone'] }}</p>
@endif

<p><strong>Event Date/Time</strong>:<br>{{ $data['date'] }}</p>

<p><strong>Description</strong>:<br>{{ $event['description'] }}</p>

<p>&nbsp;</p>

<p>Best Regard!</p>

<h3>
    <a href="{{ route('index') }}" style="text-decoration: none; color: black;">
        <strong>Pigeon Support</strong>
    </a>
</h3>