@extends('layouts.approval.app')
@section('content')
<div class="content-wrapper">
          
           
             
          <div class="d-sm-flex align-items-center justify-content-between border-bottom">
           
           
            
          </div>
          <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content" class="content">

            <h4 class="h4 mb-2 text-gray-800 mt-3"><a href="{{ route('approval.dashboard') }}">Konten</a> / Isi Konten</h4>

            <h10>
            {!!$data->konten!!}

            </h10>
          
              <div style="text-align: center;">
            
   


    @if($detailFiles->isNotEmpty())
    @foreach($detailFiles as $detailFile)
        @php
            $extension = pathinfo($detailFile->file, PATHINFO_EXTENSION);
        @endphp

        @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) <!-- Gambar -->
            <img src="{{ asset('storage/files/') }}/{{ $detailFile->file }}" style="max-width: 90%; max-height: 500px;">
        @elseif(in_array($extension, ['mp4', 'mov', 'avi'])) <!-- Video -->
            <video width="90%" height="500" controls>
                <source src="{{ asset('storage/files/') }}/{{ $detailFile->file }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        @elseif($extension == 'pdf') <!-- PDF -->
            <iframe src="{{ asset('storage/files/') }}/{{ $detailFile->file }}" width="90%" height="500px"></iframe>
   
        @elseif(in_array($extension, ['mp3', 'wav'])) <!-- Audio -->
            <audio controls preload="none">
                <source src="{{ asset('storage/files/') }}/{{ $detailFile->file }}" type="audio/mpeg">
                Your browser does not support the audio tag.
            </audio>
        @else
            <!-- Tipe file tidak didukung -->
            <p>Tipe file tidak didukung.</p>
        @endif
    @endforeach
@endif

</div>
            </div>
            </div>


@endsection