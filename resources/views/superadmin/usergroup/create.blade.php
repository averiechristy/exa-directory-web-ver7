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
                           <div class="form-group mb-4">
                              <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Nama Group</label>
                              <input name="nama_group" type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" style="border-color: #01004C;" value=""  />
                              <!-- @if ($errors->has('name'))
                                  <p class="text-danger">{{$errors->first('name')}}</p>
                              @endif -->
                          </div>        

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
    @if ($key % 5 == 0 && $key != 0)
        </div><div class="form-group mb-4">
    @endif
    <div class="form-check" style="display: inline-block; margin-right: 10px;">
        <input class="form-check-input cabang-checkbox" name="cabang[]" type="checkbox" value="{{ $item->id }}" id="flexCheckIndeterminate{{ $key }}">
        <label class="form-check-label" style="margin-left: 5px;" for="flexCheckIndeterminate{{ $key }}">
            {{ $item->nama_cabang}}
        </label>
    </div>
@endforeach
</div>  

<div class="form-group mb-4">
    <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Anggota Dikecualikan</label>
    <div class="member-container">
    <div class="member-item">
        <select name ="anggota[]" class="form-select form-select-sm mb-3 member-select" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" required>
            <option selected disabled>Pilih Anggota Pengecualian</option>
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

<div id="custom" style="display:none;">
<label for="" class="form-label"style="font-size: 11pt; font-weight: bold;">Pilih Cabang</label>
<div class="form-group mb-4">
@foreach ($cabang as $key => $item)
    @if ($key % 5 == 0 && $key != 0)
        </div><div class="form-group mb-4">
    @endif
    <div class="form-check" style="display: inline-block; margin-right: 10px;">
        <input class="form-check-input cabang-checkbox" name="cabang[]" type="checkbox" value="{{ $item->id }}" id="flexCheckIndeterminate{{ $key }}">
        <label class="form-check-label" style="margin-left: 5px;" for="flexCheckIndeterminate{{ $key }}">
            {{ $item->nama_cabang}}
        </label>
    </div>
@endforeach
</div>
    <div class="form-group mb-4">
    <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Anggota</label>
    <div class="member-container-custom">
    <div class="member-item-custom">
        <select name ="anggotacustom[]" class="form-select form-select-sm mb-3 member-select-custom" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" required>
            <option selected disabled>Pilih Anggota</option>
            <!-- @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->nama_user }} - {{$user->no_pegawai}}</option>
            @endforeach -->
        </select>       
        <div class="form-group mb-4 mt-2" style="display:none;">
            <button type="button" class="btn btn-sm remove-member-custom mb-3" style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
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
    $('form').submit(function(e) {
    var selectedRadio = $('input[name="inlineRadioOptions"]:checked').val();
    var namaGroup = $('input[name="nama_group"]').val();
    if (!namaGroup.trim()) {
        alert('Silakan masukkan nama grup.');
        e.preventDefault(); // Mencegah pengiriman formulir jika nama grup tidak diisi
    }
    else  if (!selectedRadio) {
        alert('Anda harus memilih salah satu opsi.');
        e.preventDefault(); // Mencegah pengiriman formulir jika tidak ada opsi yang dipilih
    }
});

    // Code lainnya tetap sama
    // ...
});

</script>

<script>
$(document).ready(function() {
        var counter = 0; // Set counter sesuai dengan jumlah produk yang ada
        
        $('#add-member').click(function() { // Mengubah selector menjadi '#add-member'
        var memberContainer = $('.member-container'); // Mengubah selector menjadi '.member-container'
        var memberItem = $('<div class="member-item">');

        var existingSelect = $('.member-select').eq(0);
        var memberSelect = existingSelect.clone();

        var existingRemoveButton = $('.remove-member').eq(0);
        var removeMember = existingRemoveButton.clone();

        var counterElement = $('<span class="counter">' + (counter + 1) + '</span>');

        memberSelect.attr('name', `anggota[]`);

        // Reset nilai input fields dan select box
        memberSelect.val('');

        // Hapus elemen label dan input fields sebelumnya
        memberItem.find('label').remove();
        memberItem.find('.member-select').remove();
        memberItem.find('.remove-member').remove();

        memberItem.append('<label for="quantity">Anggota</label>');
        memberItem.append(memberSelect);

        memberItem.append('<div style="margin-top: 10px;"></div>');
        memberItem.append(removeMember);

        memberContainer.append(memberItem);
        memberItem.append('<div style="margin-top: 40px;"></div>');

        counter++;
    });

    $('.cabang-checkbox').change(function() {
        // Mendapatkan nilai checkbox yang di-check
        var selectedCabang = $('.cabang-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        console.log(selectedCabang);
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
                    $(this).append('<option selected disabled>Pilih Anggota</option>');
                    $.each(data, function(key, value) {
                        
                        
                        $(this).append('<option value="' + value.id + '">' + value.nama_user + ' - ' + value.no_pegawai + '</option>');
                    
                    }.bind(this));
                });
            }
        });
    });

 
    $(document).on('click', '.remove-member', function() {
        var memberContainer = $('.member-container');
            
        if ($('.member-item').length > 1) {
                $(this).closest('.member-item').remove();
            } else {
                alert("Anda tidak dapat menghapus anggota pertama.");
            }
        });
    });

    $(document).ready(function() {
    // Daftar ID anggota yang sudah dipilih
    var selectedMembers = [];

    // Event handler untuk perubahan pada select anggota
    $(document).on('change', '.member-select', function() {
        var selectedMemberId = $(this).val();

        // Periksa apakah ID anggota sudah ada dalam daftar yang dipilih sebelumnya
        if (selectedMembers.includes(selectedMemberId)) {
            alert("Anggota ini sudah dipilih sebelumnya. Silakan pilih anggota lain.");
            // Kembalikan nilai select box ke opsi default
            $(this).val('');
        } else {
            // Jika ID anggota belum ada dalam daftar, tambahkan ke daftar
            selectedMembers.push(selectedMemberId);
        }
    });

    // Event handler untuk menghapus anggota dari daftar
    $(document).on('click', '.remove-member', function() {
        var removedMemberId = $(this).closest('.member-item').find('.member-select').val();

        // Hapus ID anggota yang dihapus dari daftar
        selectedMembers = selectedMembers.filter(function(memberId) {
            return memberId !== removedMemberId;
        });
    });
});

