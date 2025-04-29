@extends('layouts.app')

@section('content')
  <div class="container mx-auto py-10 px-4">
    <h1 class="text-2xl font-bold mb-6">Edit Tugas</h1>
    @if ($errors->any())
      <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
        <strong>Terjadi kesalahan:</strong>
        <ul class="mt-2 list-disc list-inside text-sm">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('tasks.update', $task) }}" method="POST">
      @method('PUT')
      @include('tasks._form')
    </form>
  </div>
@endsection
