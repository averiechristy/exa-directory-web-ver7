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
                    <p class="mt-2" style="font-size: 14pt;">Edit User Group</p>
                  </div>
                  <div class="card-body">
                      <form action="/updateusergroup/{{$data->id}}" method="post">
                           @csrf

                           @if (auth()->user()->cabang_id == 1)
                           <div class="form-group mb-4">
                              <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Nama Group</label>
                              <input name="nama_group" type="text" value="{{ old('nama_group', $data->nama_group) }}"class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" style="border-color: #01004C;" value=""  />
                              <!-- @if ($errors->has('name'))
                                  <p class="text-danger">{{$errors->first('name')}}</p>
                              @endif -->
                          </div> 
                          <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Jenis Group</label>

    <div class="form-group mb-4">

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="General" {{ $data->type == 'General' ? 'checked' : '' }} >
        <label class="form-check-label"  style="margin-left: 5px;"  for="inlineRadio1">General</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="Custom"  {{ $data->type == 'Custom' ? 'checked' : '' }} >
        <label class="form-check-label"  style="margin-left: 5px;"  for="inlineRadio2">Custom</label>
    </div>

    </div>

    <div id="custom" style="display:none;">
<label for="" class="form-label"style="font-size: 11pt; font-weight: bold;">Pilih Cabang</label>
<div class="form-group mb-4">
@foreach ($cabang as $key => $item)
    @php
        $disabled = $item->User->isEmpty() ? 'disabled' : '';
        $tooltip = $item->User->isEmpty() ? 'Belum memiliki user pada cabang ini' : '';
    @endphp
    @if ($key % 10 == 0 && $key != 0)
        </div><div class="form-group mb-4">
    @endif
    <div class="form-check" style="display: inline-block; margin-right: 10px;">
        <input class="form-check-input cabang-checkbox-custom-a" name="cabang[]" type="checkbox" value="{{ $item->id }}" id="flexCheckIndeterminate{{ $key }}" {{ $disabled }}>
        <label class="form-check-label" style="margin-left: 5px; {{ $disabled }}" for="flexCheckIndeterminate{{ $key }}" data-toggle="tooltip" data-placement="top" title="{{ $tooltip }}">
            {{ $item->nama_cabang}}
        </label>
    </div>
@endforeach
</div>

    <div class="form-group mb-4">
    <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Anggota</label>
    <div id="member-fields-custom-a">
    <div class="member-container-custom-a">
    <div class="member-item-custom-a">
        <select name ="anggotacustom[]" class="form-select form-select-sm mb-3 member-select-custom-a" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" >
            <option selected disabled>Pilih Anggota</option>
            <!-- @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->nama_user }} - {{$user->no_pegawai}}</option>
            @endforeach -->
        </select>       
        <div class="form-group mb-4 mt-2" style="display:none;">
            <button type="button" class="btn btn-sm remove-member-custom-a mb-3" id="remove-member-custom-a"style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
        </div> 
    </div>
    </div>                  
    </div>

<div class="form-group mb-4">
<button type="button" id="add-member-custom-a" class="btn btn-sm" style="background-color: #FF9900; color: white; border-radius: 8px;">
<i class="fa fa-plus" style="font-size: 14px;"></i> Tambah Anggota
</button>

</div>     

<div class="form-group mb-4">
            <button type="submit" class="btn " style="width:80px; height: 30px; background-color: #01004C; color: white; font-size: 12px;">Save</button>
        </div>

</div>
</div>

<div id="general" style="display:none;">
<label for="" class="form-label"style="font-size: 11pt; font-weight: bold;">Pilih Cabang</label>

<div class="form-group mb-4">
@foreach ($cabang as $key => $item)
    @php
        $disabled = $item->User->isEmpty() ? 'disabled' : '';
        $tooltip = $item->User->isEmpty() ? 'Belum memiliki user pada cabang ini' : '';
    @endphp
    @if ($key % 10 == 0 && $key != 0)
        </div><div class="form-group mb-4">
    @endif
    <div class="form-check" style="display: inline-block; margin-right: 10px;">
        <input class="form-check-input cabang-checkbox-a" name="cabang[]" type="checkbox" value="{{ $item->id }}" id="flexCheckIndeterminate{{ $key }}" {{ $disabled }}>
        <label class="form-check-label" style="margin-left: 5px; {{ $disabled }}" for="flexCheckIndeterminate{{ $key }}" data-toggle="tooltip" data-placement="top" title="{{ $tooltip }}">
            {{ $item->nama_cabang}}
        </label>
    </div>
@endforeach
</div>


<div class="form-group mb-4">
    <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Anggota Dikecualikan</label>
    <div id="member-fields-a">
    <div class="member-container-a">
    <div class="member-item">
        <select name ="anggota[]" class="form-select form-select-sm mb-3 member-select-a" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" >
            <option selected disabled>Pilih Anggota</option>
            <!-- @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->nama_user }} - {{$user->no_pegawai}}</option>
            @endforeach -->                                                                            
        </select>     
        <div class="form-group mb-4 mt-2" style="display:none;">
            <button type="button" class="btn btn-sm remove-member-a mb-3" style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
        </div> 

    </div>
    </div>
                    
    </div>

<div class="form-group mb-4">
    <button type="button" id="add-member-a" class="btn btn-sm" style="background-color: #FF9900; color: white; border-radius: 8px;">
        <i class="fa fa-plus" style="font-size: 14px;"></i> Tambah Anggota
    </button>
</div>    

