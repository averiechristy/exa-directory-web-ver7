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
                    <p class="mt-2">Tambah User</p>
                   
                  </div>
                  <div class="card-body">
                      <form action="#" method="post">
                           <!-- @csrf -->

                           <div class="form-group mb-4">
                              <label for="" class="form-label">Cabang</label>

                              <select class="form-select form-select-sm mb-3" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" required>
                                  <option selected>Pilih Cabang</option>
                                  <option value="1">HO - Head Office</option>
                                  <option value="2">TM - Telemarketing</option>
                                </select>
                              <!-- @if ($errors->has('name'))
                                  <p class="text-danger">{{$errors->first('name')}}</p>
                              @endif -->
                          </div>
<div class="form-group mb-4">
                                          <label for="" class="form-label">Role</label>

                                          <select class="form-select form-select-sm mb-3" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" required>
                                              <option selected>Pilih Role</option>
                                              <option value="1">Super Admin</option>
                                              <option value="2">Admin</option>
                                              <option value="3">User</option>
                                            </select>
                                          <!-- @if ($errors->has('name'))
                                              <p class="text-danger">{{$errors->first('name')}}</p>
                                          @endif -->
                                      </div>


                                      
                           <div class="form-group mb-4">
                              <label for="" class="form-label">No Pegawai</label>
                              <input name="no_pegawai" type="text" class="form-control" style="border-color: #01004C;" value="" required />
                              <!-- @if ($errors->has('name'))
                                  <p class="text-danger">{{$errors->first('name')}}</p>
                              @endif -->
                          </div>

                          <div class="form-group mb-4">
                              <label for="" class="form-label">Nama User</label>
                              <input name="nama" type="text" class="form-control" style="border-color: #01004C;" value="" required />
                              <!-- @if ($errors->has('name'))
                                  <p class="text-danger">{{$errors->first('name')}}</p>
                              @endif -->
                          </div>
                     

                          <div class="form-group mb-4">
                              <label for="" class="form-label">Email</label>
                              <input name="nama" type="email" class="form-control" style="border-color: #01004C;" value="" required />
                              <!-- @if ($errors->has('name'))
                                  <p class="text-danger">{{$errors->first('name')}}</p>
                              @endif -->
                          </div>

                          <div class="form-group mb-4">
                              <label for="" class="form-label">Password</label>
                              <input name="nama" type="email" class="form-control disable" disabled style="border-color: #01004C;" value="12345678" required />
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