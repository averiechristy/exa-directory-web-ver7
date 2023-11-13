@extends('layouts.admin.app')

@section('content')

<div class="main-panel">
        <div class="content-wrapper">

                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
              
                </div>
                <div id="content-wrapper" class="d-flex flex-column">

                  <!-- Main Content -->
                  <div id="content" class="content mt-3">
                    
                    <div class="container">
                        <div class="row">
                           
                                <img src="{{asset('img/profil.png')}}" style="height: 80px; width: 100px;">
                                <h3 class="mt-2">Admin</h3>
                                 
                        </div>
                        <form>
                            <div class="mb-3">
                              <label for="exampleInputEmail1" class="form-label">Current Password</label>
                              <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                            </div>
                            <div class="mb-3">
                              <label for="exampleInputPassword1" class="form-label"> New Password</label>
                              <input type="password" class="form-control" id="exampleInputPassword1" required>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Re- type Password</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" required>
                            </div>
    
                            <button type="submit" class="btn btn-primary">Simpan</button>
                          </form>
                    </div>     
                  </div>
              </div>
        </div>
@endsection