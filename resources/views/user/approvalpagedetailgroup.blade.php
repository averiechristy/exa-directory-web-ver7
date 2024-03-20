@extends('layouts.user.app')
@section('content')
    <div>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">

                   
                    <h4 style="color:#000;">Detail Group</h4>
         
                
<div class="table-responsive">
                      <table class="table table-bordered" >
                        <thead>
                          <tr>
                            <th>Nama User</th>
                          </tr>
                        </thead>
                        <tbody>
                         
                        @foreach ($member as $member)
                          <tr>
                          
                            <td>{{$member -> User -> nama_user}}</td>
                           

</tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
        </div>
        </div>
        </div>
        </div>
@endsection

