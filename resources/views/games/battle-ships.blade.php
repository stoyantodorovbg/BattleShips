@extends('layouts.app')

@section('content')
    <div class="container">
        <battle-ships :grid="{{ $grid }}"></battle-ships>
    </div>
@endsection
