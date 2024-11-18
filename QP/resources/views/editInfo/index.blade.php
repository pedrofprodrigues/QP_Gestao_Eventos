@extends('app')

@section('title', 'Edit information')

@section('content')
@if(session('success'))
<div class="custom-alert success-alert">
    {{ session('success') }}
    <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
</div>
@endif

<div class="mid">

<fieldset>

        <legend>Food options</legend>
        @foreach($food_options as $option)
            <div class="mid">
                <a class="bt-edit" href="{{ route('editFoodInfo', ['option' => $option]) }}" >{{$option}}</a>
            </div>
        @endforeach

</fieldset>

<fieldset>

    <legend>Other options</legend>
    @foreach($other_options as $option)
        <div class="mid">
            <a class="bt-edit" href="{{ route('editOtherOptionsInfo', ['option' => $option]) }}" >{{$option}}</a>
        </div>
    @endforeach

</fieldset>

</div>
@endsection