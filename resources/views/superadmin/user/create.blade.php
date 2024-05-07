@extends('layouts.superadmin.app')
@section('content')
<div class="content-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
    </div>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content" class="content">
            <div class="card mt-5">
                <div class="card-header">
                    <p class="mt-2" style="font-size: 14pt;">Tambah User</p>
                </div>
                <div class="card-body">
                    <form name="saveform" action="{{route('superadmin.user.simpan')}}" method="post" onsubmit="return validateForm()">
                        @csrf

                        @if (auth()->user()->cabang_id == 1)
                        <div class="form-group mb-4">
                            <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Cabang</label>
                            <select name="cabang_id" class="form-select form-select-sm mb-3" aria-label=".form-select-lg example" style="border-color: #01004C; border-radius: 5px;">
                                <option selected disabled>Pilih Cabang</option>
                            @foreach ($cabang as $item)
                                <option value="{{ $item->id }}" {{ old('cabang_id') == $item->id ? 'selected' : '' }}> {{$item->kode_cabang}} - {{ $item->nama_cabang }}</option>
                            @endforeach
                            </select>                            
                        </div>
                        @endif

                        @if (auth()->user()->cabang_id == 1)
                        <div class="form-group mb-4">
                            <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Role</label>
                            <select id="role_id" name="role_id" class="form-select form-select-sm mb-3" aria-label=".form-select-lg example" style="border-color: #01004C; border-radius: 5px;">
                                <option selected disabled>Pilih Role</option>
                                @foreach ($role as $item)
                                <option value="{{ $item->id }}" {{ old('role_id') == $item->id ? 'selected' : '' }}> {{ $item->nama_role }}</option>
                                @endforeach
                            </select>
                        </div>
                        @else
                        
                        <div class="form-group mb-4">
                            <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Role</label>
                            <select id="role_id" name="role_id" class="form-select form-select-sm mb-3" aria-label=".form-select-lg example" style="border-color: #01004C; border-radius: 5px;">
                                <option selected disabled>Pilih Role</option>
                            @foreach ($role as $item)
                                <option value="{{ $item->id }}" {{ old('role_id') == $item->id ? 'selected' : '' }}> {{ $item->nama_role }}</option>
                            @endforeach
                            </select>
                        </div>

                        @endif
                            
                        <div class="form-group mb-4">
                            <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">No Pegawai</label>
                            <input name="no_pegawai" type="text" class="form-control" style="border-color: #01004C;" value="" />
                        </div>

                        <div class="form-group mb-4">
                            <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Nama User</label>
                            <input name="nama_user" type="text" class="form-control" style="border-color: #01004C;" value="" />
                        </div>

                        <div class="form-group mb-4">
                            <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Email</label>
                            <input name="email" type="email" class="form-control" style="border-color: #01004C;" value="" />
                        </div>

                        <div class="form-group mb-4">
                            <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Password</label>
                            <input name="password" type="email" class="form-control disable" disabled style="border-color: #01004C;" value="12345678" />
                        </div>

                        <div id="selectReport" style="display: none;">
                            <div class="form-group mb-4">
                                <label for="" class="form-label">Report To</label>
                                <select id="report_to" name="report_to" class="form-select form-select-sm mb-3" aria-label=".form-select-lg example" style="border-color: #01004C; border-radius: 5px;">
                                    <option selected disabled>Pilih User</option>
                                    @foreach($user as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_user }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div id="selectReportAdmin" style="display: none;">
                            <div class="form-group mb-4">
                                <label for="" class="form-label">Report To</label>
                                <select id="report_to" name="report_to" class="form-select form-select-sm mb-3" aria-label=".form-select-lg example" style="border-color: #01004C; border-radius: 5px;">
                                    <option selected disabled>Pilih User</option>
                                    @foreach($useradmin as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_user }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" name="flexCheckIndeterminate" id="flexCheckIndeterminate">
                                <label style="font-weight: bold; font-size:10pt;">Sebagai Approver</label>
                            </div>
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

<script>
    function validateForm() {
        let cabang = document.forms["saveform"]["cabang_id"].value;
        let role = document.forms["saveform"]["role_id"].value;
        let nopegawai = document.forms["saveform"]["no_pegawai"].value;
        let nama = document.forms["saveform"]["nama_user"].value;
        let email = document.forms["saveform"]["email"].value;
        let password = document.forms["saveform"]["password"].value;
        let report = document.forms["saveform"]["report_to"].value;

        if (cabang === "" || cabang === "Pilih Cabang") {
            alert("Pilih salah satu cabang");
            return false;
        } else if (role === "" || role === "Pilih Role") {
            alert("Pilih salah satu role");
            return false;
        } else if (nopegawai == "") {
            alert("No pegawai tidak boleh kosong");
            return false;
        } else if (nama == "") {
            alert("Nama user tidak boleh kosong");
            return false;
        } else if (email == "") {
            alert("Email tidak boleh kosong");
            return false;
        } else if (password == "") {
            alert("Password tidak boleh kosong");
            return false;
        } else if (nopegawai === nama) {
            alert("No Pegawai tidak boleh sama dengan Nama User");
            return false;
        } 
    }

    document.getElementById("role_id").addEventListener("change", function () {
        var role_id = this.value;
        var userSelectDiv = document.getElementById("selectReport");
        var userSelectDivAdmin = document.getElementById("selectReportAdmin");

        if (role_id == 1 ) {
            userSelectDiv.style.display = "block";
            userSelectDivAdmin.style.display = "none";
        } else if (role_id == 2){
            userSelectDivAdmin.style.display = "block";
            userSelectDiv.style.display = "none";
        } 
         else {
            userSelectDiv.style.display = "none";
            userSelectDivAdmin.style.display = "none";
        }
    });
</script>
@endsection