</script>



<!-- Custom Script -->


<script>
$(document).ready(function() {
        var counter = 0; // Set counter sesuai dengan jumlah produk yang ada
        
        $('#add-member-custom').click(function() { // Mengubah selector menjadi '#add-member'
        var memberContainer = $('.member-container-custom'); // Mengubah selector menjadi '.member-container'
        var memberItem = $('<div class="member-item-custom">');

        var existingSelect = $('.member-select-custom').eq(0);
        var memberSelect = existingSelect.clone();

        var existingRemoveButton = $('.remove-member-custom').eq(0);
        var removeMember = existingRemoveButton.clone();

        var counterElement = $('<span class="counter">' + (counter + 1) + '</span>');

        memberSelect.attr('name', `anggotacustom[]`);

        // Reset nilai input fields dan select box
        memberSelect.val('');

        // Hapus elemen label dan input fields sebelumnya
        memberItem.find('label').remove();
        memberItem.find('.member-select-custom').remove();
        memberItem.find('.remove-member-custom').remove();

        memberItem.append('<label for="quantity">Anggota</label>');
        memberItem.append(memberSelect);

        memberItem.append('<div style="margin-top: 10px;"></div>');
        memberItem.append(removeMember);

        memberContainer.append(memberItem);
        memberItem.append('<div style="margin-top: 40px;"></div>');

        counter++;
    });

    $('.cabang-checkbox').change(function() {
        // Mendapatkan nilai checkbox yang di-check
        var selectedCabang = $('.cabang-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        console.log(selectedCabang);
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
                    $(this).append('<option selected disabled>Pilih Anggota</option>');
                    $.each(data, function(key, value) {
                        
                        
                        $(this).append('<option value="' + value.id + '">' + value.nama_user + ' - ' + value.no_pegawai + '</option>');
                    
                    }.bind(this));
                });
            }
        });
    });

 
    $(document).on('click', '.remove-member-custom', function() {
        var memberContainer = $('.member-container-custom');
            
        if ($('.member-item-custom').length > 1) {
                $(this).closest('.member-item-custom').remove();
            } else {
                alert("Anda tidak dapat menghapus anggota pertama.");
            }
        });
    });

    $(document).ready(function() {
    // Daftar ID anggota yang sudah dipilih
    var selectedMembers = [];

    // Event handler untuk perubahan pada select anggota
    $(document).on('change', '.member-select-custom', function() {
        var selectedMemberId = $(this).val();

        // Periksa apakah ID anggota sudah ada dalam daftar yang dipilih sebelumnya
        if (selectedMembers.includes(selectedMemberId)) {
            alert("Anggota ini sudah dipilih sebelumnya. Silakan pilih anggota lain.");
            // Kembalikan nilai select box ke opsi default
            $(this).val('');
        } else {
            // Jika ID anggota belum ada dalam daftar, tambahkan ke daftar
            selectedMembers.push(selectedMemberId);
        }
    });

    // Event handler untuk menghapus anggota dari daftar
    $(document).on('click', '.remove-member-custom', function() {
        var removedMemberId = $(this).closest('.member-item-custom').find('.member-select-custom').val();

        // Hapus ID anggota yang dihapus dari daftar
        selectedMembers = selectedMembers.filter(function(memberId) {
            return memberId !== removedMemberId;
        });
    });
});


    
</script>





@endsection