@extends('layouts.user.app')
@section('content')
    <div>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <hr>
                    <h4>List Folders and Files</h4>
                    @foreach($folders as $folder)
                        @include('partials.folder', ['folder' => $folder])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection