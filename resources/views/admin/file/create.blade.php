@extends('layouts.admin.app')
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
                    <form name="saveform" id ="saveform" action="{{route('admin.file.simpan')}}" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                          
                      @csrf

                           <div class="form-group mb-4">
                               <label for="" class="form-label">Judul</label>
                               <input name="nama_file" type="text" class="form-control {{$errors->has('nama_file') ? 'is-invalid' : ''}}" style="border-color: #01004C;" value=""  />
                               <!-- @if ($errors->has('nama_file'))
                                   <p class="text-danger">{{$errors->first('nama_file')}}</p>
                               @endif -->
                           </div>

    <div class="form-group mb-4">
    <label for="" class="form-label">Path Folder</label>
    <select id="path_folder"  name="path_folder" class="form-select form-select-sm mb-3" aria-label=".form-select-lg example" style="border-color: #01004C; border-radius: 5px;" >
            <option selected disabled>Pilih Path</option>
            <!-- Loop melalui data folder dari database -->
            @foreach($folders as $folder)
                <option value="{{ $folder->id }}">{{ $folder->getFolderPath() }}</option>
            @endforeach
    </select>
                              <!-- @if ($errors->has('name'))
                                  <p class="text-danger">{{$errors->first('name')}}</p>
                              @endif                            -->

                          </div>

                           <div class="form-group mb-4">
                           <label for="" class="form-label">Status File</label>
                           <br>
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
    <label for="" class="form-label">Approver</label>
    <select id="user_approval" name="user_approval" class="form-select form-select-sm mb-3" aria-label=".form-select-lg example" style="border-color: #01004C; border-radius: 5px;">
        <option disabled>Pilih Approver</option>
        <!-- Loop melalui data folder dari database -->
        @foreach($user as $user)
            <option value="{{ $user->id }}" {{ $user->id == $loggedInUser->report_to ? 'selected' : '' }}>{{ $user->nama_user }}</option>
        @endforeach
    </select>
</div>


<div class="form-group mb-4">
    <label>Konten</label>
    <div class="form-group">
     <!-- <textarea name="isi_artikel" class="my-editor form-control {{$errors->has('konten') ? 'is-invalid' : ''}}" style="border-color: #01004C;" id="my-editor" cols="30" rows="10" required>{{old('konten')}}</textarea>                                             -->
<textarea name="konten" class="my-editor form-control {{$errors->has('konten') ? 'is-invalid' : ''}} " id="my-editor"cols="30" rows="10" style="border-color: #01004C;" value=""  oninvalid="this.setCustomValidity('Isi artikel tidak boleh kosong')" oninput="setCustomValidity('')">{{ old('konten') }}</textarea>        
</div>

  

<div class ="file-fields" id ="file-fields">

<div class="row upload-container">
    

<div class="col-md-6">
            <div class="form-group mb-2">
                        <label for="formFileSm" class="form-label">Upload File / Video / Image / Audio</label>

        <div id="fileInputs">
            <input class="form-control form-control-sm mb-2" type="file" id="fileInput" name="formFileSm[]" onchange="previewFile(this)">
            <div class="preview-container"></div>
        </div>

            </div>
            </div>

            <div class="col-md-2">
    <div class="form-group mb-4">
        <label for="" class="form-label">Download File</label>
        <br>
        <div class="form-check">
            <input class="form-check-input" name="flexCheckIndeterminate[]" type="checkbox" value="" id="flexCheckIndeterminate" onchange="updateCheckboxValue('flexCheckIndeterminate', 'downloadValue')">
            <label class="form-check-label" style="margin-left: 2px;" for="flexCheckIndeterminate">
                Bisa download
            </label>
            <!-- Hidden input to store checkbox value -->
            <input type ="hidden"  name="downloadValue[]" id="downloadValue" value="0">
        </div>
    </div>
</div>

