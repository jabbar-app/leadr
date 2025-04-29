<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;


class SubmissionController extends Controller
{
    public function create(Task $task)
    {
        return view('submissions.create', compact('task'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'task_id' => 'required|exists:tasks,id',
                'submission_text' => 'nullable|string',
                'submission_file' => 'nullable|file|max:2048',
            ], [
                'submission_file.max' => 'Ukuran file maksimal 2MB.',
                'submission_file.file' => 'File yang dikirim tidak valid.',
                'submission_file.uploaded' => 'Gagal mengunggah file. Ukuran mungkin terlalu besar.',
                'task_id.required' => 'ID tugas tidak ditemukan.',
                'task_id.exists' => 'Tugas tidak valid.',
            ]);

            $submission = new Submission();
            $submission->user_id = Auth::id();
            $submission->task_id = $request->task_id;
            $submission->submission_text = $request->submission_text;
            $submission->submitted_at = now();
            $submission->status = 'pending';

            // Simpan file jika ada
            if ($request->hasFile('submission_file')) {
                $file = $request->file('submission_file');
                $fileContent = file_get_contents($file->getRealPath());

                if ($fileContent) {
                    $manager = new ImageManager(new GdDriver());
                    $savePath = public_path('submissions');
                    if (!is_dir($savePath)) mkdir($savePath, 0755, true);

                    $fileName = time() . '-' . uniqid() . '.jpg';
                    $manager->read($fileContent)->toJpeg(10)->save($savePath . '/' . $fileName);

                    $submission->submission_file = 'submissions/' . $fileName;
                }
            }

            $submission->save();

            return redirect()->route('dashboard')->with('success', 'Tugas berhasil dikirim.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan submission: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
            ]);

            return back()->withErrors([
                'submit' => 'Terjadi kesalahan saat mengirim tugas.',
                'detail' => $e->getMessage(),
            ])->withInput();
        }
    }

    public function index()
    {
        $submissions = Submission::with(['user', 'task'])->orderBy('submitted_at', 'desc')->get();

        return view('admin.submissions.index', compact('submissions'));
    }

    public function approve(Submission $submission)
    {
        $taskScore = $submission->task->score ?? 10;

        $submission->update([
            'status' => 'approved',
            'score' => $taskScore,
        ]);

        return redirect()->route('admin.submissions.index')->with('success', 'Tugas berhasil disetujui dan dinilai.');
    }

    public function bulkApprove(Request $request)
    {
        $ids = $request->input('selected_submissions', []);
        $scores = $request->input('scores', []);

        foreach ($ids as $id) {
            $submission = Submission::find($id);
            if ($submission && $submission->status === 'pending') {
                $submission->score = $scores[$id] ?? 0;
                $submission->status = 'approved';
                $submission->save();
            }
        }

        return redirect()->route('admin.submissions.index')->with('success', 'Tugas berhasil di-approve!');
    }
}