<div class="form-group mb-4">
            <button type="submit" class="btn " style="width:80px; height: 30px; background-color: #01004C; color: white; font-size: 12px;">Save</button>
        </div>

</div>
</div>

@if($data->type == 'General')

<div id = "generalisi">
<label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Pilih Cabang</label>
<div class="form-group mb-4">
                @foreach ($cabang as $key => $item)
    @php
        $disabled = $item->User->isEmpty() ? 'disabled' : '';
        $tooltip = $item->User->isEmpty() ? 'Belum memiliki user pada cabang ini' : '';
    @endphp
    @if ($key % 10 == 0 && $key != 0)
        </div>
        <div class="form-group mb-4">
    @endif
    <div class="form-check" style="display: inline-block; margin-right: 10px;">
        <input class="form-check-input cabang-checkbox" name="cabang[]" type="checkbox" value="{{ $item->id }}" id="flexCheckIndeterminate{{ $key }}" {{ $disabled }}@if(in_array($item->id, $selectedCabangs)) checked @endif>
        <label class="form-check-label" style="margin-left: 5px; {{ $disabled }}" for="flexCheckIndeterminate{{ $key }}" data-toggle="tooltip" data-placement="top" title="{{ $tooltip }}">
            {{ $item->nama_cabang}}
        </label>
    </div>
@endforeach
            </div>

            <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Anggota yang dikecualikan</label>
            <div id="member-fields">
            <div class="member-container">
                    @foreach ($excludedUsers as $detailData)
                       
                    <div class="member-item">
                            <select name="anggota[]" class="form-select form-select-sm mb-3 member-select" aria-label=".form-select-lg example" style="border-color: #01004C; border-radius: 5px;" >
                                <option selected disabled>Pilih Anggota dikecualikan</option>
        <?php
        $selectedCabang = // Assign the value of $selectedCabang here, for example:
        $selectedCabang = $detailData->cabang_id;
        ?>
                                @foreach ($users as $user)
                                   
                                        @if ($user->cabang_id == $selectedCabang)
                                            <option value="{{ $user->id }}" {{ $detailData->id == $user->id ? 'selected' : '' }}>
                                                {{ $user->nama_user }} | {{ $user->no_pegawai }}
                                            </option>
                                        @endif
                                  
                                @endforeach
                            </select>
                            <div class="form-group mb-4 mt-2">
                                <button type="button" class="btn btn-sm remove-member mb-3" style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
                            </div>
                            </div>
                    @endforeach
             
                        </div>
                        </div>
                        <div class="form-group mb-4">
            <button type="button" id="add-member" class="btn btn-sm" style="background-color: #FF9900; color: white; border-radius: 8px;">
                <i class="fa fa-plus" style="font-size: 14px;"></i> Tambah Anggota
            </button>
        </div>                           
        <div class="form-group mb-4">
            <button type="submit" class="btn " style="width:80px; height: 30px; background-color: #01004C; color: white; font-size: 12px;">Save</button>
        </div>



</div>

@elseif($data->type == 'Custom')

<div id = "customisi">
<label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Pilih Cabang</label>
    <div class="form-group mb-4">
    @foreach ($cabang as $key => $item)
    @php
        $disabled = $item->User->isEmpty() ? 'disabled' : '';
        $tooltip = $item->User->isEmpty() ? 'Belum memiliki user pada cabang ini' : '';
    @endphp
    
    @if ($key % 10 == 0 && $key != 0)
        </div>
        <div class="form-group mb-4">
    @endif

    <div class="form-check" style="display: inline-block; margin-right: 10px;">
        <input class="form-check-input cabang-checkbox-custom" name="cabang[]" type="checkbox" value="{{ $item->id }}" id="flexCheckIndeterminate{{ $key }}" {{ $disabled }}@if(in_array($item->id, $selectedCabangs)) checked @endif>
        <label class="form-check-label" style="margin-left: 5px; {{ $disabled }}" for="flexCheckIndeterminate{{ $key }}" data-toggle="tooltip" data-placement="top" title="{{ $tooltip }}">
            {{ $item->nama_cabang}}
        </label>
    </div>
@endforeach
    </div>

    <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Anggota</label>
    <div id="member-fields-custom">
    <div class="member-container-custom">
        @foreach ($nama as $detailData)
       
            <div class="member-item-custom">
                <select name="anggotacustom[]" class="form-select form-select-sm mb-3 member-select-custom" aria-label=".form-select-lg example" style="border-color: #01004C; border-radius: 5px;" >
                    <option selected disabled>Pilih Anggota</option>
                    @foreach ($users as $user)
                        @foreach ($selectedCabangs as $selectedCabang)
                            @if ($user->cabang_id == $selectedCabang)
                                <option value="{{ $user->id }}" {{ $detailData->user_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->nama_user }} | {{ $user->no_pegawai }}
                                </option>
                            @endif
                        @endforeach
                    @endforeach
                </select>
                <div class="form-group mb-4 mt-2">
                    <button type="button" class="btn btn-sm remove-member-custom mb-3" style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
                </div>
            </div>
          
        @endforeach
        </div>
    </div>

    <div class="form-group mb-4">
    <button type="button" id="add-member-custom" class="btn btn-sm" style="background-color: #FF9900; color: white; border-radius: 8px;">
        <i class="fa fa-plus" style="font-size: 14px;"></i> Tambah Anggota
    </button>
</div>                           
                           <div class="form-group mb-4">
                               <button type="submit" class="btn " style="width:80px; height: 30px; background-color: #01004C; color: white; font-size: 12px;">Save</button>
                           </div>


</div>
@endif

@else

<!-- SELAIN HO SECTION -->

