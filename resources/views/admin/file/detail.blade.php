@extends('layouts.admin.app')

@section('content')
<div class="content-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
        <!-- Judul konten -->
    </div>
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content" class="content">
            <h4 class="h4 mb-2 text-gray-800 mt-3">
                <a href="{{ route('admin.file.index') }}">File</a> / Isi Konten
            </h4>
            <div class="konten-wrapper">
                <!-- Konten -->
                <h10>{!! $data->konten !!}</h10>

                <!-- Tampilan file -->
                <div class="file-wrapper">
                @if($detailFiles->isNotEmpty())
                        @foreach($detailFiles as $detailFile)
                            <div class="file">
                                @php
                                    $extension = pathinfo($detailFile->file, PATHINFO_EXTENSION);
                                @endphp

                                @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'PNG']))
                                    <img src="{{ asset('public/files/') }}/{{ $detailFile->file }}" alt="Gambar" style="max-width: 50%; max-height: 50%;" class="file-preview">
                                @elseif(in_array(strtolower($extension), ['mp4', 'mov', 'avi'])) <!-- Video -->
                                    <video width="90%" height="500" controls class="file-preview">
                                        <source src="{{ asset('public/files/') }}/{{ $detailFile->file }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @elseif(strtolower($extension) == 'pdf') <!-- PDF -->
                                <iframe src="https://docs.google.com/viewer?url={{ asset('public/files/') }}/{{ $detailFile->file }}&embedded=true" width="100%" height="500px" style="border: none;"></iframe>
                                @elseif(in_array(strtolower($extension), ['mp3', 'wav'])) <!-- Audio -->
                                    <audio controls preload="none" class="file-preview">
                                        <source src="{{ asset('public/files/') }}/{{ $detailFile->file }}" type="audio/mpeg">
                                        Your browser does not support the audio tag.
                                    </audio>
                                @else
                                    <!-- Tipe file tidak didukung -->
                                    <p>Tipe file tidak didukung.</p>
                                @endif
                            </div>
                            <p>{{ $detailFile->file }}</p>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
