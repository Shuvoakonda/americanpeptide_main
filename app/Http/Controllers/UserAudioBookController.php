<?php

namespace App\Http\Controllers;

use App\Models\AudioBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserAudioBookController extends Controller
{
    // Show the user's audiobook library
    public function index()
    {
        $user = Auth::user();
        $audiobooks = $user->audioBooks()->with('products')->get();
        return view('user.audiobooks', compact('audiobooks'));
    }

    // Securely stream an audio file
    public function stream(Request $request, AudioBook $audiobook)
    {
        $user = Auth::user();
        if (!$user->audioBooks->contains($audiobook)) {
            abort(403);
        }
        $file = $request->query('file');
        if (!$file || !self::fileInAudioBook($audiobook, $file)) {
            abort(404);
        }
        $disk = config('filesystems.default', 'public');
        if (!Storage::disk($disk)->exists($file)) {
            abort(404);
        }
        return response()->file(Storage::disk($disk)->path($file));
    }

    // Securely download an audio file
    public function download(Request $request, AudioBook $audiobook)
    {
        $user = Auth::user();
        if (!$user->audioBooks->contains($audiobook)) {
            abort(403);
        }
        $file = $request->query('file');
        if (!$file || !self::fileInAudioBook($audiobook, $file)) {
            abort(404);
        }
        $limit = $audiobook->download_limit ?? config('audiobooks.download_limit'); // per-audiobook or fallback
        $count = $user->getAudioBookDownloadCount($audiobook->id, $file);
        if ($limit !== null && $count >= $limit) {
            return response('Download limit reached for this file.', 429);
        }
        $user->incrementAudioBookDownloadCount($audiobook->id, $file);
        $disk = config('filesystems.default', 'public');
        if (!Storage::disk($disk)->exists($file)) {
            abort(404);
        }
        // Generate expiring signed URL (valid for 5 minutes)
        $url = Storage::disk($disk)->temporaryUrl($file, now()->addMinutes(5));
        return redirect($url);
    }

    // Publicly stream a trial audio file
    public function trialStream(Request $request, AudioBook $audiobook)
    {
        $file = $request->query('file');
        if (!$file || !self::fileInAudioBook($audiobook, $file, true)) {
            abort(404);
        }
        $disk = config('filesystems.default', 'public');
        if (!Storage::disk($disk)->exists($file)) {
            abort(404);
        }
        return response()->file(Storage::disk($disk)->path($file));
    }

    // Helper: check if file is in the audiobook's audio_files JSON
    private static function fileInAudioBook(AudioBook $audiobook, $file, $trialOnly = false)
    {
        foreach ($audiobook->audio_files ?? [] as $track) {
            if (isset($track['file']) && $track['file'] === $file) {
                if ($trialOnly && empty($track['trial'])) continue;
                return true;
            }
        }
        return false;
    }
} 