<div class="form-group mb-4">
                              <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Nama Group</label>
                              <input name="nama_group" type="text" value="{{ old('nama_group', $data->nama_group) }}"class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" style="border-color: #01004C;" value=""  />
                              <!-- @if ($errors->has('name'))
                                  <p class="text-danger">{{$errors->first('name')}}</p>
                              @endif -->
                          </div> 
                          <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Jenis Group</label>

    <div class="form-group mb-4">

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="General" {{ $data->type == 'General' ? 'checked' : '' }} >
        <label class="form-check-label"  style="margin-left: 5px;"  for="inlineRadio1">General</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="Custom"  {{ $data->type == 'Custom' ? 'checked' : '' }} >
        <label class="form-check-label"  style="margin-left: 5px;"  for="inlineRadio2">Custom</label>
    </div>

    </div>

    <div id="general" style="display:none;">


<div class="form-group mb-4">
    <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Anggota Dikecualikan</label>
    <div id="member-fields-a">
    <div class="member-container-a">
    <div class="member-item-a">
        <select name ="anggota[]" class="form-select form-select-sm mb-3 member-select-a" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" required>
            <option selected disabled>Pilih Anggota</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->nama_user }} - {{$user->no_pegawai}}</option>
            @endforeach                                                                            
        </select>                                                                                       
        <div class="form-group mb-4 mt-2" style="display:none;">
            <button type="button" class="btn btn-sm remove-member-a mb-3" style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
        </div> 
    </div>
    </div>
                    
    </div>
    <div class="form-group mb-4">
    <button type="button" id="add-member-a" class="btn btn-sm" style="background-color: #FF9900; color: white; border-radius: 8px;">
        <i class="fa fa-plus" style="font-size: 14px;"></i> Tambah Anggota
    </button>
</div>   

<div class="form-group mb-4">
                               <button type="submit" class="btn " style="width:80px; height: 30px; background-color: #01004C; color: white; font-size: 12px;">Save</button>
                           </div>
</div>
</div>

<div id="custom" style="display:none;">
    <div class="form-group mb-4">
    <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Anggota</label>
    <div id="member-fields-custom-a">
    <div class="member-container-custom-a">
    <div class="member-item-custom-a">
        <select name ="anggotacustom[]" class="form-select form-select-sm mb-3 member-select-custom-a" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" required>
            <option selected disabled>Pilih Anggota</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->nama_user }} - {{$user->no_pegawai}}</option>
            @endforeach
        </select>       
        <div class="form-group mb-4 mt-2" style="display:none;">
            <button type="button" class="btn btn-sm remove-member-custom-a mb-3" id="remove-member-custom-a"style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
        </div> 
    </div>
    </div>                  
    </div>

<div class="form-group mb-4">
<button type="button" id="add-member-custom-a" class="btn btn-sm" style="background-color: #FF9900; color: white; border-radius: 8px;">
<i class="fa fa-plus" style="font-size: 14px;"></i> Tambah Anggota
</button>
</div>  

<div class="form-group mb-4">
                               <button type="submit" class="btn " style="width:80px; height: 30px; background-color: #01004C; color: white; font-size: 12px;">Save</button>
                           </div>
</div>
</div>
@if($data->type == 'General')

<div id="generalisi">
        <div class="form-group mb-4">
            <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Anggota yang dikecualikan</label>
            <div id="member-fields">
            <div class="member-container">
             
                    @foreach ($excludedUsers as $detailData)
                   
                        <div class="member-item">
                            <select name="anggota[]" class="form-select form-select-sm mb-3 member-select" aria-label=".form-select-lg example" style="border-color: #01004C; border-radius: 5px;" >
                                <option selected disabled>Pilih Anggota dikecualikan</option>
                                @foreach ($users as $user)          
                <option value="{{ $user->id }}" {{ $detailData->id == $user->id ? 'selected' : '' }}>
                    {{ $user->nama_user }} | {{$user->no_pegawai}}
                </option>
        @endforeach
                            </select>
                            <div class="form-group mb-4 mt-2">
                                <button type="button" class="btn btn-sm remove-member mb-3" style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
                            </div>
                        </div>
                        </div>
                    @endforeach
                    </div>
                        </div>
         

        
        <div class="form-group mb-4">
            <button type="button" id="add-member" class="btn btn-sm" style="background-color: #FF9900; color: white; border-radius: 8px;">
                <i class="fa fa-plus" style="font-size: 14px;"></i> Tambah Anggota
            </button>
        </div>                           
        <div class="form-group mb-4">
            <button type="submit" class="btn " style="width:80px; height: 30px; background-color: #01004C; color: white; font-size: 12px;">Save</button>
        </div>
    </div>

@elseif($data->type == 'Custom')

<div id="customisi">



             
                     <div class="form-group mb-4">
    <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Anggota</label>
    <div id="member-fields-custom">
    <div class="member-container-custom">
        @foreach ($nama as $detailData)
            <div class="member-item-custom">
                <select name="anggotacustom[]" class="form-select form-select-sm mb-3 member-select-custom" aria-label=".form-select-lg example" style="border-color: #01004C; border-radius: 5px;" >
                    <option selected disabled>Pilih Anggota</option>
                    @foreach ($users as $user)          
                <option value="{{ $user->id }}" {{ $detailData->user_id == $user->id ? 'selected' : '' }}>
                    {{ $user->nama_user }} | {{$user->no_pegawai}}
                </option>
        @endforeach
                </select>
                <div class="form-group mb-4 mt-2">
                    <button type="button" class="btn btn-sm remove-member-custom mb-3" style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
                </div>
            </div>
            </div>
        @endforeach
    </div>

    <div class="form-group mb-4">
    <button type="button" id="add-member-custom" class="btn btn-sm" style="background-color: #FF9900; color: white; border-radius: 8px;">
        <i class="fa fa-plus" style="font-size: 14px;"></i> Tambah Anggota
    </button>
