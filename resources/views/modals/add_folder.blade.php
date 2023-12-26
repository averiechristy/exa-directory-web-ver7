<div class="modal fade" id="addFolderModal" tabindex="-1" role="dialog" aria-labelledby="addFolderModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addFolderModalLabel">Add Folder</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form for adding a folder -->
        <form action="{{route('superadmin.folder.simpan')}}" method="post">
                           @csrf

                          
                           <div class="form-group mb-4">
                               <label for="" class="form-label"style="font-size: 11pt; font-weight: bold;">Nama Folder</label>
                               <input name="nama_folder" type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" style="border-color: #01004C;" value="" required />
                               <!-- @if ($errors->has('name'))
                                   <p class="text-danger">{{$errors->first('name')}}</p>
                               @endif -->
                           </div>
                      
                           <div class="form-group mb-4">
                              <label for="" class="form-label"style="font-size: 11pt; font-weight: bold;">Group</label>
                              <div class="group-container">
    <div class="group-item">

                              <select name="group[]" class="form-select form-select-sm mb-3 group-select" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" required>
                                  <option selected disabled>Pilih Group</option>
                                  @foreach ($usergroup as $item)
            <option value="{{ $item->id }}"{{ old('user_group_id') == $item->id ? 'selected' : '' }}> {{$item->nama_group}}</option>
        @endforeach
                                </select>
                              <!-- @if ($errors->has('name'))
                                  <p class="text-danger">{{$errors->first('name')}}</p>
                              @endif -->
                          </div>

                          <div class="form-group mb-4 ">
            <button type="button" class="btn btn-sm remove-group mb-2" style="float: right; background-color: red; color: white; border-radius: 8px;">Hapus</button>
        </div>

        </div>
        </div>

                          <div class="form-group mb-4">
    <button type="button" id="add-group" class="btn btn-sm" style="background-color: #FF9900; color: white; border-radius: 8px;">
        <i class="fa fa-plus" style="font-size: 14px;"></i> Tambah Group
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
<!-- 

<script>
    var counter = 0;

    $('#add-group').click(function() {
        var groupContainer = $('.group-container');
        var groupItem = $('<div class="group-item">');

        var existingSelect = $('.group-select').eq(0);
        var groupSelect = existingSelect.clone();

        var existingRemoveButton = $('.remove-group').eq(0);
        var removeGroup = existingRemoveButton.clone();

        var counterElement = $('<span class="counter">' + (counter + 1) + '</span>');

        groupSelect.attr('name', `group[]`);

        groupSelect.val('');

        groupItem.find('label').remove();
        groupItem.find('.group-select').remove();
        groupItem.find('.remove-group').remove();

        groupItem.append('<label for="quantity">Group</label>');
        groupItem.append(groupSelect);

        groupItem.append('<div style="margin-top: 10px;"></div>');
        groupItem.append(removeGroup);

        groupContainer.append(groupItem);
        groupItem.append('<div style="margin-top: 40px;"></div>');

        counter++;
    });

    $(document).on('click', '.remove-group', function() {
        var groupContainer = $('.group-container');

        if ($('.group-item').length > 1) {
            $(this).closest('.group-item').remove();
        } else {
            alert("Anda tidak bisa menghapus group pertama.");
        }
    });
</script> -->