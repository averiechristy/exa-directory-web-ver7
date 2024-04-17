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
        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="General" {{ $data->type == 'General' ? 'checked' : '' }} disabled>
        <label class="form-check-label"  style="margin-left: 5px;"  for="inlineRadio1">General</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="Custom"  {{ $data->type == 'Custom' ? 'checked' : '' }} disabled>
        <label class="form-check-label"  style="margin-left: 5px;"  for="inlineRadio2">Custom</label>
    </div>

    </div>
@if($data->type == 'General')

<div id="generalisi">

        <div class="form-group mb-4">
            <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Pilih Cabang</label>
            <div class="form-group mb-4">
                @foreach ($cabang as $key => $item)
                    @if ($key % 10 == 0 && $key != 0)
                        </div><div class="form-group mb-4">
                    @endif
                    <div class="form-check" style="display: inline-block; margin-right: 10px;">
                        <input class="form-check-input cabang-checkbox" name="cabang[]" type="checkbox" value="{{ $item->id }}" id="flexCheckIndeterminate{{ $key }}" @if(in_array($item->id, $selectedCabangs)) checked @endif>
                        <label class="form-check-label" style="margin-left: 5px;" for="flexCheckIndeterminate{{ $key }}">
                            {{ $item->nama_cabang }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="form-group mb-4">
            <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Anggota yang dikecualikan</label>

            <div id="member-fields">
            <div class="member-container">
             
                    @foreach ($excludedUsers as $detailData)
                        <div class="member-item">
                            <select name="anggota[]" class="form-select form-select-sm mb-3 member-select" aria-label=".form-select-lg example" style="border-color: #01004C; border-radius: 5px;" required>
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
                    
                    @endforeach
             
                    </div>
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
    <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Pilih Cabang</label>
    <div class="form-group mb-4">
        @foreach ($cabang as $key => $item)
            @if ($key % 10 == 0 && $key != 0)
             </div>

            <div class="form-group mb-4">
            @endif
            <div class="form-check" style="display: inline-block; margin-right: 10px;">
                <input class="form-check-input cabang-checkbox-custom" name="cabang[]" type="checkbox" value="{{ $item->id }}" id="flexCheckIndeterminate{{ $key }}" @if(in_array($item->id, $selectedCabangs)) checked @endif>
                <label class="form-check-label" style="margin-left: 5px;" for="flexCheckIndeterminate{{ $key }}">
                    {{ $item->nama_cabang }}
                </label>
            </div>
        @endforeach
    </div>

             
                     <div class="form-group mb-4">
    <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Anggota</label>
    <div id="member-fields-custom">
    <div class="member-container-custom">
        @foreach ($nama as $detailData)
            <div class="member-item-custom">
                <select name="anggotacustom[]" class="form-select form-select-sm mb-3 member-select-custom" aria-label=".form-select-lg example" style="border-color: #01004C; border-radius: 5px;" required>
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
    else if (selectedRadio === 'General' && selectedCabangCount === 0) { // Menambahkan validasi untuk jenis General
        alert('Anda harus memilih setidaknya satu cabang.');
        e.preventDefault(); 
    }

    else if (selectedRadio === 'Custom' && selectedCabangCountCustom === 0) { // Menambahkan validasi untuk jenis General
        alert('Anda harus memilih setidaknya satu cabang.');
        e.preventDefault(); 
    }

    else if (selectedRadio === 'Custom' && selectedMemberCount === 0) {
        alert('Anda harus memilih setidaknya satu anggota untuk jenis grup custom.');
        e.preventDefault(); 
    }
});



</script>

<script>
        $(document).ready(function() {

      $('.cabang-checkbox').change(function() {
        // Mendapatkan nilai checkbox yang di-check
        var selectedCabang = $('.cabang-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

       
        // Ajax request untuk mendapatkan anggota berdasarkan cabang yang di-check
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
                    $(this).empty(); // Menghapus opsi sebelumnya

                    // Menambah opsi baru
                    $(this).append('<option selected disabled> Pilih Anggota </option>');
                    $.each(data, function(key, value) {
                                               
                        $(this).append('<option value="' + value.id + '">' + value.nama_user + ' - ' + value.no_pegawai + '</option>');
                    
                    }.bind(this));
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

      $('.cabang-checkbox-custom').change(function() {
        // Mendapatkan nilai checkbox yang di-check
        var selectedCabang = $('.cabang-checkbox-custom:checked').map(function() {
            return $(this).val();
        }).get();

        // Ajax request untuk mendapatkan anggota berdasarkan cabang yang di-check
        $.ajax({
            url: '{{ route("superadmin.usergroup.getAnggotaByCabang") }}',
            type: 'post',
            data: {
                _token: '{{ csrf_token() }}',
                cabang: selectedCabang
            },
            success: function(data) {
                // Mengganti opsi pada semua select anggota
                $('.member-select-custom').each(function() {
                    $(this).empty(); // Menghapus opsi sebelumnya

                    // Menambah opsi baru
                    $(this).append('<option selected disabled> Pilih Anggota </option>');
                    
                    $.each(data, function(key, value) {
                                               
                    $(this).append('<option value="' + value.id + '">' + value.nama_user + ' - ' + value.no_pegawai + '</option>');
                    
                    }.bind(this));
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

@endsection

