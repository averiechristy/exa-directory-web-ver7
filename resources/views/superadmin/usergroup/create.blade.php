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
                    <p class="mt-2" style="font-size: 14pt;">Tambah User Group</p>
                </div>
    <div class="card-body">
      <form action="{{route('superadmin.usergroup.simpan')}}" method="post">
      @csrf

      @if (auth()->user()->cabang_id == 1)
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
        <input class="form-check-input cabang-checkbox" name="cabang[]" type="checkbox" value="{{ $item->id }}" id="flexCheckIndeterminate{{ $key }}" {{ $disabled }}>
        <label class="form-check-label" style="margin-left: 5px; {{ $disabled }}" for="flexCheckIndeterminate{{ $key }}" data-toggle="tooltip" data-placement="top" title="{{ $tooltip }}">
            {{ $item->nama_cabang}}
        </label>
    </div>
@endforeach
</div>


<div class="form-group mb-4">
    <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Anggota Dikecualikan</label>
    <div id="member-fields">
    <div class="member-container">
    <div class="member-item">
        <select name ="anggota[]" class="form-select form-select-sm mb-3 member-select" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" required>
            <option selected disabled>Pilih Anggota</option>
            <!-- @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->nama_user }} - {{$user->no_pegawai}}</option>
            @endforeach -->                                                                            
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
        <input class="form-check-input cabang-checkbox-custom" name="cabang[]" type="checkbox" value="{{ $item->id }}" id="flexCheckIndeterminate{{ $key }}" {{ $disabled }}>
        <label class="form-check-label" style="margin-left: 5px; {{ $disabled }}" for="flexCheckIndeterminate{{ $key }}" data-toggle="tooltip" data-placement="top" title="{{ $tooltip }}">
            {{ $item->nama_cabang}}
        </label>
    </div>
@endforeach
</div>

    <div class="form-group mb-4">
    <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Anggota</label>
    <div id="member-fields-custom">
    <div class="member-container-custom">
    <div class="member-item-custom">
        <select name ="anggotacustom[]" class="form-select form-select-sm mb-3 member-select-custom" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" required>
            <option selected disabled>Pilih Anggota</option>
            <!-- @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->nama_user }} - {{$user->no_pegawai}}</option>
            @endforeach -->
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
                           
@else

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

                           @endif
                       </form>

                   </div>
                </div>
            </div>
        </div>

        
  </div>

  <script>
    $(document).ready(function(){
        // Mengatur waktu tunda tooltip menjadi 100 milidetik
        $('[data-toggle="tooltip"]').tooltip({
            delay: { "show": 100, "hide": 0 }
        });
    });
</script>
@if (auth()->user()->cabang_id == 1)
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

$('form').submit(function(e) {

    var valid = true;
    var selectedMembers = [];
    
    var selectedRadio = $('input[name="inlineRadioOptions"]:checked').val();
    var namaGroup = $('input[name="nama_group"]').val();
    var selectedCabangCount = $('.cabang-checkbox:checked').length; 
    var selectedCabangCountCustom = $('.cabang-checkbox-custom:checked').length; 
    

    var selectedMembersCustom = [];

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
    @if (auth()->user()->cabang_id == 1)
    else if (selectedRadio === 'General' && selectedCabangCount === 0) { 
        alert('Anda harus memilih setidaknya satu cabang.');
        e.preventDefault(); 
    }

    else if (selectedRadio === 'Custom' && selectedCabangCountCustom === 0) { 
        alert('Anda harus memilih setidaknya satu cabang.');
        e.preventDefault(); 
    }
    @endif

    else if (selectedRadio === 'Custom' && selectedMemberCount === 0) {
        alert('Anda harus memilih setidaknya satu anggota untuk jenis grup custom.');
        e.preventDefault(); 
    }

else if (selectedRadio === 'General'){

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


    // Validasi anggota untuk Custom Group

    
   
    return valid;
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
            // Event handler untuk perubahan pada select anggota

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
                $.each(data, function(key, value) {
                    $(this).append('<option value="' + value.id + '">' + value.nama_user + ' - ' + value.no_pegawai + '</option>');
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
            <select name="anggota[]" class="form-select form-select-sm mb-3 member-select" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" required>
                <option selected disabled>Pilih Anngota</option>
            </select>
            <div class="form-group mb-4 mt-2" style="display:none;">
                <button type="button" class="btn btn-sm remove-member mb-3" style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
            </div> 
            <div class="form-group mb-4 mt-2">
                <button type="button" class="btn btn-sm remove-member mb-3" style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
            </div> 
        </div>
    </div>
    `;

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
                $.each(data, function(key, value) {
                    $(this).append('<option value="' + value.id + '">' + value.nama_user + ' - ' + value.no_pegawai + '</option>');
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
            <select name="anggotacustom[]" class="form-select form-select-sm mb-3 member-select-custom" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" required>
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

@else


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

$('form').submit(function(e) {
    var valid = true;
    var selectedMembers = [];
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

 
else if (selectedRadio === 'General'){

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



@endif

@endsection  