<div class="col-md-2">
    <div class="form-group mb-4">
        <label for="" class="form-label">Tracking File</label>
        <br>
        <div class="form-check">
            <input class="form-check-input" name="flexCheckIndeterminatetracking[]" type="checkbox" value="" id="flexCheckIndeterminatetracking" onchange="updateCheckboxValue('flexCheckIndeterminatetracking', 'trackingValue')">
            <label class="form-check-label" style="margin-left: 2px;" for="flexCheckIndeterminatetracking">
                Bisa tracking
            </label>
            <!-- Hidden input to store checkbox value -->
            <input type ="hidden"   name="trackingValue[]" id="trackingValue" value="0">
        </div>
    </div>
</div>


<script>
    // Function to update checkbox value
    function updateCheckboxValue(checkboxId, hiddenInputId) {
        var checkbox = document.getElementById(checkboxId);
        var hiddenInput = document.getElementById(hiddenInputId);
        if (checkbox.checked) {
            hiddenInput.value = 1; // Set value to 1 when checked
        } else {
            hiddenInput.value = 0; // Set value to 0 when unchecked
        }
    }
</script>



            <div class="col-md-1">
        <label for="" class="form-label" style="color:black;">Action</label>
        <button type="button" class="btn btn-sm btn-danger" id="removeFileInput" style="float:right;"> Remove </button>
        </div>
    
</div>

</div>




<button type="button" class="btn btn-sm btn-primary mt-4 mb-3" id="addFileInput">Add More</button>

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
function validateForm() {
    // Mendapatkan nilai judul
    let judul = document.forms["saveform"]["nama_file"].value;
var pathFolder = document.forms["saveform"]["path_folder"].value;

    var inlineRadioOptions = document.forms["saveform"]["inlineRadioOptions"].value;

    var approval = document.forms["saveform"]['user_approval'].value;

    var konten = document.forms["saveform"]["konten"].value;
    let fileInput = document.getElementById('fileInput').value;
    
    if (judul == "") {
        alert("Judul tidak boleh kosong");
        return false;
    }

    if (pathFolder === "" || pathFolder === "Pilih Path") {
    alert("Path Folder harus dipilih");
    return false;
    }

    if (inlineRadioOptions == null || inlineRadioOptions === '') {
        alert("Pilihan status file harus dipilih");
        return false;
    }

    if (approval === "" || approval === "Pilih Approval") {
    alert("Approval Line harus dipilih");
    return false;
    }

    if (konten === "" && fileInput === "") {
        alert("Isi konten atau unggah file harus diisi salah satu");
        return false;
    }

    return true;
}
</script>

<script>
    
