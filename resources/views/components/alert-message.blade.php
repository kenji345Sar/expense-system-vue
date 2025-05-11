@foreach (['success', 'error', 'warning', 'info'] as $msg)
@if (session($msg))
<p class="mb-4 p-2 rounded bg-{{ $msg == 'success' ? 'green' : ($msg == 'error' ? 'red' : 'yellow') }}-100 text-{{ $msg == 'success' ? 'green' : ($msg == 'error' ? 'red' : 'yellow') }}-800">
    {{ session($msg) }}
</p>
@endif
@endforeach