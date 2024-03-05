@extends('layouts.superadmin.app')
@section('content')

<div class="content-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
    </div>
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content" class="content">
            <div class="card mt-5">

                <div class="card-header">
                    <p class="mt-2">Edit File</p>

                </div>
                <div class="card-body">
                    <form  name="saveform" id ="saveform" action="/updatefile/{{$data->id}}" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="" class="form-label">Judul</label>
                            <input name="nama_file" type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" style="border-color: #01004C;" value="{{ $data->nama_file }}"  />
                        </div>

                        <div class="form-group mb-4">
                            <label for="" class="form-label">Path Folder</label>
                            <select id="path_folder" name="path_folder" class="form-select form-select-sm mb-3" aria-label=".form-select-lg example" style="border-color: #01004C; border-radius: 5px;" >
                                <option disabled>Pilih Path</option>
                                <!-- Loop melalui data folder dari database -->
                                @foreach ($folders as $item)
            <option value="{{ $item->id }}" {{ old('folder_id', $data->folder_id) == $item->id ? 'selected' : '' }}>
            {{ $item->getFolderPath() }}
            </option>
        @endforeach
                            </select>
                        </div>

                      
                        <div class="form-group mb-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="berlaku" {{ $data->status == 'berlaku' ? 'checked' : '' }}>
                                <label class="form-check-label" style="margin-left: 5px;" for="inlineRadio1">Berlaku</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="tidak_berlaku" {{ $data->status == 'tidak_berlaku' ? 'checked' : '' }}>
                                <label class="form-check-label" style="margin-left: 5px;" for="inlineRadio2">Tidak berlaku</label>
                            </div>
                        </div>
                        <div class="form-group mb-4">
    <div class="form-check">
        <input class="form-check-input" name="flexCheckIndeterminate" type="checkbox" value="1" id="flexCheckIndeterminate" {{ $data->is_download == 1 ? 'checked' : '' }}>
        <label class="form-check-label" style="margin-left: 5px;" for="flexCheckIndeterminate">
            Bisa download
        </label>
    </div>
</div>

<div class="form-group mb-4">
    <label>Konnten</label>
    <div class="form-group">
     <!-- <textarea name="isi_artikel" class="my-editor form-control {{$errors->has('konten') ? 'is-invalid' : ''}}" style="border-color: #01004C;" id="my-editor" cols="30" rows="10" required>{{old('konten')}}</textarea>                                             -->
        <textarea name="konten" class="my-editor form-control {{$errors->has('konten') ? 'is-invalid' : ''}} " id="my-editor"cols="30" rows="10" style="border-color: #01004C;" value=""  oninvalid="this.setCustomValidity('Isi artikel tidak boleh kosong')" oninput="setCustomValidity('')">{{ old('konten') }}
            {{$data->konten}}
        </textarea>                                           
</div>

<!-- <div class="mb-3">
    <label for="formFileSm" class="form-label">Upload File</label>
    <input class="form-control form-control-sm" id="formFileSm" type="file" name="formFileSm" accept=".pdf">
</div> -->


@if ($nama->count() > 0)
<div class="upload-container">
@foreach ($nama as $nama)
    <div class="upload-item">
        <div class="form-input-item">
            <label for="formFileSm" class="form-label mt-5">Upload File / Video / Image / Audio</label>
            <div id="fileInputs">
            <input class="upload-input form-control form-control-sm mb-2" type="file" name="formFileSm[]" value="{{ asset('public/files/') }}/{{ $nama->file }}" onchange="previewFile(this)">
            <input type="hidden" name="exisiting_file[]" value="{{ $nama->id }}">



            <div class="preview-container">
                    <!-- Menampilkan pratinjau dari file yang sudah ada -->
        @php
            $extension = pathinfo($nama->file, PATHINFO_EXTENSION);
        @endphp

        @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) <!-- Gambar -->
            <img src="{{ asset('public/files/') }}/{{ $nama->file }}" style="max-width: 90%; max-height: 500px;">
        @elseif(in_array($extension, ['mp4', 'mov', 'avi'])) <!-- Video -->
            <video width="90%" height="500" controls>
                <source src="{{ asset('public/files/') }}/{{ $nama->file }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        @elseif($extension == 'pdf') <!-- PDF -->
            <iframe src="{{ asset('public/files/') }}/{{ $nama->file }}" width="90%" height="500px"></iframe>
   
        @elseif(in_array($extension, ['mp3', 'wav'])) <!-- Audio -->
            <audio controls preload="none">
                <source src="{{ asset('public/files/') }}/{{ $nama->file }}" type="audio/mpeg">
                Your browser does not support the audio tag.
            </audio>
        @else
            <!-- Tipe file tidak didukung -->
            <p>Tipe file tidak didukung.</p>
        @endif
                </div>
            </div>

            <button type="button" class="btn btn-sm btn-danger mb-3 removeFileInput" id="removeFileInput" style="float:right;"> Remove </button>

        </div>
    </div>
