@csrf

<!-- Judul -->
<div class="mb-4">
  <label for="title" class="block font-semibold mb-1">Judul Tugas</label>
  <input type="text" name="title" id="title" required class="w-full border rounded px-3 py-2"
    value="{{ old('title', $task->title ?? '') }}">
</div>

<!-- Deskripsi -->
<div class="mb-4">
  <label for="description" class="block font-semibold mb-1">Deskripsi</label>
  <textarea name="description" id="description" rows="4" class="w-full border rounded px-3 py-2">{{ old('description', $task->description ?? '') }}</textarea>
</div>

<!-- Skor -->
<div class="mb-4">
  <label for="score" class="block font-semibold mb-1">Skor</label>
  <input type="number" name="score" id="score" value="{{ old('score', $task->score ?? 10) }}"
    class="w-full border rounded px-3 py-2" min="1">
</div>

<!-- Recurring Checkbox -->
<div class="mb-4">
  <label class="inline-flex items-center gap-2">
    <input type="checkbox" name="is_recurring" id="is_recurring" value="1"
      {{ old('is_recurring', $task->is_recurring ?? false) ? 'checked' : '' }}>
    <span class="text-sm font-medium">Tugas Berulang?</span>
  </label>
</div>

<!-- Tipe Recurring -->
<div class="mb-4" id="recurring_type_wrapper" style="display: none;">
  <label for="recurring_type" class="block font-semibold mb-1">Tipe Perulangan</label>
  <select name="recurring_type" id="recurring_type" class="w-full border rounded px-3 py-2">
    <option value="daily" {{ old('recurring_type', $task->recurring_type ?? '') == 'daily' ? 'selected' : '' }}>Harian
    </option>
    <option value="weekly" {{ old('recurring_type', $task->recurring_type ?? '') == 'weekly' ? 'selected' : '' }}>
      Mingguan</option>
    <option value="monthly" {{ old('recurring_type', $task->recurring_type ?? '') == 'monthly' ? 'selected' : '' }}>
      Bulanan</option>
  </select>
</div>

<!-- Due Date -->
<div class="mb-4" id="due_date_wrapper">
  <label for="due_date" class="block font-semibold mb-1">Batas Waktu</label>
  <input type="date" name="due_date" id="due_date" class="w-full border rounded px-3 py-2"
    value="{{ old('due_date', isset($task->due_date) ? $task->due_date->format('Y-m-d') : '') }}">
</div>

<!-- Submit -->
<div class="flex justify-end">
  <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
    Simpan Tugas
  </button>
</div>

@push('scripts')
  <script>
    const isRecurringCheckbox = document.getElementById('is_recurring');
    const recurringTypeWrapper = document.getElementById('recurring_type_wrapper');
    const dueDateWrapper = document.getElementById('due_date_wrapper');

    function toggleRecurringOptions() {
      if (isRecurringCheckbox.checked) {
        recurringTypeWrapper.style.display = 'block';
        dueDateWrapper.style.display = 'none';
      } else {
        recurringTypeWrapper.style.display = 'none';
        dueDateWrapper.style.display = 'block';
      }
    }

    isRecurringCheckbox.addEventListener('change', toggleRecurringOptions);
    document.addEventListener('DOMContentLoaded', toggleRecurringOptions);
  </script>
@endpush
