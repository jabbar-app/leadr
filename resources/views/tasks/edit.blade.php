@extends('layouts.app')

@section('content')
  <div class="container mx-auto py-10 px-4">
    <h1 class="text-2xl font-bold mb-6">Edit Tugas</h1>
    @include('components.alerts')
    <form action="{{ route('tasks.update', $task) }}" method="POST">
      @method('PUT')
      @include('tasks._form')
    </form>
  </div>
@endsection