</div>                           
                           <div class="form-group mb-4">
                               <button type="submit" class="btn " style="width:80px; height: 30px; background-color: #01004C; color: white; font-size: 12px;">Save</button>
                           </div>

                           </div>

@endif
@endif

                       </form>
                   </div>
                </div>
            </div>
        </div>
  </div>


 @if (auth()->user()->cabang_id == 1)
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<!-- TAMBAHAN GENERAL CUSTOM-->



<!-- END TAMBAHAN -->


<script>

$('form').submit(function(e) {

    var valid = true;
    var selectedMembers = [];
    var selectedMembersCustom = [];

    var selectedMembersA = [];
    var selectedMembersCustomA = [];

    var selectedRadio = $('input[name="inlineRadioOptions"]:checked').val();
    var namaGroup = $('input[name="nama_group"]').val();
    var selectedCabangCount = $('.cabang-checkbox:checked').length; 
    var selectedCabangCountCustom = $('.cabang-checkbox-custom:checked').length; 

    var selectedCabangCountA = $('.cabang-checkbox-a:checked').length; 
    var selectedCabangCountCustomA = $('.cabang-checkbox-custom-a:checked').length; 

    var selectedMemberCount = $('.member-select-custom').filter(function() {
        return $(this).val() != null;
    }).length;
    
    var selectedMemberCountA = $('.member-select-custom-a').filter(function() {
        return $(this).val() != null;
    }).length;
    
    
    if (!namaGroup.trim()) {
        alert('Silakan masukkan nama grup.');
        e.preventDefault(); 
    } else if (!selectedRadio) {
        alert('Anda harus memilih salah satu jenis group.');
        e.preventDefault(); 
    }
    @if (auth()->user()->cabang_id == 1)
    
   else if (selectedRadio === 'General') {

    if (selectedCabangCount === 0 && selectedCabangCountA === 0) {
        alert('Anda harus memilih setidaknya satu cabang.');
        e.preventDefault();
    }

$('.member-select-a').each(function() {
    var selectedMemberA = $(this).val();
    if (selectedMemberA) {
        if (selectedMembersA.includes(selectedMemberA)) {
            valid = false;
            alert("Anggota yang sama tidak boleh dipilih lebih dari satu kali.");
            return false;
        } else {
            selectedMembersA.push(selectedMemberA);
        }
    }
});


} else if (selectedRadio === 'Custom') {
    
    if (selectedCabangCountCustom === 0 && selectedCabangCountCustomA === 0) {
        alert('Anda harus memilih setidaknya satu cabang.');
        e.preventDefault();
    }

    else if(selectedMemberCountA === 0 && selectedMemberCount === 0){
        alert('Anda harus memilih setidaknya satu anggota untuk jenis grup custom.');
        e.preventDefault(); 
    }

    $('.member-select-custom-a').each(function() {
var selectedMember = $(this).val();
if (selectedMember) {
    if (selectedMembersCustomA.includes(selectedMember)) {
        valid = false;
        alert("Anggota yang sama tidak boleh dipilih lebih dari satu kali.");
        return false;
    } else {
        selectedMembersCustomA.push(selectedMember);
    }
}
});

}
    @endif


    

$('.member-select').each(function() {
    var selectedMember = $(this).val();
    if (selectedMember) {
        if (selectedMembers.includes(selectedMember)) {
            valid = false;
            alert("Anggota yang sama tidak boleh dipilih lebih dari satu kali.");
            return false;
        } else {
            selectedMembers.push(selectedMember);
        }
    }
});





$('.member-select-custom').each(function() {
var selectedMember = $(this).val();
if (selectedMember) {
    if (selectedMembers.includes(selectedMember)) {
        valid = false;
        alert("Anggota yang sama tidak boleh dipilih lebih dari satu kali.");
        return false;
    } else {
        selectedMembers.push(selectedMember);
    }
}
});




    return valid;
});



</script>

