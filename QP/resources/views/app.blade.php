<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
   
</head>
<body>
  <button id="menu-toggle">☰</button>

    <nav class="button-container" id="sidebar">
        <a href="{{ route('events.create') }}" class="btn-nav">Novo evento</a>
        <a href="{{ route('events.getAll') }}" class="btn-nav">Lista de eventos</a>
        <a href="{{ route('calendar') }}" class="btn-nav">Calendário</a>
        <a href="{{ route('editTables') }}" class="btn-nav">Editar informações</a>
        <a href="{{ route('events.data_management') }}" class="btn-nav">Dados</a>
    </nav>

    <div class="container" >
        @yield('content')
    </div>
  
  <script>
    document.getElementById('menu-toggle').addEventListener('click', function() {
      document.getElementById('sidebar').classList.toggle('open');
    });
  </script>
</body>
</html>
