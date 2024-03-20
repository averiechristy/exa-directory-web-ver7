@extends('layouts.user.app')

@section('content')

<div class="content-wrapper">
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content" class="container-fluid">
            <h3 id="judul" class="judul" style="text-align: center; color:black">{!! $data->nama_file !!}</h3>
            <div id="konten" class="konten" style=" color:black">{!! $data->konten !!}</div>
            <div class="file-wrapper">
                    @if($detailFiles->isNotEmpty())
                        @foreach($detailFiles as $detailFile)
                            <div class="file">
                                <p>{{ $detailFile->file }}</p>
                                @php
                                    $extension = pathinfo($detailFile->file, PATHINFO_EXTENSION);
                                @endphp

                                @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) <!-- Gambar -->
                                    <img src="{{ asset('public/files/') }}/{{ $detailFile->file }}" alt="Gambar" class="file-preview">
                                @elseif(in_array($extension, ['mp4', 'mov', 'avi'])) <!-- Video -->
                                    <video width="90%" height="500" controls class="file-preview">
                                        <source src="{{ asset('public/files/') }}/{{ $detailFile->file }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @elseif($extension == 'pdf') <!-- PDF -->
                                    <iframe src="{{ asset('public/files/') }}/{{ $detailFile->file }}" width="90%" height="500px" class="file-preview"></iframe>
                                @elseif(in_array($extension, ['mp3', 'wav'])) <!-- Audio -->
                                    <audio controls preload="none" class="file-preview">
                                        <source src="{{ asset('public/files/') }}/{{ $detailFile->file }}" type="audio/mpeg">
                                        Your browser does not support the audio tag.
                                    </audio>
                                @else
                                    <!-- Tipe file tidak didukung -->
                                    <p>Tipe file tidak didukung.</p>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
        </div>
    </div>
</div>


@endsection
