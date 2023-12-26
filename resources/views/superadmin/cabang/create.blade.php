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
                    <p class="mt-2" style="font-size: 14pt; ">Tambah Cabang</p>
                   
                  </div>
                  <div class="card-body">
                      <form name ="saveform" action="{{route('superadmin.cabang.simpan')}}" method="post" onsubmit="return validateForm()">
                           @csrf

                           <div class="form-group mb-4">
                              <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Kode Cabang</label>
                              <input name="kode_cabang" type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" style="border-color: #01004C;" value="" />
                              <!-- @if ($errors->has('name'))
                                  <p class="text-danger">{{$errors->first('name')}}</p>
                              @endif -->
                          </div>
                     
                           <div class="form-group mb-4">
                               <label for="" class="form-label"style="font-size: 11pt; font-weight: bold;">Nama Cabang</label>
                               <input name="nama_cabang" type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" style="border-color: #01004C;" value="" />
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

  <script>
function validateForm() {
  let kodecabang = document.forms["saveform"]["kode_cabang"].value;
  let namacabang = document.forms["saveform"]["nama_cabang"].value;

   if (kodecabang == "") {
    alert("Kode cabang tidak boleh kosong");
    return false;
  } else   if (namacabang == "") {
    alert("Nama cabang tidak boleh kosong");
    return false;
  }
}
</script>

  @endsection