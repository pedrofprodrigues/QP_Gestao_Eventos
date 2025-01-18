@extends('app')

@section('title', 'Edit Info')



@section('content')

<h2>Editing {{$option}}</h2>
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


        <legend>Create</legend>
        <form id="optionNewForm" action="{{ route('newFoodInfo', ['option' => $option]) }}" method="POST">
        @csrf
        <div class="mid">

            <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                    <label for="details">Details</label>
                    <textarea type="text" id="details" name="details" required ></textarea>
                    <label for="price">Price</label>
                    <input type="number" step=".01" id="price" name="price" required >
                    <label for="photo">Photo</label>
                    <input type="text" id="photo" name="photo" required>
                    <button class="button-go" type="submit">Make new</button>
                </div>
                </form>

        </fieldset>

        <br><br>

        <fieldset>
            <legend>Edit</legend>

            @foreach ($completeInfo as $info => $info_detail)
            <fieldset>
                <form id="editFoodForm-{{ $info_detail->id }}" action="{{ route('saveEditFoodInfo', ['option' => $option]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h2>Option {{ $loop->index + 1 }}</h2>
                    <input type="hidden" name="id" value="{{ $info_detail->id }}">

                    <label for="name-{{ $info_detail->id }}">Name</label>
                    <input type="text" id="name-{{ $info_detail->id }}" name="name" required value="{{ $info_detail->name }}">

                    <label for="details-{{ $info_detail->id }}">Details</label>
                    <textarea id="details-{{ $info_detail->id }}" name="details" required>{{ $info_detail->details }}</textarea>

                    <label for="price-{{ $info_detail->id }}">Price</label>
                    <input type="number" step=".01" id="price-{{ $info_detail->id }}" name="price" required value="{{ $info_detail->price }}">

                    <label for="photo-{{ $info_detail->id }}">Photo</label>
                    <input type="file" id="photo-{{ $info_detail->id }}" name="photo" accept="image/*">

                    <div class="form-group">
                        <button class="button-go" type="submit">Save changes</button>
                    </div>
                </form>

                <form action="{{ route('deleteOption', ['option' => $option]) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')

                    <input type="hidden" name="id" value="{{ $info_detail->id }}">

                    <button type="submit" class="button-delete" onclick="return confirm('Are you sure you want to delete {{ $info_detail->name }}?');">Delete</button>
                </form>
            </fieldset>
            @endforeach

        </fieldset>


@endsection