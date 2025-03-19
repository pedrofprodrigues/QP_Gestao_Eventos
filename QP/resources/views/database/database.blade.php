@extends('app')


@section('title', 'Novo Evento')


@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<h1>Banco de dados</h1>

@if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

    <fieldset>
        <legend>Exportar todos os eventos</legend>

<div class="mid">
    <a href="{{ route('events.export') }}" 
       style="display: inline-block; padding: 10px 20px; background-color: #4CAF50; 
              color: white; font-size: 16px; text-decoration: none; font-weight: bold; 
              border-radius: 5px; transition: background 0.3s ease;"
       onmouseover="this.style.backgroundColor='#45a049'"
       onmouseout="this.style.backgroundColor='#4CAF50'">
    Download
    </a>
</div>
    </fieldset>
    <fieldset>
        <legend>Importar eventos</legend>

 <form action="{{ route('import.events') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="file">Seleccionar CSV a importar:</label>
                <input type="file" name="file" class="form-control" required>
            </div>
            <br>
           <button class="btn btn-primary ">Importar</button>
        </form>

        
    </fieldset>
@endsection
