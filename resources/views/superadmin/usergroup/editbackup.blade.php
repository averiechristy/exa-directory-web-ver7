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
    <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Pilih Cabang</label>
    <div class="form-group mb-4">
        @foreach ($cabang as $key => $item)
            @if ($key % 5 == 0 && $key != 0)
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
                              <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Nama Group</label>
                              <input name="nama_group" type="text" value="{{ old('nama_group', $data->nama_group) }}"class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" style="border-color: #01004C;" value="" required />
                              <!-- @if ($errors->has('name'))
                                  <p class="text-danger">{{$errors->first('name')}}</p>
                              @endif -->
                          </div> 


                          

                     <div class="form-group mb-4">
    <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Anggota</label>
    <div class="member-container">
        @foreach ($nama as $detailData)
            <div class="member-item">
                <select name="anggota[]" class="form-select form-select-sm mb-3 member-select" aria-label=".form-select-lg example" style="border-color: #01004C; border-radius: 5px;" required>
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
    function saveMemberData() {
    var memberData = [];
    $('.member-item').each(function() {
        var memberSelect = $(this).find('.member-select');
        var memberId = memberSelect.val();
        memberData.push({ memberId: memberId});
    });
    localStorage.setItem('memberData', JSON.stringify(memberData));
}

$(document).ready(function() {
    // ...

    // Event handler untuk menambah produk
    $('.add-member').click(function() {
        // ...
        saveMemberData();
    });

    // Event handler untuk menghapus produk
    $(document).on('click', '.remove-member', function() {
        // ...
        saveMemberData();
    });

    // ...
});

$(document).ready(function() {
        var counter = 0; // Set counter sesuai dengan jumlah produk yang ada
        

        $('#cabang').change(function() {
            var cabangId = $(this).val();
            $.ajax({
                url: '/getMember/' + cabangId,
                type: 'GET',
                success: function(data) {
                    var memberSelect = $('.member-select');
                    
                    memberSelect.empty();
                    $.each(data, function(key, user) {
                        memberSelect.append('<option value="'+ user.id +  '">' + user.nama_user + ' | ' + user.no_pegawai + '</option>');                  

                    });
                }
            });
        });

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
        saveMemberData();
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
</script>

  

@endsection

