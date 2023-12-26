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
                               <label for="" class="form-label">Nama File</label>
                               <input name="nama_file" type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" style="border-color: #01004C;" value="" required />
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
                           
                          <div class="mb-3">
    <label for="formFileSm" class="form-label">Upload File</label>
    <input class="form-control form-control-sm" id="formFileSm" type="file" name="formFileSm" accept=".pdf">
</div>

                           <div class="form-group mb-4">
                               <button type="submit" class="btn " style="width:80px; height: 30px; background-color: #01004C; color: white; font-size: 12px;">Save</button>
                           </div>
                       </form>
                   </div>
                </div>
            </div>

        </div>
      
  </div>

@endsection
