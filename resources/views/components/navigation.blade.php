<!-- resources/views/components/navigation.blade.php -->
<nav class="bg-gray-100 p-4 flex justify-between items-center">
  <div>
    <a href="{{ route('expenses.index') }}" class="font-bold text-lg">経費精算メニュー</a>
  </div>
  <div>
    @auth
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="bg-red-500 text-white px-4 py-1 rounded">ログアウト</button>
    </form>
    @endauth
  </div>
</nav>