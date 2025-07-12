@extends('layouts.app')

@section('title', 'My Audiobooks')

@section('content')
<div class="max-w-5xl mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">My Audiobooks</h1>

    <!-- Player Section -->
    <div id="player-section" class="mb-8 hidden">
        <div class="flex items-center gap-6 bg-white rounded-lg shadow p-4">
            <img id="player-cover" src="" alt="Cover" class="w-24 h-24 rounded object-cover border">
            <div class="flex-1">
                <div class="text-xl font-semibold" id="player-title"></div>
                <div class="text-gray-500 mb-2" id="player-author"></div>
                <audio id="audio-player" controls class="w-full">
                    <source id="audio-source" src="" type="audio/mp3">
                    Your browser does not support the audio element.
                </audio>
                <div id="player-tracklist" class="mt-4 flex flex-wrap gap-2"></div>
            </div>
            <a id="player-download" href="#" class="ml-4 px-4 py-2 bg-primary-600 text-white rounded hover:bg-primary-700" download>
                Download
            </a>
        </div>
    </div>

    <!-- Audiobook Library -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($audiobooks as $audiobook)
        @php
            $trialFiles = collect($audiobook->audio_files)->where('trial', true)->values();
            $nonTrialFiles = collect($audiobook->audio_files)->where('trial', '!=', true)->values();
        @endphp
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition group">
            <img src="{{ $audiobook->cover_image ? asset('storage/' . $audiobook->cover_image) : asset('images/default-cover.png') }}" alt="Cover" class="w-full h-48 object-cover rounded-t">
            <div class="p-4">
                <div class="font-semibold text-lg group-hover:text-primary-600">{{ $audiobook->title }}</div>
                <div class="text-gray-500 text-sm mb-2">{{ $audiobook->author }}</div>
                @if($trialFiles->count())
                    <div class="mb-2">
                        <span class="text-xs text-primary-600 font-semibold">Try:</span>
                        @foreach($trialFiles as $file)
                            <button class="ml-1 px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium" onclick="event.stopPropagation(); playTrialAudioBook(@json([
                                'title' => $audiobook->title . ' (Trial: ' . ($file['title'] ?? 'Sample') . ')',
                                'author' => $audiobook->author,
                                'cover' => $audiobook->cover_image ? asset('storage/' . $audiobook->cover_image) : asset('images/default-cover.png'),
                                'file' => route('audiobooks.trial.stream', ['audiobook' => $audiobook, 'file' => $file['file']]),
                            ]));">{{ $file['title'] ?? 'Sample' }}</button>
                        @endforeach
                    </div>
                @endif
                @if($nonTrialFiles->count())
                    <button class="px-3 py-1 bg-primary-600 text-white rounded hover:bg-primary-700 text-sm w-full mt-2" onclick="playAudioBook(@json([
                        'title' => $audiobook->title,
                        'author' => $audiobook->author,
                        'cover' => $audiobook->cover_image ? asset('storage/' . $audiobook->cover_image) : asset('images/default-cover.png'),
                        'files' => $nonTrialFiles->map(function($file) use ($audiobook) {
                            return [
                                'title' => $file['title'] ?? 'Track',
                                'file' => route('user.audiobooks.stream', ['audiobook' => $audiobook, 'file' => $file['file']]),
                                'download' => route('user.audiobooks.download', ['audiobook' => $audiobook, 'file' => $file['file']]),
                            ];
                        })->values(),
                    ]));">Play Full Book</button>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
@endpush

@push('scripts')
<script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
<script>
    let player = null;
    let currentFiles = [];
    function playAudioBook(data) {
        document.getElementById('player-section').classList.remove('hidden');
        document.getElementById('player-cover').src = data.cover;
        document.getElementById('player-title').textContent = data.title;
        document.getElementById('player-author').textContent = data.author;
        currentFiles = data.files;
        setTrack(0);
        const tracklist = document.getElementById('player-tracklist');
        tracklist.innerHTML = '';
        data.files.forEach((file, idx) => {
            const btn = document.createElement('button');
            btn.textContent = file.title;
            btn.className = 'px-3 py-1 rounded bg-gray-100 hover:bg-primary-600 hover:text-white text-sm font-medium';
            btn.onclick = (e) => { e.stopPropagation(); setTrack(idx); };
            tracklist.appendChild(btn);
        });
        if (!player) {
            player = new Plyr('#audio-player', { controls: ['play', 'progress', 'current-time', 'mute', 'volume', 'download'] });
        }
    }
    function setTrack(idx) {
        const file = currentFiles[idx];
        document.getElementById('audio-source').src = file.file;
        document.getElementById('audio-player').load();
        document.getElementById('player-download').href = file.download;
    }
    function playTrialAudioBook(data) {
        document.getElementById('player-section').classList.remove('hidden');
        document.getElementById('player-cover').src = data.cover;
        document.getElementById('player-title').textContent = data.title;
        document.getElementById('player-author').textContent = data.author;
        document.getElementById('audio-source').src = data.file;
        document.getElementById('audio-player').load();
        document.getElementById('player-download').href = data.file;
        document.getElementById('player-tracklist').innerHTML = '';
        if (!player) {
            player = new Plyr('#audio-player', { controls: ['play', 'progress', 'current-time', 'mute', 'volume', 'download'] });
        }
    }
</script>
@endpush 