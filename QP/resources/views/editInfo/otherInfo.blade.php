@extends('app')

@section('title', 'Edit Info')

@section('content')
<h2>Editar {{$option}}</h2>

<fieldset >

        <legend>Nova opção</legend>
        <form id="optionNewOtherForm" action="{{ route('newOtherInfo', ['option' => $option]) }}" method="POST">
            @csrf
        <div class="mid">

            <label for="name">Designação</label>
                    <input type="text" id="option" name="option" required>
                    <button class="button-go" type="submit">Gravar</button>
                </div>
                </form>

        </fieldset>
        <br><br>
        <fieldset >
            <legend>Editar</legend>


        @foreach ($completeInfo as $info => $info_detail)
        <form id="optionSaveOtherForm" action="{{ route('saveEditOtherInfo', ['option' => $option]) }}" method="POST">
            @csrf

        <fieldset >

            <h2>Opção {{$loop->index +1}}</h2>
            <input type="hidden" id="{{$info_detail->id}}" name="id" required value="{{$info_detail->id}}" >

            <label for="name">Designação</label>
            <input type="text" id="{{$info_detail->option}}" name="option" required value="{{$info_detail->option}}">
            <div class="form-group">

            <button class="button-go" type="submit">Gravar alterações</button>
        </form>
            <form action="{{ route('deleteOption', ['option' => $option]) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <input type="hidden" id="{{$info_detail->id}}" name="id" required value="{{$info_detail->id}}" >
                <button type="submit" class="button-delete" onclick="return confirm('De certeza que quer eliminar {{$info_detail->option}}?');">Eliminar opção</button>
            </form>
            </div>
        </fieldset>

        @endforeach
</fieldset>


@endsection
