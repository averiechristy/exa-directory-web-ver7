@extends('layouts.user.app')
@section('content')

<div>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <div class="container-fluid">
                <h2 id="judul" style="color: black; text-align: center;">{!! $data->nama_file !!}</h2>
                <div id="konten" style="color: black;">{!! $data->konten !!}</div>
                <div style="text-align: center;">
            
   


            @if($detailFiles->isNotEmpty())

            @if($data->is_download == 0)
            @foreach($detailFiles as $detailFile)
            <p>{{$detailFile -> file}}</p>
                @php
                    $extension = pathinfo($detailFile->file, PATHINFO_EXTENSION);
                @endphp
        
                @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) <!-- Gambar -->
                    <div class="mt-3" style="position: relative; max-width: 90%; max-height: 500px;">
                        <img src="{{ asset('storage/files/') }}/{{ $detailFile->file }}" style="max-width: 100%; max-height: 100%;"  oncontextmenu="return false;">
                        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(255, 255, 255, 0.7); text-align: center; display: flex; justify-content: center; align-items: center;">
                            <p style="color: black;">Gambar tidak dapat di-download</p>
                        </div>
                    </div>
                @elseif(in_array($extension, ['mp4', 'mov', 'avi'])) <!-- Video -->
                    <video class="mt-3" width="90%" height="500" controls controlsList="nodownload"  oncontextmenu="return false;">
                        <source src="{{ asset('storage/files/') }}/{{ $detailFile->file }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
              

                    @elseif($extension == 'pdf') <!-- PDF -->
    <div class="mt-3" style="position: relative; width: 90%; height: 500px;">
        <object data="{{ asset('storage/files/') }}/{{ $detailFile->file }}" type="application/pdf" width="100%" height="100%" oncontextmenu="return false;">
            <p>Browser Anda tidak mendukung menampilkan PDF. Silakan <a href="{{ asset('storage/files/') }}/{{ $detailFile->file }}">unduh PDF</a> untuk melihatnya.</p>
        </object>
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 10%; background-color: rgba(255, 255, 255, 0.7); text-align: center; display: flex; justify-content: center; align-items: center;">
            <p style="color: black;">PDF tidak dapat di-download</p>
        </div>
    </div>




                @elseif(in_array($extension, ['mp3', 'wav'])) <!-- Audio -->
                    <audio class="mt-3"controls preload="none" controlsList="nodownload"  oncontextmenu="return false;">
                        <source src="{{ asset('storage/files/') }}/{{ $detailFile->file }}" type="audio/mpeg">
                        Your browser does not support the audio tag.
                    </audio>
                @else
                    <!-- Tipe file tidak didukung -->
                    <p>Tipe file tidak didukung.</p>
                @endif
            @endforeach


@elseif ($data->is_download ==1)
              @foreach($detailFiles as $detailFile)
              <p>{{$detailFile -> file}}</p>
                @php
                    $extension = pathinfo($detailFile->file, PATHINFO_EXTENSION);
                @endphp
        
                @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) <!-- Gambar -->
                    <div class="mt-3" style="position: relative; max-width: 90%; max-height: 500px;">
                        <img src="{{ asset('storage/files/') }}/{{ $detailFile->file }}" style="max-width: 100%; max-height: 100%;">
                        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(255, 255, 255, 0.7); text-align: center; display: flex; justify-content: center; align-items: center;">
                            <p style="color: black;">Gambar tidak dapat di-download</p>
                        </div>
                    </div>
                @elseif(in_array($extension, ['mp4', 'mov', 'avi'])) <!-- Video -->
                    <video class="mt-3" width="90%" height="500" controls >
                        <source src="{{ asset('storage/files/') }}/{{ $detailFile->file }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @elseif($extension == 'pdf') <!-- PDF -->
                    <div class="mt-3"  style="position: relative; width: 90%; height: 500px;">
                        <iframe src="{{ asset('storage/files/') }}/{{ $detailFile->file }}" width="100%" height="100%" style="border: none;"></iframe>
                        
                    </div>
                @elseif(in_array($extension, ['mp3', 'wav'])) <!-- Audio -->
                    <audio class="mt-3"controls preload="none" >
                        <source src="{{ asset('storage/files/') }}/{{ $detailFile->file }}" type="audio/mpeg">
                        Your browser does not support the audio tag.
                    </audio>
                @else
                    <!-- Tipe file tidak didukung -->
                    <p>Tipe file tidak didukung.</p>
                @endif
            @endforeach
            @endif
        @endif
        
        </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Menangani event klik kanan
    document.getElementById("konten").addEventListener('contextmenu', function (e) {
        e.preventDefault(); // Mencegah menu konteks muncul saat klik kanan
    });

    // Menangani event keyboard untuk kombinasi Ctrl+C (untuk mencegah copy menggunakan keyboard)
    document.addEventListener('keydown', function (e) {
        if (e.ctrlKey && (e.key === 'c' || e.key === 'C')) {
            e.preventDefault(); // Mencegah tindakan copy menggunakan kombinasi keyboard Ctrl+C
        }
    });
    
</script>

<script>
    // Menangani event klik kanan
    document.getElementById("judul").addEventListener('contextmenu', function (e) {
        e.preventDefault(); // Mencegah menu konteks muncul saat klik kanan
    });

    // Menangani event keyboard untuk kombinasi Ctrl+C (untuk mencegah copy menggunakan keyboard)
    document.addEventListener('keydown', function (e) {
        if (e.ctrlKey && (e.key === 'c' || e.key === 'C')) {
            e.preventDefault(); // Mencegah tindakan copy menggunakan kombinasi keyboard Ctrl+C
        }
    });

</script>


@endsection
