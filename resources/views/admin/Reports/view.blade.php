@extends('admin.layouts.app')
@section('page_title', __('User Report'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item">
                                <a class="breadcrumb-link" href="javascript:void(0)">
                                    @lang('Dashboard')
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Reports')</li>
                            <li class="breadcrumb-item active"
                            aria-current="page">User Report</li>
                            
                        </ol>
                    </nav>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-3 mb-lg-5">
                    <div class="card-header card-header-content-between">
                        <h4 class="card-header-title">@lang("Reporter Profile")</h4>
                        <a class="btn btn-white btn-sm"
                           href=""><i
                                class="bi-eye me-1"></i> @lang("View Profile")</a>
                    </div>

                    <div class="card-body">
                        <ul class="list-unstyled list-py-2 text-dark mb-0">
                            <li class="pb-0"><span class="card-subtitle">@lang("About")</span></li>
                            <li>
                                <i class="bi-person dropdown-item-icon"></i>{{$report->reporter->firstname.' '.$report->reporter->lastname}}
                            </li>
                            <li>
                                <i class="bi-briefcase dropdown-item-icon"></i>{{$report->reporter->username}} 
                            </li>


                            <li class="pt-4 pb-0"><span class="card-subtitle">@lang("Contacts")</span></li>
                            <li><i class="bi-at dropdown-item-icon"></i> {{$report->reporter->email}} </li>
                            <li><i class="bi-phone dropdown-item-icon"></i> {{$report->reporter->phone}}</li>
                        </ul>
                    </div>

                </div>
                <div class="card mb-3 mb-lg-5">
                    <div class="card-header card-header-content-between">
                        <h4 class="card-header-title">@lang("Repoted User Profile")</h4>
                        <a class="btn btn-white btn-sm"
                           href=""><i
                                class="bi-eye me-1"></i> @lang("View Profile")</a>
                    </div>

                    <div class="card-body">
                        <ul class="list-unstyled list-py-2 text-dark mb-0">
                            <li class="pb-0"><span class="card-subtitle">@lang("About")</span></li>
                            <li>
                                <i class="bi-person dropdown-item-icon"></i> {{$report->repotedUser->firstname.' '.$report->repotedUser->lastname}}
                            </li>
                            <li>
                                <i class="bi-briefcase dropdown-item-icon"></i> {{$report->repotedUser->username}}
                            </li>


                            <li class="pt-4 pb-0"><span class="card-subtitle">@lang("Contacts")</span></li>
                            <li><i class="bi-at dropdown-item-icon"></i> {{$report->repotedUser->email}} </li>
                            <li><i class="bi-phone dropdown-item-icon"></i> {{$report->repotedUser->phone}} </li>
                        </ul>
                    </div>

                </div>
            </div>
            <div class="col-lg-8">
                <div class="card mb-3 mb-lg-5">
                    <div class="card-header card-header-content-between">
                        <h4 class="card-header-title">Report</h4>
                    </div>
                        <div class="card-body">
                            <h5>Subject</h5>
                            <p> {{$report->subject}} </p>
                            <h5>Report Reason</h5>
                            <p> {{$report->reason}} </p>
                        </div>
                </div>
                <div class="card mb-3 mb-lg-5">
                    <div class="message-wrapper">
                        <div class="row g-lg-0">
                           
                           <div class="col-lg-12">
                              <div class="inbox-wrapper">
                                 <!-- top bar -->
                                 <div class="top-bar">
                                    <div class="d-flex align-items-center">
                                       <div class="name">
                                        <p><i class="bi bi-people fs-4"></i> <span class="text-black m-2 fs-4" >Conversation</span></p>
                                       </div>
                                    </div>
                                 </div>
                                 <!-- chats -->
                                 <div class="chats">
                                    <div class="chat-box this-side">
                                       <div class="text-wrapper">
                                          <div class="text">
                                             <p>Hello! How are you</p>
                                          </div>
                                          <span class="time">3 hours ago</span>
                                       </div>
                                       <div class="img">
                                          <img class="img-fluid" src="https://cdn.pixabay.com/photo/2016/03/31/20/37/client-1295901_1280.png" alt="" />
                                       </div>
                                    </div>
                                    <div class="chat-box opposite-side">
                                       <div class="img">
                                          <img class="img-fluid" src="https://cdn.pixabay.com/photo/2016/03/31/20/37/client-1295901_1280.png" alt="" />
                                       </div>
                                       <div class="text-wrapper">
                                          <div class="text">
                                             <p>Hello! How are you</p>
                                          </div>
                                          <span class="time">3 hours ago</span>
                                       </div>
                                    </div>
                                    <div class="chat-box this-side">
                                       <div class="text-wrapper">
                                          <div class="text">
                                             <p>
                                                Hello! How are you Lorem, ipsum dolor sit amet consectetur
                                                adipisicing elit. Dolorem rem
                                             </p>
                                          </div>
                                          <span class="time">3 hours ago</span>
                                       </div>
                                       <div class="img">
                                          <img class="img-fluid" src="https://cdn.pixabay.com/photo/2016/03/31/20/37/client-1295901_1280.png" alt="" />
                                       </div>
                                    </div>
                                    
                                    
                                    
                                 </div>
                                 <!-- typing area -->
                                 <div class="typing-area">
                                    <div class="input-group">
                                       <input type="text" class="form-control" />
                                       <button class="submit-btn">
                                          <i class="fal fa-paper-plane"></i>
                                       </button>
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
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/conversation.css')}}">
@endpush