<script>
        $(document).ready(function() {

            var selectedMembers = [];
$(document).on('change', '.member-select', function() {
    var selectedMemberId = $(this).val();

    


        // Jika ID anggota belum ada dalam daftar, tambahkan ke daftar
        selectedMembers.push(selectedMemberId);
    
    
});


            $('.cabang-checkbox').change(function() {
    // Mendapatkan nilai checkbox yang di-check
    var selectedCabang = $('.cabang-checkbox:checked').map(function() {
        return $(this).val();
    }).get();

    $.ajax({
        url: '{{ route("superadmin.usergroup.getAnggotaByCabang") }}',
        type: 'post',
        data: {
            _token: '{{ csrf_token() }}',
            cabang: selectedCabang
        },
        success: function(data) {
            // Mengganti opsi pada semua select anggota
            $('.member-select').each(function() {
                var selectedValue = $(this).val(); // Simpan nilai yang sudah dipilih sebelumnya
                $(this).empty(); // Menghapus opsi sebelumnya

                // Menambah opsi baru
                $(this).append('<option selected disabled> Pilih Anggota </option>');
                $.each(data, function(index, value) {
    // Buat opsi baru
    var option = $('<option></option>').attr('value', value.id).text(value.nama_user + ' | ' + value.no_pegawai);

    // Cek apakah nilai yang sudah dipilih sebelumnya tersedia
    if (selectedValue && selectedValue == value.id) {
        // Atur opsi sebagai terpilih jika nilainya cocok
        option.prop('selected', true);
    }

    // Tambahkan opsi ke dropdown
    $(this).append(option);
}.bind(this));

                // Pilih kembali anggota yang dipilih sebelumnya, jika masih tersedia dalam opsi baru
                if (selectedMembers.includes(selectedValue)) {
                    $(this).val(selectedValue);
                }
            });
        }
    });
});



    $("#add-member").click(function() {
    var memberField = `
    <div class="member-container">
        <div class="member-item">
            <select name="anggota[]" class="form-select form-select-sm mb-3 member-select" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" >
                <option selected disabled>Pilih Anggota</option>
            </select>
            <div class="form-group mb-4 mt-2" style="display:none;">
                <button type="button" class="btn btn-sm remove-member mb-3" style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
            </div> 
            <div class="form-group mb-4 mt-2">
                <button type="button" class="btn btn-sm remove-member mb-3" style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
            </div> 
        </div>
    </div>`;

    $("#member-fields").append(memberField);
    var cabangId = $('.cabang-checkbox:checked').map(function() {
        return $(this).val();
    }).get();

    updateAnggotaByCabang(cabangId, $("#member-fields").find('.member-container').last());
});

function updateAnggotaByCabang(cabangId, memberField) {
    // Ajax request untuk mendapatkan anggota berdasarkan cabang yang dipilih
    $.ajax({
        url: '{{ route("superadmin.usergroup.getAnggotaByCabang") }}',
        type: 'post',
        data: {
            _token: '{{ csrf_token() }}',
            cabang: cabangId
        },
        success: function(data) {
            // Mengganti opsi pada dropdown anggota pada memberField terakhir
            var selectElement = memberField.find('.member-select');
            selectElement.empty();
            selectElement.append('<option value="" disabled selected>Pilih Anggota</option>');
            $.each(data, function(index, value) {
                selectElement.append('<option value="' + value.id + '">' + value.nama_user + ' - ' + value.no_pegawai + '</option>');
            });
        }
    });
}


$(document).on("click", ".remove-member", function() {
        $(this).closest(".member-item").remove();
    });


});
</script>

<script>
        $(document).ready(function() {


            var selectedMemberscustom = [];
            $(document).on('change', '.member-select-custom', function() {
    var selectedMemberIdcustom = $(this).val();

    // Periksa apakah ID anggota sudah ada dalam daftar yang dipilih sebelumnya
    
        // Jika ID anggota belum ada dalam daftar, tambahkan ke daftar
        selectedMemberscustom.push(selectedMemberIdcustom);
    
    
});
            
$('.cabang-checkbox-custom').change(function() {
    // Mendapatkan nilai checkbox yang di-check
    var selectedCabangcustom = $('.cabang-checkbox-custom:checked').map(function() {
        return $(this).val();
    }).get();

    $.ajax({
        url: '{{ route("superadmin.usergroup.getAnggotaByCabang") }}',
        type: 'post',
        data: {
            _token: '{{ csrf_token() }}',
            cabang: selectedCabangcustom
        },
        success: function(data) {
            // Mengganti opsi pada semua select anggota
            $('.member-select-custom').each(function() {
                var selectedValue = $(this).val(); // Simpan nilai yang sudah dipilih sebelumnya
                $(this).empty(); // Menghapus opsi sebelumnya

                // Menambah opsi baru
                $(this).append('<option selected disabled> Pilih Anggota </option>');
                $.each(data, function(index, value) {
    // Buat opsi baru
    var option = $('<option></option>').attr('value', value.id).text(value.nama_user + ' | ' + value.no_pegawai);

    // Cek apakah nilai yang sudah dipilih sebelumnya tersedia
    if (selectedValue && selectedValue == value.id) {
        // Atur opsi sebagai terpilih jika nilainya cocok
        option.prop('selected', true);
    }

    // Tambahkan opsi ke dropdown
    $(this).append(option);
}.bind(this));

                // Pilih kembali anggota yang dipilih sebelumnya, jika masih tersedia dalam opsi baru
                if (selectedMemberscustom.includes(selectedValue)) {
                    $(this).val(selectedValue);
                }
            });
        }
    });
});


    $("#add-member-custom").click(function() {
    var memberFieldcustom = `
    <div class="member-container-custom">
        <div class="member-item-custom">
            <select name="anggotacustom[]" class="form-select form-select-sm mb-3 member-select-custom" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" >
                <option selected disabled>Pilih Anggota</option>
            </select>
            <div class="form-group mb-4 mt-2" style="display:none;">
                <button type="button" class="btn btn-sm remove-member-custom mb-3" style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
            </div> 
            <div class="form-group mb-4 mt-2">
                <button type="button" class="btn btn-sm remove-member-custom mb-3" style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
            </div> 
        </div>
    </div>`;

    $("#member-fields-custom").append(memberFieldcustom);
    var cabangId = $('.cabang-checkbox-custom:checked').map(function() {
        return $(this).val();
    }).get();

    updateAnggotaByCabang(cabangId, $("#member-fields-custom").find('.member-container-custom').last());
});

function updateAnggotaByCabang(cabangId, memberFieldcustom) {
    // Ajax request untuk mendapatkan anggota berdasarkan cabang yang dipilih
    $.ajax({
        url: '{{ route("superadmin.usergroup.getAnggotaByCabang") }}',
        type: 'post',
        data: {
            _token: '{{ csrf_token() }}',
            cabang: cabangId
        },
        success: function(data) {
            // Mengganti opsi pada dropdown anggota pada memberFieldcustom terakhir
            var selectElement = memberFieldcustom.find('.member-select-custom');
            selectElement.empty();
            selectElement.append('<option value="" disabled selected>Pilih Anggota</option>');
            $.each(data, function(index, value) {
                selectElement.append('<option value="' + value.id + '">' + value.nama_user + ' - ' + value.no_pegawai + '</option>');
            });
        }
    });
}


$(document).on("click", ".remove-member-custom", function() {

        $(this).closest(".member-item-custom").remove();

});

});
</script>

