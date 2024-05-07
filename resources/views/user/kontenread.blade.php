@extends('layouts.user.app')

@section('content')
<div class="content-wrapper">
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content" class="container-fluid">
            <h3 id="judul" class="judul text-center" style="color: black;">{!! $data->nama_file !!}</h3>
            <div id="konten" class="konten" style="color: black;">{!! $data->konten !!}</div>

            <div class="file-wrapper">
                @if($detailFiles->isNotEmpty())
                    @foreach($detailFiles as $detailFile)
                    
                        @php
                            $extension = pathinfo($detailFile->file, PATHINFO_EXTENSION);
                        @endphp

                        @if($detailFile->is_download == 0)
                        <div class="form-group mb-4">
                            @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                <!-- Gambar -->
                                <div class="mt-3" style="position: relative; max-width: 90%; max-height: 500px;">
                                    <img src="{{ asset('public/files/') }}/{{ $detailFile->file }}" style="max-width: 50%; max-height: 100%;" oncontextmenu="return false;">
                                </div>
                            @elseif(in_array(strtolower($extension), ['mp4', 'mov', 'avi']))
                                <!-- Video -->
                                <video class="mt-3" width="90%" height="500" controls controlsList="nodownload" oncontextmenu="return false;">
                                    <source src="{{ asset('public/files/') }}/{{ $detailFile->file }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @elseif(strtolower($extension) == 'pdf')
                                <!-- PDF -->
                                <div class="mt-3" style="position: relative; width: 90%; height: 500px;">
                                    <iframe src="https://docs.google.com/viewer?url={{ asset('public/files/') }}/{{ $detailFile->file }}&embedded=true" width="100%" height="100%" style="border: none;"></iframe>
                                    <div oncontextmenu="return false;" style="position: absolute; top: 0; left: 0; width: 99%; height: 100%; background-color: rgba(255, 255, 255, 0); text-align: center; display: flex; justify-content: center; align-items: center;">
                                        <!-- <p style="color: black;">PDF tidak dapat di download</p> -->
                                    </div>
                                </div>
                            @elseif(in_array(strtolower($extension), ['mp3', 'wav']))
                                <!-- Audio -->
                                <audio class="mt-3" controls preload="none" controlsList="nodownload" oncontextmenu="return false;">
                                    <source src="{{ asset('public/files/') }}/{{ $detailFile->file }}" type="audio/mpeg">
                                    Your browser does not support the audio tag.
                                </audio>
                            @else
                                <!-- Tipe file tidak didukung -->
                                <p>Tipe file tidak didukung.</p>
                            @endif

                          
                                    </div>


                        @elseif ($detailFile->is_download == 1)                      
                        <div class="form-group mb-4">
                            @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                <!-- Gambar -->

                                <div class="mt-3" style="position: relative; max-width: 90%; max-height: 500px;">
                                    <img src="{{ asset('public/files/') }}/{{ $detailFile->file }}" style="max-width: 50%; max-height: 50%;">
                                </div>
                            @elseif(in_array(strtolower($extension), ['mp4', 'mov', 'avi']))
                                <!-- Video -->
                                <video class="mt-3" width="90%" height="500" controls >
                                    <source src="{{ asset('public/files/') }}/{{ $detailFile->file }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @elseif(strtolower($extension) == 'pdf')
                                <!-- PDF -->
                                <br>
                                <div class="mt-3" style="position: relative; width: 90%; height: 500px;">
                                    <iframe src="https://docs.google.com/viewer?url={{ asset('public/files/') }}/{{ $detailFile->file }}&embedded=true" width="100%" height="100%" style="border: none;"></iframe>
                                </div>
                            @elseif(in_array(strtolower($extension), ['mp3', 'wav']))
                                <!-- Audio -->
                                <audio class="mt-3" controls preload="none">
                                    <source src="{{ asset('public/files/') }}/{{ $detailFile->file }}" type="audio/mpeg">
                                    Your browser does not support the audio tag.
                                </audio>
                            @else
                                <!-- Tipe file tidak didukung -->
                                <p>Tipe file tidak didukung.</p>
                            @endif
                                    </div>
                                    <div class="mt-3">
            <a href="{{ asset('public/files/') }}/{{ $detailFile->file }}" class="btn btn-sm btn-primary mb-2" download>Download File</a>
        </div>
                        @endif

                      
                        @if ($detailFile->is_tracking == 1)
                        @if(auth()->user()->isFileRead($detailFile->id))
                        <button class="btn btn-sm " style="background-color:#a9a9a9; color: #ffff;" disabled>Sudah Dibaca</button>
@else

<div class="form-group mt-5 text-left">
                        <button class="btn btn-sm btn-info" onclick="readFile('{{ $detailFile->id }}')">Tandai Sudah Dibaca</button>
</div>
@endif
@endif
                    @endforeach
                @endif
              
            </div>
            
        </div>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    function readFile(detailfileId) {
        $.ajax({
            type: 'POST',
            url: '{{ route("read.file", ["detailfileId" => "__detailfileId__"]) }}'.replace('__detailfileId__', detailfileId),
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                // Reload halaman setelah berhasil menandai file sebagai sudah dibaca
                location.reload();
            },
            error: function(xhr, status, error) {
                // Tangani kesalahan jika terjadi
                console.error(xhr.responseText);
            }
        });
    }
</script>

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


<script>
function readFile(detailfileId) {
        $.ajax({
            type: 'POST',
            url: '/read-file/' + detailfileId,
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                location.reload();
            }
        });
      
    }
</script>
@endsection
