@foreach (['success', 'error', 'warning', 'info'] as $msg)
@if (session($msg))
<div class="mb-4 px-4 py-2 rounded
            {{ $msg === 'success' ? 'bg-green-100 text-green-800' : '' }}
            {{ $msg === 'error' ? 'bg-red-100 text-red-800' : '' }}
            {{ $msg === 'warning' ? 'bg-yellow-100 text-yellow-800' : '' }}
            {{ $msg === 'info' ? 'bg-blue-100 text-blue-800' : '' }}">
  <span class="font-semibold">✔ {{ session($msg) }}</span>

</div>
@endif
@endforeach