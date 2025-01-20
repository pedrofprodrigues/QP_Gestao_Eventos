<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
   
</head>
<body>
    <nav class="button-container">
        <a href="{{ route('events.create') }}" class="btn-nav">Novo evento</a>
        <a href="{{ route('events.getAll') }}" class="btn-nav">Lista de eventos</a>
        <a href="{{ route('calendar') }}" class="btn-nav">Calendário</a>
        <a href="{{ route('editTables') }}" class="btn-nav">Editar informações</a>
    </nav>

    <div class="container" >
        @yield('content')
    </div>
  
</body>
</html>
