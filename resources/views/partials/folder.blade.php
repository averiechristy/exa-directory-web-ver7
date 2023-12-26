{{-- partials/folder.blade.php --}}
<div>
    <a href="">
        <strong>{{ $folder->nama_folder }}</strong>
    </a>
    {{-- Check if the folder has subfolders --}}
    @if($folder->subfolders->count() > 0)
        <div style="margin-left: 20px;">
            {{-- Recursively include the partial for each subfolder --}}
            @foreach($folder->subfolders as $subfolder)
                @include('partials.folder', ['folder' => $subfolder])
            @endforeach
        </div>
    @endif

    {{-- Display files in the current folder --}}
    @foreach($folder->files as $file)
        <div >
         <a href="" style="margin-left: 20px;" data-toggle="modal" data-target="#fileModal{{ $file->id }}" class="see-file"> {{ $file->nama_file }}</a> 
        </div>

        <div class="modal fade" id="fileModal{{ $file->id }}" tabindex="-1" role="dialog" aria-labelledby="fileModalLabel{{ $file->id }}" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-xl"  style="margin-top:5px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fileModalLabel{{ $file->id }}"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe src="{{ asset('storage/files/' . $file->file) }}" width="100%" height="600px"></iframe>
            </div>
            <div class="modal-footer">
              
            </div>
        </div>
    </div>
</div>
    @endforeach
</div>

