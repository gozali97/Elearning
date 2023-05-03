@extends('layouts.app')

@section('content')

@include('layouts.alerts')
<link href="{{ url('/assets/css/simplebar.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ url('/assets/css/theme.min.css') }}">

<style>
    img {
        width: 70px;
        border-radius: 10%;
    }
</style>
<div class="container-fluid">
    <!-- row -->
    <a href="/listajar/view/{{ $materi->kode_jadwal }}" class="btn btn sm btn-outline-secondary d-inline-flex mb-3"><i class="bi bi-arrow-left mt-1 d-inline-flex"></i>Kembali</a>
    <div class="card chat-layout">

        <div class="row g-0">
            <div class="col-xxl-12 col-xl-12 col-md-12 col-12">
                <!-- chat list -->
                <div class="chat-body w-100 h-100">
                    <div class="card-header sticky-top  ">

                        <div class="d-flex justify-content-between align-items-center">

                            <!-- media -->
                            <div class="d-flex align-items-center" id="active-chat-user">
                                <a href="#!" class=" d-xl-none d-block" data-close=""><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-arrow-left">
                                        <line x1="19" y1="12" x2="5" y2="12"></line>
                                        <polyline points="12 19 5 12 12 5"></polyline>
                                    </svg></a>
                                <div class="avatar avatar-md avatar-indicators avatar-online ms-3">
                                    <img src="{{ url('/assets/img/'.$materi->gambar) }}" alt="Image" class="rounded-circle">
                                </div>
                                <!-- media body -->
                                <div class=" ms-2">
                                    <h4 class="mb-0">{{ $materi->name }}</h4>
                                    <p class="mb-0 text-muted">Online</p>
                                </div>
                            </div>


                            <div>
                                <a href="#!" class="btn btn-ghost btn-icon btn-md rounded-circle texttooltip"
                                    data-template="voiceCall">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-phone-call icon-xs">
                                        <path
                                            d="M15.05 5A5 5 0 0 1 19 8.95M15.05 1A9 9 0 0 1 23 8.94m-1 7.98v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                        </path>
                                    </svg>
                                    <div id="voiceCall" class="d-none">
                                        <span>Voice Call</span>
                                    </div>
                                </a>
                                <a href="#!" class="btn btn-ghost btn-icon btn-md rounded-circle texttooltip"
                                    data-template="video">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-video icon-xs">
                                        <polygon points="23 7 16 12 23 17 23 7"></polygon>
                                        <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                                    </svg>
                                    <div id="video" class="d-none">
                                        <span>Video Call</span>
                                    </div>
                                </a>
                                <a href="#!" class="btn btn-ghost btn-icon btn-md rounded-circle texttooltip"
                                    data-template="addUser">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-user-plus icon-xs">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="8.5" cy="7" r="4"></circle>
                                        <line x1="20" y1="8" x2="20" y2="14"></line>
                                        <line x1="23" y1="11" x2="17" y2="11"></line>
                                    </svg>
                                    <div id="addUser" class="d-none">
                                        <span>Add Users</span>
                                    </div>
                                </a>
                            </div>

                        </div>

                        <div class="card-body" id="conversation-list" data-simplebar="init"
                            style="height: 650px; overflow:auto">
                            <div class="simplebar-wrapper" style="margin: -20px;">
                                <div class="simplebar-height-auto-observer-wrapper">
                                    <div class="simplebar-height-auto-observer"></div>
                                </div>
                                <div class="simplebar-mask">
                                    <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                        <div class="simplebar-content-wrapper" tabindex="0" role="region"
                                            aria-label="scrollable content"
                                            style="height: 100%; overflow: hidden scroll;">
                                            <div class="simplebar-content" style="padding: 20px;">
                                                <!-- media -->
                                                <div class="d-flex w-lg-40 mb-4">
                                                    <img src="{{ url('/assets/img/'.$materi->gambar) }}" alt="Image"
                                                        class="rounded-circle avatar-md user-avatar">
                                                    <!-- media body -->
                                                    <div class=" ms-3">
                                                        <small><span class="username">{{ $materi->name }}</span> ,
                                                            09:35</small>
                                                        <div class="d-flex">
                                                            <div class="card mt-2 rounded-top-md-left-0 border">
                                                                <div class="card-body p-3">
                                                                    <p class="mb-0 text-dark">
                                                                        Hello, Setup the github repo for bootstrap admin
                                                                        dashboard.
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end mb-4">
                                                    <!-- media -->
                                                    <div class="d-flex w-lg-40">
                                                        <!-- media body -->
                                                        <div class=" me-3 text-end">
                                                            <small> 09:39</small>
                                                            <div class="d-flex">
                                                                <!-- card -->
                                                                <div
                                                                    class="card mt-2 rounded-top-md-end-0 bg-primary text-white ">
                                                                    <!-- card body -->
                                                                    <div class="card-body text-start p-3">
                                                                        <p class="mb-0">
                                                                            Yes, Currently working on the today evening
                                                                            i
                                                                            will
                                                                            up the admin dashboard template.
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- img -->
                                                        <img src="../assets/images/avatar/avatar-11.jpg" alt="Image"
                                                            class="rounded-circle avatar-md">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="simplebar-placeholder" style="width: auto; height: 840px;"></div>
                            </div>
                            <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                <div class="simplebar-scrollbar"
                                    style="width: 0px; transform: translate3d(0px, 0px, 0px); display: none;"></div>
                            </div>
                            <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                <div class="simplebar-scrollbar"
                                    style="height: 502px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                            </div>
                        </div>

                        <!-- chat footer -->
                        <div class="card-footer border-top-0 chat-footer mt-auto rounded-bottom">
                            <div class="mt-1">
                                <form  id="chatinput-form" action="{{ route('guru.diskusi.sendMessage') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="sender_id" value="{{ Auth::user()->id }}">
                                    <input type="hidden" name="receiver_role" value="{{ Auth::user()->role }}">
                                    <div class="position-relative">
                                        <input class="form-control" placeholder="Type a New Message" id="message" name="message">
                                    </div>
                                    <div class="position-absolute end-0 top-0 mt-4 me-4">
                                        <button type="submit" class="fs-3 btn text-primary btn-focus-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                                                <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                                              </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="mt-3 d-flex">
                                <div>
                                    <a href="#!" class="text-inherit me-2 fs-4"><i class="bi-emoji-smile"></i></a>
                                    <a href="#!" class="text-inherit me-2 fs-4"><i class="bi-paperclip"></i></a>
                                    <a href="#!" class="text-inherit me-3   fs-4"><i class="bi-mic"></i></a>
                                </div>
                                <div class="dropdown">
                                    <a href="#!" class="text-inherit fs-4" id="moreAction" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fe fe-more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="moreAction">
                                        <a class="dropdown-item" href="#!">Action</a>
                                        <a class="dropdown-item" href="#!">Another action</a>
                                        <a class="dropdown-item" href="#!">Something else here</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="newchatModal" tabindex="-1" aria-labelledby="newchatModalLabel" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered " role="document">
        <div class="modal-content ">
            <div class="modal-header align-items-center">
                <h4 class="mb-0" id="newchatModalLabel">Create New Chat</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>
            <div class="modal-body px-0">
                <!-- contact list -->
                <ul class="list-unstyled contacts-list mb-0">
                    <!-- chat item -->
                    <li class="py-3 px-4 chat-item contacts-link">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="#!" class="text-inherit ">
                                <!-- media -->
                                <div class="d-flex">
                                    <div class="avatar avatar-md avatar-indicators avatar-away">
                                        <img src="../assets/images/avatar/avatar-5.jpg" alt="Image"
                                            class="rounded-circle">
                                    </div>
                                    <!-- media body -->
                                    <div class=" ms-2">
                                        <h5 class="mb-0">Pete Martin</h5>
                                        <p class="mb-0 text-muted">On going description of group...
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <div>
                                <small class="text-muted">2/10/2023</small>
                            </div>
                        </div>


                    </li>
                    <!-- chat item -->
                    <li class="py-3 px-4 chat-item contacts-link">

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="#!" class="text-inherit ">
                                <!-- media -->
                                <div class="d-flex">
                                    <div class="avatar avatar-md avatar-indicators avatar-offline">
                                        <img src="../assets/images/avatar/avatar-9.jpg" alt="Image"
                                            class="rounded-circle">
                                    </div>
                                    <!-- media body -->
                                    <div class=" ms-2">
                                        <h5 class="mb-0">Olivia Cooper</h5>
                                        <p class="mb-0 text-muted">On going description of group...
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <div>
                                <small class="text-muted">2/3/2023</small>
                            </div>
                        </div>


                    </li>
                    <!-- chat item -->
                    <li class="py-3 px-4 chat-item contacts-link">

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="#!" class="text-inherit ">
                                <!-- media -->
                                <div class="d-flex">
                                    <div class="avatar avatar-md avatar-indicators avatar-busy">
                                        <img src="../assets/images/avatar/avatar-19.jpg" alt="Image"
                                            class="rounded-circle">
                                    </div>
                                    <!-- media body -->
                                    <div class=" ms-2">
                                        <h5 class="mb-0">Jamarcus Streich</h5>
                                        <p class="mb-0 text-muted">Start design system for UI.
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <div>
                                <small class="text-muted">1/24/2023</small>
                            </div>
                        </div>


                    </li>
                    <!-- chat item -->
                    <li class="py-3 px-4 chat-item contacts-link">

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="#!" class="text-inherit ">
                                <!-- media -->
                                <div class="d-flex">
                                    <div class="avatar avatar-md avatar-indicators avatar-busy">
                                        <img src="../assets/images/avatar/avatar-12.jpg" alt="Image"
                                            class="rounded-circle">
                                    </div>
                                    <!-- media body -->
                                    <div class=" ms-2">
                                        <h5 class="mb-0">Lauren Wilson</h5>
                                        <p class="mb-0 text-muted">Start design system for UI...
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <div>
                                <small class="text-muted">3/3/2023</small>
                            </div>
                        </div>


                    </li>
                    <!-- chat item -->
                    <li class="py-3 px-4 chat-item contacts-link">

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="#!" class="text-inherit ">
                                <!-- media -->
                                <div class="d-flex">
                                    <div class="avatar avatar-md avatar-indicators avatar-online">
                                        <img src="../assets/images/avatar/avatar-14.jpg" alt="Image"
                                            class="rounded-circle">
                                    </div>
                                    <!-- media body -->
                                    <div class=" ms-2">
                                        <h5 class="mb-0">User Name</h5>
                                        <p class="mb-0 text-muted">On going description of group..
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <div>
                                <small class="text-muted">1/5/2023</small>
                            </div>
                        </div>


                    </li>
                    <!-- chat item -->
                    <li class="py-3 px-4 chat-item contacts-link">

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="#!" class="text-inherit ">
                                <!-- media -->
                                <div class="d-flex">
                                    <div class="avatar avatar-md avatar-indicators avatar-online">
                                        <img src="../assets/images/avatar/avatar-15.jpg" alt="Image"
                                            class="rounded-circle">
                                    </div>
                                    <!-- media body -->
                                    <div class=" ms-2">
                                        <h5 class="mb-0">Rosalee Roberts</h5>
                                        <p class="mb-0 text-muted">On going description of group..
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <div>
                                <small class="text-muted">1/14/2023</small>
                            </div>
                        </div>


                    </li>



                </ul>
            </div>

        </div>
    </div>
</div>
<script src="{{ url('/assets/js/tippy-bundle.umd.min.js') }}"></script>
@endsection