$(document).ready(function () {

    // Fungsi untuk menambah insentif
    $('#addFileInput').click(function () {
    var fileField = `
    <div class="file-fields">
        <div class="row upload-container">
            <div class="col-md-6">
                <div class="form-group mb-2">
                    <label for="formFileSm" class="form-label">Upload File / Video / Image / Audio</label>
                    <div id="fileInputs">
                        <input class="form-control form-control-sm mb-2" type="file" id="fileInput" name="formFileSm[]" onchange="previewFile(this)">
                        <div class="preview-container"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group mb-4">
                    <label for="" class="form-label">Download File</label>
                    <br>
                    <div class="form-check">
                        <input class="form-check-input" name="flexCheckIndeterminate[]" type="checkbox" value="" id="flexCheckIndeterminate_${$('.file-fields').length}" onchange="updateCheckboxValue('flexCheckIndeterminate_${$('.file-fields').length}', 'downloadValue_${$('.file-fields').length}')">
                        <label class="form-check-label" style="margin-left: 2px;" for="flexCheckIndeterminate_${$('.file-fields').length}">
                            Bisa download
                        </label>
                        <input  type ="hidden" name="downloadValue[]" id="downloadValue_${$('.file-fields').length}" value="0">
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group mb-4">
                    <label for="" class="form-label">Tracking File</label>
                    <br>
                    <div class="form-check">
                        <input class="form-check-input" name="flexCheckIndeterminatetracking[]" type="checkbox" value="" id="flexCheckIndeterminatetracking_${$('.file-fields').length}" onchange="updateCheckboxValue('flexCheckIndeterminatetracking_${$('.file-fields').length}', 'trackingValue_${$('.file-fields').length}')">
                        <label class="form-check-label" style="margin-left: 2px;" for="flexCheckIndeterminatetracking_${$('.file-fields').length}">
                            Bisa tracking
                        </label>
                        <input type ="hidden"  name="trackingValue[]" id="trackingValue_${$('.file-fields').length}" value="0">
                    </div>
                </div>
            </div>
            <div class="col-md-1">
                <label for="" class="form-label" style="color:black;">Action</label>
                <button type="button" class="btn btn-sm btn-danger" id="removeFileInput" style="float:right;"> Remove </button>
            </div>
        </div>
    </div>`;
    $("#file-fields").append(fileField);
});

function updateCheckboxValue(checkboxId, hiddenInputId) {
    var checkbox = document.getElementById(checkboxId);
    var hiddenInput = document.getElementById(hiddenInputId);
    if (checkbox.checked) {
        hiddenInput.value = 1; // Set value to 1 when checked
    } else {
        hiddenInput.value = 0; // Set value to 0 when unchecked
    }
}

// Menggunakan event delegation untuk tombol "Remove"

    // Fungsi untuk menghapus insentif
    $(document).on('click', '#removeFileInput', function () {
        var insentifContainer = $('.file-fields');
        var insentifItems = insentifContainer.find('.upload-container');

        // Memastikan ada lebih dari satu item sebelum menghapus
        if (insentifItems.length > 1) {
            $(this).closest('.upload-container').remove();
        } else {
            alert("Anda tidak dapat menghapus form input file pertama.");
        }
    });

    // Fungsi untuk menampilkan pratinjau file
  // Fungsi untuk menampilkan pratinjau file
// Fungsi untuk menampilkan pratinjau file
function previewFile(input) {
    const file = input.files[0];
    const preview = document.createElement('div');
    preview.style.marginTop = '10px';
    
    // Validasi ukuran file
    const maxFileSize = 100 * 1024 * 1024; // 1MB
    if (file.size > maxFileSize) {
        alert("Ukuran file tidak boleh lebih dari 100 MB.");
        input.value = ''; // Menghapus file yang sudah dipilih
        return;
    }

    
    
    const allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'mov', 'avi', 'pdf', 'mp3', 'wav'];
const fileType = file.name.split('.').pop().toLowerCase(); // Mendapatkan ekstensi file
if (!allowedTypes.includes(fileType)) {
    alert("Tipe file tidak diizinkan. Silakan pilih file dengan tipe: jpg, jpeg, png, gif, mp4, mov, avi, pdf, mp3, atau wav.");
    input.value = ''; // Menghapus file yang sudah dipilih
    return;
}    
if (fileType === 'jpg' || fileType === 'jpeg' || fileType === 'png' || fileType === 'gif') {
    const img = document.createElement('img');
    img.src = URL.createObjectURL(file);
    img.style.maxWidth = '100%';
    img.style.height = 'auto';
    preview.appendChild(img);
} else if (fileType === 'mp3' || fileType === 'wav') {
    const audio = document.createElement('audio');
    audio.controls = true;
    audio.src = URL.createObjectURL(file);
    preview.appendChild(audio);
} else if (fileType === 'mp4' || fileType === 'mov' || fileType === 'avi') {
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

    
    const existingPreview = input.parentElement.querySelector('.preview-container');
    if (existingPreview) {
        input.parentElement.removeChild(existingPreview); // Menghapus pratinjau dari form sebelumnya
    }
    
    preview.classList.add('preview-container'); // Menghapus tanda "." dari ".preview-container"
    input.parentElement.appendChild(preview);
}



    // Memanggil fungsi previewFile saat ada perubahan pada input file
    $(document).on('change', 'input[type="file"]', function () {
        previewFile(this);
    });

    

});
</script>


@endsection
