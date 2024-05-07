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
                    <p class="mt-2" style="font-size: 14pt;">Edit User Group</p>
                  </div>
                  <div class="card-body">
                      <form action="/adminupdateusergroup/{{$data->id}}" method="post">
                           @csrf
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
            <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Anggota yang dikecualikan</label>
            <div id="member-fields">
            <div class="member-container">

        @foreach ($excludedUsers as $detailData)
                        <div class="member-item">
                            <select name="anggota[]" class="form-select form-select-sm mb-3 member-select" aria-label=".form-select-lg example" style="border-color: #01004C; border-radius: 5px;" required>
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
                  
    <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Anggota</label>
    <div id="member-fields-custom">
    <div class="member-container-custom">
        @foreach ($nama as $detailData)
            <div class="member-item-custom">
                <select name="anggotacustom[]" class="form-select form-select-sm mb-3 member-select-custom" aria-label=".form-select-lg example" style="border-color: #01004C; border-radius: 5px;" required>
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

                       </form>
                   </div>
                </div>
            </div>
        </div>
  </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script>

$('form').submit(function(e) {
    var valid = true;
    var selectedMembers = [];
    var selectedMembersA = [];

    var selectedMembersCustomA = [];
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
    $('.member-select-custom-a').each(function() {
var selectedMemberCustomA = $(this).val();
if (selectedMemberCustomA) {
    if (selectedMembersCustomA.includes(selectedMemberCustomA)) {
        valid = false;
        alert("Anggota yang sama tidak boleh dipilih lebih dari satu kali.");
        return false;
    } else {
        selectedMembersCustomA.push(selectedMemberCustomA);
    }
}
});
   
}

else if (selectedRadio === 'General'){

$('.member-select').each(function() {
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


$('.member-select-a').each(function() {
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
}


else if (selectedRadio === 'Custom'){

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

}

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
@endsection

