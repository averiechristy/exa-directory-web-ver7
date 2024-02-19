@extends('layouts.user.app')
@section('content')

<div>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <div class="container-fluid">

                <h2 style="color: black; text-align: center;">{!! $data->nama_file !!}</h2>
                <h6 style="color: black;">{!! $data->konten !!}</h6>

                <div style="text-align: center;">
                    @if($data->file)
                    <iframe src="{{ asset('storage/files/') }}/{{ $data->file }}" width="90%" height="500px"></iframe>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
