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
<div class="mb-3">
    <label for="formFileSm" class="form-label">Upload File</label>
    <input class="form-control form-control-sm" id="formFileSm" type="file" name="formFileSm" accept=".pdf">
</div>


                        <div class="form-group mb-4">
                            <button type="submit" class="btn" style="width:80px; height: 30px; background-color: #01004C; color: white; font-size: 12px;">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