<!-- TAMBAHAN CUSTOM -->

<script>
        $(document).ready(function() {


            var selectedMemberscustom = [];
            $(document).on('change', '.member-select-custom-a', function() {
    var selectedMemberIdcustom = $(this).val();

    // Periksa apakah ID anggota sudah ada dalam daftar yang dipilih sebelumnya
    
        // Jika ID anggota belum ada dalam daftar, tambahkan ke daftar
        selectedMemberscustom.push(selectedMemberIdcustom);
    
    
});
            
$('.cabang-checkbox-custom-a').change(function() {
    // Mendapatkan nilai checkbox yang di-check
    var selectedCabangcustom = $('.cabang-checkbox-custom-a:checked').map(function() {
        return $(this).val();
    }).get();

    $.ajax({
        url: '{{ route("superadmin.usergroup.getAnggotaByCabang") }}',
        type: 'post',
        data: {
            _token: '{{ csrf_token() }}',
            cabang: selectedCabangcustom
        },
        success: function(data) {
            // Mengganti opsi pada semua select anggota
            $('.member-select-custom-a').each(function() {
                var selectedValue = $(this).val(); // Simpan nilai yang sudah dipilih sebelumnya
                $(this).empty(); // Menghapus opsi sebelumnya

                // Menambah opsi baru
                $(this).append('<option selected disabled> Pilih Anggota </option>');
                $.each(data, function(index, value) {
    // Buat opsi baru
    var option = $('<option></option>').attr('value', value.id).text(value.nama_user + ' | ' + value.no_pegawai);

    // Cek apakah nilai yang sudah dipilih sebelumnya tersedia
    if (selectedValue && selectedValue == value.id) {
        // Atur opsi sebagai terpilih jika nilainya cocok
        option.prop('selected', true);
    }

    // Tambahkan opsi ke dropdown
    $(this).append(option);
}.bind(this));

                // Pilih kembali anggota yang dipilih sebelumnya, jika masih tersedia dalam opsi baru
                if (selectedMemberscustom.includes(selectedValue)) {
                    $(this).val(selectedValue);
                }
            });
        }
    });
});


    $("#add-member-custom-a").click(function() {
    var memberFieldcustom = `
    <div class="member-container-custom-a">
        <div class="member-item-custom-a">
            <select name="anggotacustom[]" class="form-select form-select-sm mb-3 member-select-custom-a" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" >
                <option selected disabled>Pilih Anggota</option>
            </select>
            <div class="form-group mb-4 mt-2" style="display:none;">
                <button type="button" class="btn btn-sm remove-member-custom-a mb-3" style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
            </div> 
            <div class="form-group mb-4 mt-2">
                <button type="button" class="btn btn-sm remove-member-custom-a mb-3" style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
            </div> 
        </div>
    </div>`;

    $("#member-fields-custom-a").append(memberFieldcustom);
    var cabangId = $('.cabang-checkbox-custom-a:checked').map(function() {
        return $(this).val();
    }).get();

    updateAnggotaByCabang(cabangId, $("#member-fields-custom-a").find('.member-container-custom-a').last());
});

function updateAnggotaByCabang(cabangId, memberFieldcustom) {
    // Ajax request untuk mendapatkan anggota berdasarkan cabang yang dipilih
    $.ajax({
        url: '{{ route("superadmin.usergroup.getAnggotaByCabang") }}',
        type: 'post',
        data: {
            _token: '{{ csrf_token() }}',
            cabang: cabangId
        },
        success: function(data) {
            // Mengganti opsi pada dropdown anggota pada memberFieldcustom terakhir
            var selectElement = memberFieldcustom.find('.member-select-custom-a');
            selectElement.empty();
            selectElement.append('<option value="" disabled selected>Pilih Anggota</option>');
            $.each(data, function(index, value) {
                selectElement.append('<option value="' + value.id + '">' + value.nama_user + ' - ' + value.no_pegawai + '</option>');
            });
        }
    });
}


$(document).on("click", ".remove-member-custom-a", function() {

        $(this).closest(".member-item-custom-a").remove();

});

});
</script>

<script>
$(document).ready(function() {
    // Fungsi untuk menampilkan atau menyembunyikan form sesuai dengan radio button yang dipilih
    $('input[name="inlineRadioOptions"]').change(function() {
        var value = $(this).val();
        
        // Menampilkan konfirmasi alert
        var confirmation = window.confirm("Jika anda merubah jenis group, maka daftar anggota tersimpan akan hilang, apakah anda yakin?");

        // Jika pengguna mengklik "OK", tampilkan tampilan berdasarkan nilai yang dipilih
        if (confirmation) {
            if (value === 'General') {
                $('#general').show();
                $('#custom').hide();
                $('#customisi').remove();
            } else if (value === 'Custom') {
                $('#general').hide();
                $('#generalisi').remove();
                $('#custom').show();
            }
        } else {
            // Jika pengguna mengklik "Batal", atur pilihan radio button berdasarkan $data->type
            var radioValue = '{{ $data->type }}'; // Mendapatkan nilai dari $data->type
            $('input[name="inlineRadioOptions"][value="' + radioValue + '"]').prop('checked', true);
        }
    });
});
</script>


