@extends('layouts.app')

@section('content')
  <div class="container mx-auto py-10 px-4">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Daftar Tugas</h1>
      <a href="{{ route('tasks.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        + Tambah Tugas
      </a>
    </div>

    @if (session('success'))
      <div class="mb-4 text-green-600 font-semibold">
        {{ session('success') }}
      </div>
    @endif

    <div class="overflow-x-auto bg-white rounded shadow">
      <table class="w-full table-auto">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-4 py-3 text-left">Judul</th>
            <th class="px-4 py-3 text-left">Organisasi</th>
            <th class="px-4 py-3 text-left">Batas Waktu</th>
            <th class="px-4 py-3 text-left">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($tasks as $task)
            <tr class="border-b">
              <td class="px-4 py-2">{{ $task->title }}</td>
              <td class="px-4 py-2">{{ $task->organization->name ?? '-' }}</td>
              <td class="px-4 py-2">{{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}</td>
              <td class="px-4 py-2 flex gap-2">
                <a href="{{ route('tasks.show', $task) }}" class="text-blue-600 hover:underline text-sm">Lihat</a>
                <a href="{{ route('tasks.edit', $task) }}" class="text-yellow-600 hover:underline text-sm">Edit</a>
                <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus?')" class="inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="mt-6">
      {{ $tasks->links() }}
    </div>
  </div>
@endsection
