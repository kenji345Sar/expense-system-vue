<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>@yield('title', '経費精算システム')</title>
</head>

<body>
  <header>
    <nav>
      <a href="{{ route('expenses.index') }}">メニューに戻る</a>
    </nav>
    <hr>
  </header>

  <main>
    @yield('content')
  </main>
</body>

</html>