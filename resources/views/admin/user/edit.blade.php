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
                      <form action="/updateuser/{{$data->id}}" method="post">
                           @csrf

                           <div class="form-group mb-4">
                              <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;" >Cabang</label>

                              <select  name="cabang_id"  class="form-select form-select-sm mb-3" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" required>
                              <option value="" selected disabled>-- Pilih Akses --</option>
        @foreach ($cabang as $item)
            <option value="{{ $item->id }}" {{ old('cabang_id', $data->cabang_id) == $item->id ? 'selected' : '' }}>
                {{ $item->kode_cabang }}- {{$item->nama_cabang}}
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

                                          <select  name="role_id" class="form-select form-select-sm mb-3" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" required>
                                              <option selected disabled>Pilih Role</option>
                                              @foreach ($role as $item)
            <option value="{{ $item->id }}" {{ old('role_id', $data->role_id) == $item->id ? 'selected' : '' }}>
                {{ $item->nama_role }}
            </option>
        @endforeach
                                            </select>
                                          <!-- @if ($errors->has('name'))
                                              <p class="text-danger">{{$errors->first('name')}}</p>
                                          @endif -->
                                      </div>


                                      
                           <div class="form-group mb-4">
                              <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">No Pegawai</label>
                              <input name="no_pegawai" type="text" class="form-control" style="border-color: #01004C;" value="{{ old('no_pegawai', $data->no_pegawai) }}" required />
                              <!-- @if ($errors->has('name'))
                                  <p class="text-danger">{{$errors->first('name')}}</p>
                              @endif -->
                          </div>

                          <div class="form-group mb-4">
                              <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Nama User</label>
                              <input name="nama_user" type="text" class="form-control" style="border-color: #01004C;" value="{{ old('nama_user', $data->nama_user) }}" required />
                              <!-- @if ($errors->has('name'))
                                  <p class="text-danger">{{$errors->first('name')}}</p>
                              @endif -->
                          </div>
                     

                          <div class="form-group mb-4">
                              <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Email</label>
                              <input name="email" type="email" class="form-control" style="border-color: #01004C;" value="{{ old('email', $data->email) }}" required />
                              <!-- @if ($errors->has('name'))
                                  <p class="text-danger">{{$errors->first('name')}}</p>
                              @endif -->
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