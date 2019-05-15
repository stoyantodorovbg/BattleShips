@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">Battle Ships</h1>
        <battle-ships :grid="{{ $grid }}"></battle-ships>
    </div>
@endsection
