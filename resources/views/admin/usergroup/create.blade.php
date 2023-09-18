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
                    <p class="mt-2">Tambah User Group</p>
                   
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
                              <label for="" class="form-label">Nama Group</label>
                              <input name="kode_cabang" type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" style="border-color: #01004C;" value="" required />
                              <!-- @if ($errors->has('name'))
                                  <p class="text-danger">{{$errors->first('name')}}</p>
                              @endif -->
                          </div>

                          <div class="form-group mb-4">
                              <label for="" class="form-label">Anggota 1</label>
                              <select class="form-select form-select-sm mb-3" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" required>
                                  <option selected>Pilih Anggota</option>
                                  <option value="1">Tono</option>
                                  <option value="2">Anisa</option>
                                </select>
                              <!-- @if ($errors->has('name'))
                                  <p class="text-danger">{{$errors->first('name')}}</p>
                              @endif -->
                              <div class="form-group mb-4 mt-2">
                                  <button type="submit" class="btn btn-sm" style="float: right;background-color:red; color: white; border-radius: 8px;">
                                    
                                           Hapus
                                        
                                      </button>
                              </div>
                          </div>
                     
                         
                          <div class="form-group mb-4">
                              <button type="submit" class="btn btn-sm" style="background-color: #FF9900; color: white; border-radius: 8px;">
                                
                                      <i class="fa fa-plus" style="font-size: 14px;"></i> Tambah Member
                                    
                                  </button>
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