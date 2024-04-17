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
                    <p class="mt-2" style="font-size: 14pt;">Tambah User Group</p>
                </div>
    <div class="card-body">
      <form action="{{route('admin.usergroup.simpan')}}" method="post">
      @csrf
                           <div class="form-group mb-4">
                              <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Nama Group</label>
                              <input name="nama_group" type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" style="border-color: #01004C;" value=""  />
                              <!-- @if ($errors->has('name'))
                                  <p class="text-danger">{{$errors->first('name')}}</p>
                              @endif -->
                          </div>                                                      
<label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Jenis Group</label>

<div class="form-group mb-4">

<div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="General">
    <label class="form-check-label"  style="margin-left: 5px;"  for="inlineRadio1">General</label>
</div>

<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="Custom">
  <label class="form-check-label"  style="margin-left: 5px;"  for="inlineRadio2">Custom</label>
</div>

</div>

<div id="general" style="display:none;">


<div class="form-group mb-4">
    <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Anggota Dikecualikan</label>
    <div id="member-fields">
    <div class="member-container">
    <div class="member-item">
        <select name ="anggota[]" class="form-select form-select-sm mb-3 member-select" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" required>
            <option selected disabled>Pilih Anggota</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->nama_user }} - {{$user->no_pegawai}}</option>
            @endforeach                                                                            
        </select>                                                                                       
        <div class="form-group mb-4 mt-2" style="display:none;">
            <button type="button" class="btn btn-sm remove-member mb-3" style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
        </div> 
    </div>
    </div>
                    
    </div>
    <div class="form-group mb-4">
    <button type="button" id="add-member" class="btn btn-sm" style="background-color: #FF9900; color: white; border-radius: 8px;">
        <i class="fa fa-plus" style="font-size: 14px;"></i> Tambah Anggota
    </button>
</div>     
</div>
</div>

<div id="custom" style="display:none;">


    <div class="form-group mb-4">
    <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Anggota</label>
    <div id="member-fields-custom">
    <div class="member-container-custom">
    <div class="member-item-custom">
        <select name ="anggotacustom[]" class="form-select form-select-sm mb-3 member-select-custom" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" required>
            <option selected disabled>Pilih Anggota</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->nama_user }} - {{$user->no_pegawai}}</option>
            @endforeach
        </select>       
        <div class="form-group mb-4 mt-2" style="display:none;">
            <button type="button" class="btn btn-sm remove-member-custom mb-3" id="remove-member-custom"style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
        </div> 
    </div>
    </div>                  
    </div>

<div class="form-group mb-4">
<button type="button" id="add-member-custom" class="btn btn-sm" style="background-color: #FF9900; color: white; border-radius: 8px;">
<i class="fa fa-plus" style="font-size: 14px;"></i> Tambah Anggota
</button>

</div>     
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

$('form').submit(function(e) {
    var selectedRadio = $('input[name="inlineRadioOptions"]:checked').val();
    var namaGroup = $('input[name="nama_group"]').val();
    var selectedCabangCount = $('.cabang-checkbox:checked').length; 
    var selectedCabangCountCustom = $('.cabang-checkbox-custom:checked').length; 

    var selectedMemberCount = $('.member-select-custom').filter(function() {
        return $(this).val() != null;
    }).length;

    if (!namaGroup.trim()) {
        alert('Silakan masukkan nama grup.');
        e.preventDefault(); 
    } else if (!selectedRadio) {
        alert('Anda harus memilih salah satu jenis group.');
        e.preventDefault(); 
    }
   

    else if (selectedRadio === 'Custom' && selectedMemberCount === 0) {
        alert('Anda harus memilih setidaknya satu anggota untuk jenis grup custom.');
        e.preventDefault(); 
    }
});

    $(document).ready(function() {
    // Fungsi untuk menampilkan atau menyembunyikan form sesuai dengan radio button yang dipilih
    $('input[name="inlineRadioOptions"]').change(function() {
        var value = $(this).val();

        if (value === 'General') {
            $('#general').show();
            $('#custom').hide();
        } else if (value === 'Custom') {
            $('#general').hide();
            $('#custom').show();
        }
        
    });
   
    // Code lainnya tetap sama
    // ...
});

</script>

<script>
        $(document).ready(function() {

       
            var selectedMembers = [];

// Event handler untuk perubahan pada select anggota
$(document).on('change', '.member-select', function() {
    var selectedMemberId = $(this).val();

    // Periksa apakah ID anggota sudah ada dalam daftar yang dipilih sebelumnya
    if (selectedMembers.includes(selectedMemberId)) {
        alert("Anggota ini sudah dipilih sebelumnya. Silakan pilih anggota lain.");
        // Kembalikan nilai select box ke opsi default
        $(this).val('');
        // Hapus nilai yang dipilih dari array selectedMembers
        var index = selectedMembers.indexOf(selectedMemberId);
        if (index !== -1) {
            selectedMembers.splice(index, 1);
        }
    } else {
        // Jika ID anggota belum ada dalam daftar, tambahkan ke daftar
        selectedMembers.push(selectedMemberId);
    }
});


var selectedMemberscustom = [];
// Event handler untuk perubahan pada select anggota
$(document).on('change', '.member-select-custom', function() {
    var selectedMemberIdcustom = $(this).val();

    // Periksa apakah ID anggota sudah ada dalam daftar yang dipilih sebelumnya
    if (selectedMemberscustom.includes(selectedMemberIdcustom)) {
        alert("Anggota ini sudah dipilih sebelumnya. Silakan pilih anggota lain.");
        // Kembalikan nilai select box ke opsi default
        $(this).val('');
        // Hapus nilai yang dipilih dari array selectedMemberscustom
        var index = selectedMemberscustom.indexOf(selectedMemberIdcustom);
        if (index !== -1) {
            selectedMemberscustom.splice(index, 1);
        }
    } else {
        // Jika ID anggota belum ada dalam daftar, tambahkan ke daftar
        selectedMemberscustom.push(selectedMemberIdcustom);
    }
});



    



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


@endsection