<!-- TAMBAHAN GENERAL -->
<script>
        $(document).ready(function() {

            var selectedMembers = [];
$(document).on('change', '.member-select-a', function() {
    var selectedMemberId = $(this).val();

    


        // Jika ID anggota belum ada dalam daftar, tambahkan ke daftar
        selectedMembers.push(selectedMemberId);
    
    
});


            $('.cabang-checkbox-a').change(function() {
    // Mendapatkan nilai checkbox yang di-check
    var selectedCabang = $('.cabang-checkbox-a:checked').map(function() {
        return $(this).val();
    }).get();

    $.ajax({
        url: '{{ route("superadmin.usergroup.getAnggotaByCabang") }}',
        type: 'post',
        data: {
            _token: '{{ csrf_token() }}',
            cabang: selectedCabang
        },
        success: function(data) {
            // Mengganti opsi pada semua select anggota
            $('.member-select-a').each(function() {
                var selectedValue = $(this).val(); // Simpan nilai yang sudah dipilih sebelumnya
                $(this).empty(); // Menghapus opsi sebelumnya

                // Menambah opsi baru
                $(this).append('<option selected disabled> Pilih Anggota </option>');
                $.each(data, function(index, value) {
    // Buat opsi baru
    var option = $('<option></option>').attr('value', value.id).text(value.nama_user + ' | ' + value.no_pegawai);

    // Cek apakah nilai yang sudah dipilih sebelumnya tersedia
    if (selectedValue && selectedValue == value.id) {
        // Atur opsi sebagai terpilih jika nilainya cocok
        option.prop('selected', true);
    }

    // Tambahkan opsi ke dropdown
    $(this).append(option);
}.bind(this));

                // Pilih kembali anggota yang dipilih sebelumnya, jika masih tersedia dalam opsi baru
                if (selectedMembers.includes(selectedValue)) {
                    $(this).val(selectedValue);
                }
            });
        }
    });
});



    $("#add-member-a").click(function() {
    var memberField = `
    <div class="member-container-a">
        <div class="member-item-a">
            <select name="anggota[]" class="form-select form-select-sm mb-3 member-select-a" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" >
                <option selected disabled>Pilih Anggota</option>
            </select>
            <div class="form-group mb-4 mt-2" style="display:none;">
                <button type="button" class="btn btn-sm remove-member-a mb-3" style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
            </div> 
            <div class="form-group mb-4 mt-2">
                <button type="button" class="btn btn-sm remove-member-a mb-3" style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
            </div> 
        </div>
    </div>`;

    $("#member-fields-a").append(memberField);
    var cabangId = $('.cabang-checkbox-a:checked').map(function() {
        return $(this).val();
    }).get();

    updateAnggotaByCabang(cabangId, $("#member-fields-a").find('.member-container-a').last());
});

function updateAnggotaByCabang(cabangId, memberField) {
    // Ajax request untuk mendapatkan anggota berdasarkan cabang yang dipilih
    $.ajax({
        url: '{{ route("superadmin.usergroup.getAnggotaByCabang") }}',
        type: 'post',
        data: {
            _token: '{{ csrf_token() }}',
            cabang: cabangId
        },
        success: function(data) {
            // Mengganti opsi pada dropdown anggota pada memberField terakhir
            var selectElement = memberField.find('.member-select-a');
            selectElement.empty();
            selectElement.append('<option value="" disabled selected>Pilih Anggota</option>');
            $.each(data, function(index, value) {
                selectElement.append('<option value="' + value.id + '">' + value.nama_user + ' - ' + value.no_pegawai + '</option>');
            });
        }
    });
}


$(document).on("click", ".remove-member-a", function() {
        $(this).closest(".member-item-a").remove();
    });


});
</script>
@else
<!-- SELAIN HO SCRIPT SECTION -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

$('form').submit(function(e) {
    var valid = true;
    var selectedMembers = [];
    var selectedMembersCustom = [];

    var selectedRadio = $('input[name="inlineRadioOptions"]:checked').val();
    var namaGroup = $('input[name="nama_group"]').val();
    var selectedCabangCount = $('.cabang-checkbox:checked').length; 
    var selectedCabangCountCustom = $('.cabang-checkbox-custom:checked').length; 

    var selectedMemberCount = $('.member-select-custom').filter(function() {
        return $(this).val() != null;
    }).length;

    var selectedMemberCountA = $('.member-select-custom-a').filter(function() {
        return $(this).val() != null;
    }).length;

    if (!namaGroup.trim()) {
        alert('Silakan masukkan nama grup.');
        e.preventDefault(); 
    } else if (!selectedRadio) {
        alert('Anda harus memilih salah satu jenis group.');
        e.preventDefault(); 
    }

    else if (selectedRadio === 'Custom') {
    
    if(selectedMemberCountA === 0 && selectedMemberCount === 0){
        alert('Anda harus memilih setidaknya satu anggota untuk jenis grup custom.');
        e.preventDefault(); 
    }   

}




$('.member-select').each(function() {
    var selectedMember = $(this).val();
    if (selectedMember) {
        if (selectedMembers.includes(selectedMember)) {
            valid = false;
            alert("Anggota yang sama tidak boleh dipilih lebih dari satu kali.");
            return false;
        } else {
            selectedMembers.push(selectedMember);
        }
    }
});


$('.member-select-custom').each(function() {
var selectedMember = $(this).val();
if (selectedMember) {
    if (selectedMembers.includes(selectedMember)) {
        valid = false;
        alert("Anggota yang sama tidak boleh dipilih lebih dari satu kali.");
        return false;
    } else {
        selectedMembers.push(selectedMember);
    }
}
});


 
    return valid;
});



