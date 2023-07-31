@extends('layouts.app')

@section('content')
    <style>
        .image img {
            transition: all 0.5s
        }

        .card:hover .image img {
            transform: scale(1.5)
        }
    </style>
    @include('layouts.alerts')
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card p-4">
                <div class=" image d-flex flex-column justify-content-center align-items-center">
                    <button class="btn btn-secondary">
                        <img src="{{ url('/assets/img/' . Auth::user()->gambar) }}" height="100" width="100" />
                    </button>
                    <span class="name mt-3">{{ Auth::user()->name }}
                    </span>
                    <span class="idd">{{ Auth::user()->email }}</span>



                    <button type="button" class="btn btn-dark mt-4" style="margin-left: 2%" data-bs-toggle="modal"
                        data-bs-target="#resetForm">Reset
                        Password</button>

                    <div class="modal fade text-left" id="resetForm" tabindex="-1" aria-labelledby="resetForm"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="resetForm">
                                        Reset Password
                                    </h4>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </button>
                                </div>

                                <form action="{{ route('admin.resetPassword') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <label for="nama">Password Baru: </label>
                                        <div class="form-group mt-2">
                                            <input id="password" name="password" type="password" class="form-control">
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                            <i class="bx bx-x d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Close</span>
                                        </button>
                                        <button type="submit" class="btn btn-primary ms-1">
                                            <i class="bx bx-check d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Reset Password</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="gap-3 mt-3 icons d-flex flex-row justify-content-center align-items-center"> <span><i
                                class="fa fa-twitter"></i></span> <span><i class="fa fa-facebook-f"></i></span> <span><i
                                class="fa fa-instagram"></i></span> <span><i class="fa fa-linkedin"></i></span> </div>
                    <div class=" px-2 rounded mt-4 date "> <span class="join">Joined
                            {{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('F, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
@endsection
