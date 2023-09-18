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
                    <p class="mt-2">Tambah Folder</p>
                   
                  </div>
                  <div class="card-body">
                      <form action="#" method="post">
                           <!-- @csrf -->

                           <div class="form-group mb-4">
                              <label for="" class="form-label">Group</label>

                              <select class="form-select form-select-sm mb-3" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" required>
                                  <option selected>Pilih Group</option>
                                  <option value="1">Group A</option>
                                  <option value="2">Group B</option>
                                </select>
                              <!-- @if ($errors->has('name'))
                                  <p class="text-danger">{{$errors->first('name')}}</p>
                              @endif -->
                          </div>
                     
                           <div class="form-group mb-4">
                               <label for="" class="form-label">Nama Folder</label>
                               <input name="nama_cabang" type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" style="border-color: #01004C;" value="" required />
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