</script>
<!-- TAMBAHAN GENERAL -->


<!-- END TAMBAHAN -->
<script>
        $(document).ready(function() {

  


    $("#add-member").click(function() {
    var memberField = `
    <div class="member-container">
        <div class="member-item">
            <select name="anggota[]" class="form-select form-select-sm mb-3 member-select" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" required>
                <option selected disabled>Pilih Anggota</option>
                @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->nama_user }} - {{$user->no_pegawai}}</option>
            @endforeach      
            </select>
            <div class="form-group mb-4 mt-2" style="display:none;">
                <button type="button" class="btn btn-sm remove-member mb-3" style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
            </div> 
            <div class="form-group mb-4 mt-2">
                <button type="button" class="btn btn-sm remove-member mb-3" style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
            </div> 
        </div>
    </div>`;

    $("#member-fields").append(memberField);
   
});




$(document).on("click", ".remove-member", function() {
        $(this).closest(".member-item").remove();
    });


});
</script>

<script>
        $(document).ready(function() {

    $("#add-member-custom").click(function() {
    var memberFieldcustom = `
    <div class="member-container-custom">
        <div class="member-item-custom">
            <select name="anggotacustom[]" class="form-select form-select-sm mb-3 member-select-custom" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" required>
                <option selected disabled>Pilih Anggota</option>
                @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->nama_user }} - {{$user->no_pegawai}}</option>
            @endforeach      
            </select>
            <div class="form-group mb-4 mt-2" style="display:none;">
                <button type="button" class="btn btn-sm remove-member-custom mb-3" style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
            </div> 
            <div class="form-group mb-4 mt-2">
                <button type="button" class="btn btn-sm remove-member-custom mb-3" style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
            </div> 
        </div>
    </div>`;

    $("#member-fields-custom").append(memberFieldcustom);
  
});




$(document).on("click", ".remove-member-custom", function() {
        $(this).closest(".member-item-custom").remove();
    });


});
</script>

<script>
$(document).ready(function() {
    // Fungsi untuk menampilkan atau menyembunyikan form sesuai dengan radio button yang dipilih
    $('input[name="inlineRadioOptions"]').change(function() {
        var value = $(this).val();
        
        // Menampilkan konfirmasi alert
        var confirmation = window.confirm("Jika anda merubah jenis group, maka daftar anggota tersimpan akan hilang, apakah anda yakin?");

        // Jika pengguna mengklik "OK", tampilkan tampilan berdasarkan nilai yang dipilih
        if (confirmation) {
            if (value === 'General') {
                $('#general').show();
                $('#custom').hide();
                $('#customisi').remove();
            } else if (value === 'Custom') {
                $('#general').hide();
                $('#generalisi').remove();
                $('#custom').show();
            }
        } else {
            // Jika pengguna mengklik "Batal", atur pilihan radio button berdasarkan $data->type
            var radioValue = '{{ $data->type }}'; // Mendapatkan nilai dari $data->type
            $('input[name="inlineRadioOptions"][value="' + radioValue + '"]').prop('checked', true);
        }
    });
});
</script>


<!-- TAMBAHAN GENERAL -->

<script>
        $(document).ready(function() {

    $("#add-member-a").click(function() {
    var memberField = `
    <div class="member-container-a">
        <div class="member-item-a">
            <select name="anggota[]" class="form-select form-select-sm mb-3 member-select-a" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" required>
                <option selected disabled>Pilih Anggota</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->nama_user }} - {{$user->no_pegawai}}</option>
            @endforeach      
            </select>
            <div class="form-group mb-4 mt-2" style="display:none;">
                <button type="button" class="btn btn-sm remove-member-a mb-3" style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
            </div> 
            <div class="form-group mb-4 mt-2">
                <button type="button" class="btn btn-sm remove-member-a mb-3" style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
            </div> 
        </div>
    </div>`;

    $("#member-fields-a").append(memberField);

});


$(document).on("click", ".remove-member-a", function() {
        $(this).closest(".member-item-a").remove();
    });


});
</script>

<!-- END TAMBAHAN GENERAL -->


<!-- TAMBAHAN CUSTOM -->

<script>
        $(document).ready(function() {

    $("#add-member-custom-a").click(function() {
    var memberFieldcustom = `
    <div class="member-container-custom-a">
        <div class="member-item-custom-a">
            <select name="anggotacustom[]" class="form-select form-select-sm mb-3 member-select-custom-a" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" required>
                <option selected disabled>Pilih Anggota</option>
                @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->nama_user }} - {{$user->no_pegawai}}</option>
            @endforeach      
            </select>
            <div class="form-group mb-4 mt-2" style="display:none;">
                <button type="button" class="btn btn-sm remove-member-custom-a mb-3" style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
            </div> 
            <div class="form-group mb-4 mt-2">
                <button type="button" class="btn btn-sm remove-member-custom-a mb-3" style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
            </div> 
        </div>
    </div>`;

    $("#member-fields-custom-a").append(memberFieldcustom);
  
});




$(document).on("click", ".remove-member-custom-a", function() {
        $(this).closest(".member-item-custom-a").remove();
    });


});


</script>
<!-- END TAMBAHAN CUSTOM -->

@endif
@endsection

