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
                           href="{{route('admin.user.view.profile',$report->reporter->id )}}"><i
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
                           href="{{route('admin.user.view.profile',$report->repotedUser->id )}}"><i
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
                        <!-- Dropdown -->
                        @if($report->Vehicle->details->sold_status == 1)
                            @if($bid->bidder->id == $report->repoter_id || $bid->bidder->id == $report->reported_user_id)
                                @if($report->Vehicle->release_status==0 || $report->Vehicle->payment_status == 0)
                                    <div class="dropdown card-header-dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            Release Payment
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="{{route('admin.release.seller.payment',$report->id)}}">Release To Seller</a>
                                            <a class="dropdown-item" href="{{route('admin.release.bidder.payment',$report->id)}}">Release To Bidder</a>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endif
                        <!-- End Dropdown -->
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
                                     @foreach($conversations as $conversation)
                                         @if($conversation->sender_id == Auth::user()->id)
                                             <div class="chat-box this-side">
                                                 <div class="text-wrapper">
                                                     <div class="text">
                                                         <p>{{$conversation->message}}</p>
                                                     </div>
{{--                                                     <span class="time">3 hours ago</span>--}}
                                                 </div>
                                                 <div class="img">
                                                     <img class="img-fluid" src="{{getFile(Auth::user()->image_driver,Auth::user()->image)}}" alt="" />
                                                 </div>

                                             </div>
                                         @else
                                             @if($conversation->sender_id == $conversation->reporter_id)
                                                 <div class="chat-box opposite-side">
                                                     <div class="img">
                                                         <img class="img-fluid" src="{{getFile($conversation->reporter->image_driver,$conversation->reporter->image)}}" alt="" />
                                                     </div>
                                                     <div class="text-wrapper">
                                                         <div class="text">
                                                             <p>{{$conversation->message}}</p>
                                                         </div>
                                                         <span class="time">{{$conversation->reporter->firstname}}</span>
                                                     </div>
                                                 </div>
                                             @else
                                                 <div class="chat-box opposite-side">
                                                     <div class="img">
                                                         <img class="img-fluid" src="{{getFile($conversation->repotedUser->image_driver,$conversation->repotedUser->image)}}" alt="" />
                                                     </div>
                                                     <div class="text-wrapper">
                                                         <div class="text">
                                                             <p>{{$conversation->message}}</p>
                                                         </div>
                                                         <span class="time">{{$conversation->repotedUser->firstname}}</span>
                                                     </div>
                                                 </div>
                                             @endif
                                         @endif
                                     @endforeach

                                 </div>
                                 <!-- typing area -->
                                 <div class="typing-area">
                                    <form action="{{route('admin.send.message')}}" method="POST">
                                        @csrf
                                        <div class="input-group">
                                            <input type="hidden" name="report_id" value="{{$report->id}}">
                                            <input type="hidden"name="reporter_id"value="{{$report->reporter->id}}">
                                            <input type="hidden"name="repotedUser_id"value="{{$report->repotedUser->id}}">
                                            <input type="text" name="message" class="form-control" />
                                            <button type="submit" class="btn btn-info">
                                               <i class="fal fa-paper-plane"></i>
                                            </button>
                                         </div>
                                    </form>

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
