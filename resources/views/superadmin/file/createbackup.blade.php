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
                    <p class="mt-2">Tambah File</p>
                  </div>
                  <div class="card-body">
                      <form action="{{route('superadmin.file.simpan')}}" method="post" enctype="multipart/form-data">
                           @csrf
                           <div class="form-group mb-4">
                               <label for="" class="form-label">Judul</label>
                               <input name="nama_file" type="text" class="form-control {{$errors->has('nama_file') ? 'is-invalid' : ''}}" style="border-color: #01004C;" value="" required />
                               <!-- @if ($errors->has('nama_file'))
                                   <p class="text-danger">{{$errors->first('nama_file')}}</p>
                               @endif -->
                           </div>
                           <div class="form-group mb-4">
  <label for="" class="form-label">Path Folder</label>
      <select id="path_folder"  name="path_folder" class="form-select form-select-sm mb-3" aria-label=".form-select-lg example" style="border-color: #01004C; border-radius: 5px;" required>
            <option selected disabled>Pilih Path</option>
            <!-- Loop melalui data folder dari database -->
            @foreach($folders as $folder)
                <option value="{{ $folder->id }}">{{ $folder->getFolderPath() }}</option>
            @endforeach
        </select>
                              <!-- @if ($errors->has('name'))
                                  <p class="text-danger">{{$errors->first('name')}}</p>
                              @endif -->

                          </div>
                           <div class="form-group mb-4">
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="berlaku">
                              <label class="form-check-label"  style="margin-left: 5px;" for="inlineRadio1">Berlaku</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="tidak_berlaku">
                              <label class="form-check-label"  style="margin-left: 5px;" for="inlineRadio2">Tidak berlaku</label>
                            </div>
                            </div>

                           <div class="form-group mb-4">
                           <div class="form-check">
                              <input class="form-check-input" name="flexCheckIndeterminate" type="checkbox" value="" id="flexCheckIndeterminate">
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

</textarea>        
</div>

    <!-- <div class="mb-3">
    <label for="formFileSm" class="form-label">Upload File</label>
    <input class="form-control form-control-sm" id="formFileSm" type="file" name="formFileSm" accept=".pdf">
    </div> -->
    <div class="mb-3">
    <label for="formFileSm" class="form-label">Upload File / Video / Image / Audio</label>
    <div id="fileInputs">
        <input class="form-control form-control-sm mb-2" type="file" name="formFileSm[]" onchange="previewFile(this)">
    </div>
    <button type="button" class="btn btn-sm btn-primary" id="addFileInput">Add More</button>
</div>



<script>
function previewFile(input) {
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
    
    const existingPreview = input.parentElement.querySelector('.preview');
    if (existingPreview) {
        input.parentElement.removeChild(existingPreview);
    }
    preview.classList.add('preview');
    input.parentElement.appendChild(preview);
}
</script>

  <div class="form-group mb-4">
        <button type="submit" class="btn " style="width:80px; height: 30px; background-color: #01004C; color: white; font-size: 12px;">Save</button>
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

            // Create delete button
            const deleteButton = document.createElement('button');
            deleteButton.setAttribute('type', 'button');
            deleteButton.setAttribute('class', 'btn btn-sm btn-danger delete-file mb-3');
            deleteButton.innerText = 'Remove';

            // Append new input and delete button
            const inputContainer = document.createElement('div');
            inputContainer.appendChild(newInput);
            inputContainer.appendChild(deleteButton);
            fileInputsContainer.appendChild(inputContainer);

            // Add event listener for delete button
            deleteButton.addEventListener('click', function() {
                inputContainer.remove();
            });
        });

        // Optional: Add functionality to remove file inputs
        fileInputsContainer.addEventListener('change', function(event) {
            if (event.target.tagName === 'INPUT' && event.target.getAttribute('type') === 'file') {
                const files = event.target.files;
                if (files.length === 0) {
                    event.target.parentElement.remove();
                }
            }
        });
    });
</script>

@endsection
