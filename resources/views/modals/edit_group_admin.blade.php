<!-- edit_group.blade.php -->
  <!-- Edit Group Modal-->
  <div class="modal fade" id="editgroupadmin{{$folder->id}}" tabindex="-1" role="dialog" aria-labelledby="EditGrouprModalLabeladmin{{$folder->id}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditGrouprModalLabeladmin{{$folder->id}}">Edit Group</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/updatefoldergroupadmin/{{$folder->id}}" method="POST">     
                @csrf
               
                <div class="form-group mb-4">
                              <label for="" class="form-label"style="font-size: 11pt; font-weight: bold;">Group</label>
                              <div class="group-container">
    <div class="group-item">

                              <select name="group" class="form-select form-select-sm mb-3 group-select" aria-label=".form-select-lg example" style="border-color: #01004C;  border-radius: 5px;" required>
                                  <option selected disabled>Pilih Group</option>
                                 

        @foreach ($usergroup as $item)
            <option value="{{ $item->id }}" {{ old('user_group_id', $folder->user_group_id) == $item->id ? 'selected' : '' }}>
                {{ $item->nama_group }}
            </option>
        @endforeach
                                </select>
                              <!-- @if ($errors->has('name'))
                                  <p class="text-danger">{{$errors->first('name')}}</p>
                              @endif -->
                          </div>
        </div>
        </div>
                      

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
            </div>
        </div>
    </div>
</div>





