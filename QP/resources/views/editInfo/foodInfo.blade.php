@extends('app')

@section('title', 'Edição Informações')



@section('content')

<h2>Modificar {{$option}}</h2>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<fieldset >


        <legend>Nova opção</legend>
        <form id="optionNewForm" action="{{ route('newFoodInfo', ['option' => $option]) }}" method="POST">
        @csrf
        <div class="mid">

            <label for="name">Nome</label>
                    <input type="text" id="name" name="name" required>
                    <label for="details">Detalhes</label>
                    <textarea type="text" id="details" name="details" required ></textarea>
                    <label for="price">Preço</label>
                    <input type="number" step=".01" id="price" name="price" required >
                    <label for="photo">Foto</label>
                    <input type="text" id="photo" name="photo" required>
                    <button class="button-go" type="submit">Gravar</button>
                </div>
                </form>

        </fieldset>

        <br><br>

        <fieldset>
            <legend>Editar opções</legend>

            @foreach ($completeInfo as $info => $info_detail)
            <fieldset>
                <form id="editFoodForm-{{ $info_detail->id }}" action="{{ route('saveEditFoodInfo', ['option' => $option]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h2>Opção {{ $loop->index + 1 }}</h2>
                    <input type="hidden" name="id" value="{{ $info_detail->id }}">

                    <label for="name-{{ $info_detail->id }}">Nome</label>
                    <input type="text" id="name-{{ $info_detail->id }}" name="name" required value="{{ $info_detail->name }}">

                    <label for="details-{{ $info_detail->id }}">Detalhes</label>
                    <textarea id="details-{{ $info_detail->id }}" name="details" required>{{ $info_detail->details }}</textarea>

                    <label for="price-{{ $info_detail->id }}">Preço</label>
                    <input type="number" step=".01" id="price-{{ $info_detail->id }}" name="price" required value="{{ $info_detail->price }}">

                    <label for="photo-{{ $info_detail->id }}">Foto</label>
                    <input type="file" id="photo-{{ $info_detail->id }}" name="photo" accept="image/*">

                    <label for="galery-{{ $info_detail->id }}">Galeria</label>
                    <input type="file" id="photo-{{ $info_detail->id }}" name="galery" accept="image/*">

                    <div class="form-group">
                        <button class="button-go" type="submit">Gravar alterações</button>
                    </div>
                </form>

                <form action="{{ route('deleteOption', ['option' => $option]) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" value="{{ $info_detail->id }}">
                    <button type="submit" class="button-delete" onclick="return confirm('De certeza que quer eliminar {{ $info_detail->name }}?');">Eliminar opção</button>
                </form>
            </fieldset>
            @endforeach

        </fieldset>


@endsection
