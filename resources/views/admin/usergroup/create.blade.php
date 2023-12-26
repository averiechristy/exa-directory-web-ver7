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
                              <input name="nama_group" type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" style="border-color: #01004C;" value="" required />
                              <!-- @if ($errors->has('name'))
                                  <p class="text-danger">{{$errors->first('name')}}</p>
                              @endif -->
                          </div>                          
                          <div class="form-group mb-4">
    <label for="" class="form-label" style="font-size: 11pt; font-weight: bold;">Anggota</label>
    <div class="member-container">
    <div class="member-item">
        <select name ="anggota[]" class="form-select form-select-sm mb-3 member-select" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" required>
            <option selected disabled>Pilih Anggota</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->nama_user }} | {{$user->no_pegawai}}</option>
            @endforeach
        </select>
        
        <div class="form-group mb-4 mt-2">
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
        var counter = 0;
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