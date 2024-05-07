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
                    <p class="mt-2" style="font-size: 14pt;">Edit User</p>
                   
                  </div>
                  <div class="card-body">
                      <form id="saveform" name="saveform" action="/adminupdateuser/{{$data->id}}" method="post" onsubmit="return validateForm()">
                           @csrf

                           <div class="form-group mb-4">
                                          <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Role</label>

                                          <select  name="role_id" class="form-select form-select-sm mb-3" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" required>
                                              <option selected disabled>Pilih Role</option>
                                            
        @foreach ($role as $item)
        @if ($item->nama_role === 'User')
            <option value="{{ $item->id }}" {{ old('role_id', $data->role_id) == $item->id ? 'selected' : '' }}>
                {{ $item->nama_role }}
            </option>
            @endif
        @endforeach
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
  <input class="form-check-input" type="checkbox" role="switch" name="flexCheckIndeterminate" id="flexCheckIndeterminate" {{ $data->is_download == 1 ? 'checked' : '' }}>
  <label style=" font-weight: bold; font-size:10pt;">Sebagai Approver</label>
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


