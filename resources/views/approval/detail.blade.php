@extends('layouts.approval.app')
@section('content')
<div class="content-wrapper">
          
           
             
          <div class="d-sm-flex align-items-center justify-content-between border-bottom">
           
           
            
          </div>
          <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content" class="content">

            <h4 class="h4 mb-2 text-gray-800 mt-3"><a href="{{ route('approval.dashboard') }}">Konten</a> / Isi Konten</h4>

            <h10>
            {!!$data->konten!!}

            </h10>
          
            <div style="text-align: center;">
                    @if($data->file)
                    <iframe src="{{ asset('storage/files/') }}/{{ $data->file }}" width="90%" height="500px"></iframe>
                    @endif
                </div>
                
            </div>
            </div>


@endsection