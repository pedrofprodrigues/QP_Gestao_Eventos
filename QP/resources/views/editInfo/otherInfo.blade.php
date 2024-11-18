@extends('app')

@section('title', 'Edit Info')

@section('content')
<h2>Editing {{$option}}</h2>

<fieldset >

        <legend>Create</legend>
        <form id="optionNewOtherForm" action="{{ route('newOtherInfo', ['option' => $option]) }}" method="POST">
            @csrf
        <div class="mid">

            <label for="name">Name</label>
                    <input type="text" id="option" name="option" required> 
                    <button class="button-go" type="submit">Make new</button>
                </div>
                </form>

        </fieldset>
        <br><br> 
        <fieldset >
            <legend>Edit</legend>

           
        @foreach ($completeInfo as $info => $info_detail)
        <form id="optionSaveOtherForm" action="{{ route('saveEditOtherInfo', ['option' => $option]) }}" method="POST">
            @csrf

        <fieldset >
            
            <h2>Option {{$loop->index +1}}</h2>
            <input type="hidden" id="{{$info_detail->id}}" name="id" required value="{{$info_detail->id}}" > 

            <label for="name">Name</label>
            <input type="text" id="{{$info_detail->option}}" name="option" required value="{{$info_detail->option}}"> 
            <div class="form-group">

            <button class="button-go" type="submit">Save changes</button>
        </form>
            <form action="{{ route('deleteOption', ['option' => $option]) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <input type="hidden" id="{{$info_detail->id}}" name="id" required value="{{$info_detail->id}}" > 
                <button type="submit" class="button-delete" onclick="return confirm('Are you sure you want to delete {{$info_detail->name}}?');">Delete</button>
            </form>
            </div>
        </fieldset>
     
        @endforeach
</fieldset>


@endsection