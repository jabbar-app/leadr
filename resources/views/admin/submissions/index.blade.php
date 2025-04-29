@extends('layouts.app')

@section('content')
  <div class="container mx-auto py-10 px-4">
    <h1 class="text-2xl font-bold mb-6">Kelola Submissions</h1>

    @if (session('success'))
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
      </div>
    @endif

    <div class="bg-white p-6 rounded shadow">
      @if ($submissions->isEmpty())
        <p class="text-gray-600">Belum ada submissions.</p>
      @else
        <form action="{{ route('admin.submissions.bulkApprove') }}" method="POST">
          @csrf
          <div class="overflow-x-auto">
            <table class="w-full table-auto text-sm">
              <thead>
                <tr class="bg-gray-100">
                  <th class="px-4 py-2">
                    <input type="checkbox" id="select-all" class="form-checkbox">
                  </th>
                  <th class="px-4 py-2 text-left">Peserta</th>
                  <th class="px-4 py-2 text-left">Tugas</th>
                  <th class="px-4 py-2 text-left">Jawaban</th>
                  <th class="px-4 py-2 text-left">File</th>
                  <th class="px-4 py-2 text-left">Skor</th>
                  <th class="px-4 py-2 text-left">Status</th>
                  <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($submissions as $submission)
                  <tr class="border-t align-top">
                    <td class="px-4 py-2">
                      @if ($submission->status == 'pending')
                        <input type="checkbox" name="selected_submissions[]" value="{{ $submission->id }}"
                          class="form-checkbox">
                      @endif
                    </td>
                    <td class="px-4 py-2">{{ $submission->user->name }}</td>
                    <td class="px-4 py-2">{{ $submission->task->title }}</td>
                    <td class="px-4 py-2 max-w-xs text-gray-700 whitespace-pre-wrap">
                      {!! nl2br(e($submission->submission_text)) !!}
                    </td>
                    <td class="px-4 py-2">
                      @if ($submission->submission_file)
                        @php
                          $ext = pathinfo($submission->submission_file, PATHINFO_EXTENSION);
                        @endphp

                        @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                          <a href="{{ asset($submission->submission_file) }}" target="_blank">
                            <img src="{{ asset($submission->submission_file) }}" alt="Preview"
                              class="h-[50px] rounded shadow hover:opacity-80 transition">
                          </a>
                        @elseif ($ext === 'pdf')
                          <a href="{{ asset($submission->submission_file) }}" target="_blank"
                            class="text-blue-600 underline">Lihat PDF</a>
                        @else
                          <a href="{{ asset($submission->submission_file) }}" target="_blank"
                            class="text-blue-600 underline">Unduh File</a>
                        @endif
                      @else
                        <span class="text-gray-400 italic">-</span>
                      @endif
                    </td>
                    <td class="px-4 py-2">
                      @if ($submission->status === 'pending')
                        <input type="number" name="scores[{{ $submission->id }}]"
                          value="{{ $submission->score ?? ($submission->task->score ?? 0) }}"
                          class="w-16 border rounded px-2 py-1 text-sm">
                      @else
                        <span class="text-green-600 font-semibold">{{ $submission->score }}</span>
                      @endif
                    </td>
                    <td class="px-4 py-2">
                      @if ($submission->status == 'pending')
                        <span class="bg-yellow-400 text-white text-xs px-2 py-1 rounded">Pending</span>
                      @else
                        <span class="bg-green-500 text-white text-xs px-2 py-1 rounded">Approved</span>
                      @endif
                    </td>
                    <td class="px-4 py-2">
                      <form action="{{ route('admin.submissions.destroy', $submission) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus submission ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline text-sm font-semibold">Hapus</button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          {{-- Tombol Bulk Approve --}}
          <div class="mt-6 text-right">
            <button type="submit"
              class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2 rounded">
              Approve Semua yang Dicentang
            </button>
          </div>
        </form>
      @endif
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    document.getElementById('select-all')?.addEventListener('change', function() {
      const checkboxes = document.querySelectorAll('input[name="selected_submissions[]"]');
      checkboxes.forEach(cb => cb.checked = this.checked);
    });
  </script>
@endpush
