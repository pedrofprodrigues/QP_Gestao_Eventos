@extends('app')

@section('title', 'Edit Info')

@section('content')
<h2>Editing {{$option}}</h2>

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

        <fieldset >
           
            <legend>Edit</legend>

           
            @foreach ($completeInfo as $info => $info_detail)  
            <form id="editFoodForm" action="{{ route('saveEditFoodInfo', ['option' => $option]) }}" method="POST">
                @csrf  
            <fieldset >
                <h2>Option {{$loop->index +1}}</h2>
                        <input type="hidden" id="{{$info_detail->id}}" name="id" required value="{{$info_detail->id}}" > 
                        <label for="name">Name</label>
                        <input type="text" id="{{$info_detail->name}}" name="name" required value="{{$info_detail->name}}"> 
                        <label for="details">Details</label>
                        <textarea type="text" id="{{$info_detail->details}}" name="details" required >{{$info_detail->details}}</textarea>
                        <label for="price">Price</label>
                        <input type="number" step=".01" id="{{$info_detail->price}}" name="price" required value="{{$info_detail->price}}"> 
                        <label for="photo">Photo</label>
                        <input type="text" id="{{$info_detail->photo}}" name="photo" required value="{{$info_detail->photo}}"> 
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