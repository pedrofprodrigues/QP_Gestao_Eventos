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
        <a href="{{ route('events.create') }}" class="btn-nav">Create event</a>
        <a href="{{ route('events.getAll') }}" class="btn-nav">View events</a>
        <a href="{{ route('calendar') }}" class="btn-nav">Calendar</a>
        <a href="{{ route('editTables') }}" class="btn-nav">Edit info</a>
    </nav>

    <div class="container" >
        @yield('content')
    </div>
  
</body>
</html>
