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
                    <p class="mt-2" style="font-size: 14pt; ">Edit Cabang</p>
                   
                  </div>
                  <div class="card-body">
                      <form action="/updatecabang/{{$data->id}}" method="post">
                           @csrf
                           <div class="form-group mb-4">
                              <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Kode Cabang</label>
                              <input name="kode_cabang" type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" style="border-color: #01004C;" value="{{ old('kode_cabang', $data->kode_cabang) }}" required  disabled/>
                            <small class="txt-small">Kode cabang tidak dapat diedit</small>
                              <!-- @if ($errors->has('name'))
                                  <p class="text-danger">{{$errors->first('name')}}</p>
                              @endif -->
                          </div>
                     
                           <div class="form-group mb-4">
                               <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Nama Cabang</label>
                               <input name="nama_cabang" type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" style="border-color: #01004C;" value="{{ old('nama_cabang', $data->nama_cabang) }}" required />
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