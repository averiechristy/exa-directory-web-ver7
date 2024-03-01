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
                    <form action="/updatefile/{{$data->id}}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-4">
                            <label for="" class="form-label">Path Folder</label>
                            <select id="path_folder" name="path_folder" class="form-select form-select-sm mb-3" aria-label=".form-select-lg example" style="border-color: #01004C; border-radius: 5px;" required>
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
                            <label for="" class="form-label">Nama File</label>
                            <input name="nama_file" type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" style="border-color: #01004C;" value="{{ $data->nama_file }}" required />
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
    <label>Konten</label>
    <div class="form-group">
     <!-- <textarea name="isi_artikel" class="my-editor form-control {{$errors->has('konten') ? 'is-invalid' : ''}}" style="border-color: #01004C;" id="my-editor" cols="30" rows="10" required>{{old('konten')}}</textarea>                                             -->
        <textarea name="konten" class="my-editor form-control {{$errors->has('konten') ? 'is-invalid' : ''}} " id="my-editor"cols="30" rows="10" style="border-color: #01004C;" value="" required oninvalid="this.setCustomValidity('Isi artikel tidak boleh kosong')" oninput="setCustomValidity('')">{{ old('konten') }}
            {{$data->konten}}
        </textarea>                                           
</div>

<!-- <div class="mb-3">
    <label for="formFileSm" class="form-label">Upload File</label>
    <input class="form-control form-control-sm" id="formFileSm" type="file" name="formFileSm" accept=".pdf">
</div> -->

@foreach ($nama as $nama)

<div class="mb-3" >
    <label for="formFileSm" class="form-label"> Upload File / Video / Image / Audio </label>
    <div id="inputt">
        <!-- Preview file yang sudah ada -->
        @php
            $extension = pathinfo($nama->file, PATHINFO_EXTENSION);
        @endphp

        @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) <!-- Gambar -->
            <img src="{{ asset('storage/files/') }}/{{ $nama->file }}" style="max-width: 90%; max-height: 500px;">
        @elseif(in_array($extension, ['mp4', 'mov', 'avi'])) <!-- Video -->
            <video width="90%" height="500" controls>
                <source src="{{ asset('storage/files/') }}/{{ $nama->file }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        @elseif($extension == 'pdf') <!-- PDF -->
            <iframe src="{{ asset('storage/files/') }}/{{ $nama->file }}" width="90%" height="500px"></iframe>
   
        @elseif(in_array($extension, ['mp3', 'wav'])) <!-- Audio -->
            <audio controls preload="none">
                <source src="{{ asset('storage/files/') }}/{{ $nama->file }}" type="audio/mpeg">
                Your browser does not support the audio tag.
            </audio>
        @else
            <!-- Tipe file tidak didukung -->
            <p>Tipe file tidak didukung.</p>
        @endif

        <!-- Input untuk unggah file baru -->
        <input class="form-control form-control-sm mb-2" type="file" name="formFileSm[]">
        <button type="button" class="btn btn-sm btn-danger mb-3" id="removeFileInput"> Remove </button>

</div>
</div>

@endforeach
<div id="fileInputs">

</div>

<script>
    // Fungsi untuk menampilkan preview file saat memilih file
    document.getElementById('formFileSm').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview');
        const fileType = file.type.split('/')[0]; // Mengambil jenis tipe file (image, video, audio)

        // Hapus preview sebelumnya jika ada
        while (preview.firstChild) {
            preview.removeChild(preview.firstChild);
        }

        // Tampilkan preview sesuai dengan jenis tipe file
        if (fileType === 'image') {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.style.maxWidth = '200px';
            img.style.maxHeight = '200px';
            preview.appendChild(img);
        } else if (fileType === 'video') {
            const video = document.createElement('video');
            video.controls = true;
            video.src = URL.createObjectURL(file);
            video.style.maxWidth = '200px';
            video.style.maxHeight = '200px';
            preview.appendChild(video);
        } else if (fileType === 'audio') {
            const audio = document.createElement('audio');
            audio.controls = true;
            audio.src = URL.createObjectURL(file);
            preview.appendChild(audio);
        } else {
            const p = document.createElement('p');
            p.textContent = 'File type not supported for preview.';
            preview.appendChild(p);
        }
    });
</script>

<button type="button" class="btn btn-sm btn-primary mb-3" id="addFileInput">Add More</button>

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
document.addEventListener("DOMContentLoaded", function() {
    const addFileButton = document.getElementById('addFileInput');
    const fileInputsContainer = document.getElementById('fileInputs');

    addFileButton.addEventListener('click', function() {
        const newInput = document.createElement('input');
        newInput.setAttribute('type', 'file');
        newInput.setAttribute('class', 'form-control form-control-sm mb-2');
        newInput.setAttribute('name', 'formFileSm[]');

        // Create remove button for new input
        const removeButton = document.createElement('button');
        removeButton.textContent = 'Remove';
        removeButton.setAttribute('type', 'button');
        removeButton.setAttribute('class', 'btn btn-sm btn-danger mb-2');
        
        removeButton.addEventListener('click', function() {
            fileInputsContainer.removeChild(inputContainer); // Remove the input container when remove button is clicked
        });

        // Append new input and remove button for new input
        const inputContainer = document.createElement('div');
        inputContainer.appendChild(newInput);
        inputContainer.appendChild(removeButton);
        fileInputsContainer.appendChild(inputContainer);

        // Add event listener for file input change
        newInput.addEventListener('change', function() {
            previewFile(newInput, inputContainer);
        });

    });

    // Add event listeners for existing remove buttons
    const removeButtons = document.querySelectorAll('.removeFileInput');
    removeButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const inputContainer = button.parentElement;
            fileInputsContainer.removeChild(inputContainer); // Remove the input container when remove button is clicked
        });
    });

    function previewFile(input, container) {
        const file = input.files[0];
        const preview = document.createElement('div');
        preview.style.marginTop = '10px';
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
        
        preview.classList.add('preview');
        container.appendChild(preview);
    }

    

});


const removeButtons = document.querySelectorAll('.btn-danger'); // Memilih semua tombol "Remove"

removeButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        const inputContainer = button.parentElement; // Dapatkan elemen input yang berisi tombol "Remove"
        inputContainer.remove(); // Hapus elemen input beserta preview-nya
    });
});

</script>

@endsection
