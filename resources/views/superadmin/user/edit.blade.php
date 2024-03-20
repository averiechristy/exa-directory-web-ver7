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
                    <p class="mt-2" style="font-size: 14pt;">Edit User</p>
                   
                  </div>
                  <div class="card-body">
                      <form id="saveform" name="saveform" action="/updateuser/{{$data->id}}" method="post" onsubmit="return validateForm()">
                           @csrf

                           <div class="form-group mb-4">
                              <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;" >Cabang</label>

                              <select  name="cabang_id"  class="form-select form-select-sm mb-3" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" >
                              <option value="" selected disabled>-- Pilih Akses --</option>
        @foreach ($cabang as $item)
            <option value="{{ $item->id }}" {{ old('cabang_id', $data->cabang_id) == $item->id ? 'selected' : '' }}>
                {{ $item->kode_cabang }} - {{$item->nama_cabang}}
            </option>
        @endforeach
    </select>
                                </select>
                              <!-- @if ($errors->has('name'))
                                  <p class="text-danger">{{$errors->first('name')}}</p>
                              @endif -->
                          </div>
<div class="form-group mb-4">
                                          <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Role</label>

                                          <select  name="role_id" class="form-select form-select-sm mb-3" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" >
                                              <option selected disabled>Pilih Role</option>
                                              <!-- @foreach ($role as $item)
            <option value="{{ $item->id }}" {{ old('role_id', $data->role_id) == $item->id ? 'selected' : '' }}>
                {{ $item->nama_role }}
            </option>
        @endforeach -->
                                            </select>
                                          <!-- @if ($errors->has('name'))
                                              <p class="text-danger">{{$errors->first('name')}}</p>
                                          @endif -->
                                      </div>


                                      
                           <div class="form-group mb-4">
                              <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">No Pegawai</label>
                              <input name="no_pegawai" type="text" class="form-control" style="border-color: #01004C;" value="{{ old('no_pegawai', $data->no_pegawai) }}"  />
                              <!-- @if ($errors->has('name'))
                                  <p class="text-danger">{{$errors->first('name')}}</p>
                              @endif -->
                          </div>

                          <div class="form-group mb-4">
                              <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Nama User</label>
                              <input name="nama_user" type="text" class="form-control" style="border-color: #01004C;" value="{{ old('nama_user', $data->nama_user) }}"  />
                              <!-- @if ($errors->has('name'))
                                  <p class="text-danger">{{$errors->first('name')}}</p>
                              @endif -->
                          </div>
                     

                          <div class="form-group mb-4">
                              <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Email</label>
                              <input name="email" type="email" class="form-control" style="border-color: #01004C;" value="{{ old('email', $data->email) }}"  />
                              <!-- @if ($errors->has('name'))
                                  <p class="text-danger">{{$errors->first('name')}}</p>
                              @endif -->
                          </div>
                          
                          <div class="form-group mb-4">
                          <div class="form-check form-switch">
  <input class="form-check-input" type="checkbox" role="switch" name="flexCheckIndeterminate" id="flexCheckIndeterminate"{{ $data->is_approval == 1 ? 'checked' : '' }}>
  <label style=" font-weight: bold; font-size:10pt;">Sebagai Approval</label>
</div>
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
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        let cabangDropdown = document.querySelector('select[name="cabang_id"]');
        let roleDropdown = document.querySelector('select[name="role_id"]');

        // Function to set role options based on the selected cabang
        function setRoleOptions(selectedCabang, oldRoleId) {
            // Clear existing options
            roleDropdown.innerHTML = '';

            // Set options based on the selected cabang
            if (selectedCabang === "1") {
                setRoleOptionsForSuperAdmin(oldRoleId);
            } else {
                setRoleOptionsForAdminAndUser(oldRoleId);
            }
        }

        // Function to set role options for Super Admin
        function setRoleOptionsForSuperAdmin(oldRoleId) {
            addOption(roleDropdown, 'Pilih Role', '', true, true);
            addOption(roleDropdown, 'Super Admin', '1', oldRoleId === '1', false);
            addOption(roleDropdown, 'Admin', '2', oldRoleId === '2', false);
            addOption(roleDropdown, 'User', '3', oldRoleId === '3', false);
        }

        // Function to set role options for Admin and User
        function setRoleOptionsForAdminAndUser(oldRoleId) {
            addOption(roleDropdown, 'Pilih Role', '', true, true);
            addOption(roleDropdown, 'Admin', '2', oldRoleId === '2', false);
            addOption(roleDropdown, 'User', '3', oldRoleId === '3', false);
        }

        cabangDropdown.addEventListener('change', function () {
            let selectedCabang = cabangDropdown.value;

            // Set role options based on the selected cabang
            setRoleOptions(selectedCabang, roleDropdown.value);
        });

        // Initial setup for role options based on the old value of cabang
        let initialSelectedCabang = cabangDropdown.value;
        setRoleOptions(initialSelectedCabang, "{{ old('role_id', $data->role_id) }}");

        // Function to add an option to the dropdown
        function addOption(selectElement, text, value, selected = false, disabled = false) {
            let option = document.createElement('option');
            option.textContent = text;
            option.value = value;
            option.selected = selected;
            option.disabled = disabled;
            selectElement.appendChild(option);
        }
    });

    function validateForm() {
        let nopegawai = document.forms["saveform"]["no_pegawai"].value;
        let nama = document.forms["saveform"]["nama_user"].value;
        let email = document.forms["saveform"]["email"].value;

        if (nopegawai === nama) {
        alert("No Pegawai tidak boleh sama dengan Nama User");
        return false;
    }
    
        if (nopegawai == "") {
            alert("No pegawai tidak boleh kosong");
            return false;
        } else if (nama == "") {
            alert("Nama user tidak boleh kosong");
            return false;
        } else if (email == "") {
            alert("Email tidak boleh kosong");
            return false;
        }
    }
</script>

@endsection