@endforeach

</div>
@else
<div class="upload-container">
    <div class="upload-item">

    <div class="form-input-item">
        <label for="formFileSm" class="form-label">Upload File / Video / Image / Audio</label>
        <div id="fileInputs">
            <input class="form-control form-control-sm mb-2" type="file" name="formFileSm[]" onchange="previewFile(this)">
            <div class="preview-container"></div>
        </div>
        <button type="button" class="btn btn-sm btn-danger mb-3" id="removeFileInput" style="float:right;"> Remove </button>
    </div>

</div>

</div>
@endif
<button type="button" class="btn btn-sm btn-primary mb-3 addFileInput" id="addFileInput">Add More</button>

                        <div class="form-group mb-4">
                            <button type="submit" class="btn" style="width:80px; height: 30px; background-color: #01004C; color: white; font-size: 12px;">Save</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function validateForm() {
    var pathFolder = document.getElementById('path_folder').value;
    var namaFile = document.getElementsByName('nama_file')[0].value;

    var inlineRadioOptions = document.forms["saveform"]["inlineRadioOptions"].value;
    // Validasi jika nama file belum diisi
    if (namaFile === "") {
        alert("Judul tidak boleh kosong.");
        return false;
    }
    // Validasi jika path folder belum dipilih
    if (pathFolder === null || pathFolder === "") {
        alert("Mohon pilih path folder.");
        return false;
    }

    if (inlineRadioOptions == null || inlineRadioOptions === '') {
        alert("Pilihan status file harus dipilih");
        return false;
    }

    // Validasi jika konten belum diisi
   

    // Jika semua validasi berhasil, return true
    return true;
}

</script>
<script>

$(document).ready(function () {

// Fungsi untuk menambah insentif
$('#addFileInput').click(function () {
    var insentifContainer = $('.upload-container');
    var newInsentifItem = $('.upload-item').eq(0).clone();

    // Mengosongkan nilai input pada item baru
    newInsentifItem.find('input').val('');

    // Menghapus preview file pada item baru
    newInsentifItem.find('.preview-container').empty(); // Menambah baris ini

    // Menambah item insentif baru ke dalam kontainer
    insentifContainer.append(newInsentifItem);
    
});
 

// Fungsi untuk menghapus insentif
// Fungsi untuk menghapus insentif
$(document).on('click', '#removeFileInput', function () {
    var insentifContainer = $('.upload-container');
    var insentifItems = insentifContainer.find('.upload-item');

    // Memastikan ada lebih dari satu item sebelum menghapus
    if (insentifItems.length > 1) {
        $(this).closest('.upload-item').remove();
    }
    else {
        alert("Anda tidak dapat menghapus form insentif pertama.");
    }
    
    saveProductData();
});




function previewFile(input, previewContainer) {
    const file = input.files[0];
    const preview = document.createElement('div');
    preview.style.marginTop = '10px';

    const maxFileSize = 100 * 1024 * 1024; // 1MB
    if (file.size > maxFileSize) {
        alert("Ukuran file tidak boleh lebih dari 100 MB.");
        input.value = ''; // Menghapus file yang sudah dipilih
        return;
    }
    
    const fileType = file.type.split('/')[0];
    
    if (fileType === 'image') {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.style.maxWidth = '100%';
        img.style.height = 'auto';
        preview.appendChild(img);
    } else if (fileType === 'audio') {
        const audio = document.createElement('audio');
        audio.controls = true;
        audio.src = URL.createObjectURL(file);
        preview.appendChild(audio);
    } else if (fileType === 'video') {
        const video = document.createElement('video');
        video.controls = true;
        video.style.maxWidth = '100%';
        video.style.height = 'auto';
        const source = document.createElement('source');
        source.src = URL.createObjectURL(file);
        source.type = file.type;
        video.appendChild(source);
        preview.appendChild(video);
    } else {
        const fileName = document.createTextNode(file.name);
        preview.appendChild(fileName);
    }
    
    // Menghapus pratinjau yang ada sebelumnya pada kontainer pratinjau
    while (previewContainer.firstChild) {
        previewContainer.removeChild(previewContainer.firstChild);
    }
    
    // Menambahkan pratinjau baru ke dalam kontainer pratinjau
    preview.classList.add('preview-container');
    previewContainer.appendChild(preview);
}

    // Memanggil fungsi previewFile saat ada perubahan pada input file
    $(document).on('change', 'input[type="file"]', function () {
    const previewContainer = $(this).closest('.upload-item').find('.preview-container');
    previewFile(this, previewContainer[0]);
});


});

</script>


@endsection
