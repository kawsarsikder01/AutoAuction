@extends($theme.'layouts.user')
@section('title',trans('Reports Conversation'))
@section('content')
 <!-- main -->
 <div class="container-fluid">
    <div class="main row">
       <div class="col-12">
          <div class="dashboard-heading">
             <h4 class="mb-0">Report Conversation</h4>
          </div>

          <div class="message-wrapper">
             <div class="row g-lg-0 d-flex justify-content-center">
                <div class="col-lg-12">
                   <div class="inbox-wrapper">
                      <!-- top bar -->
                      <div class="top-bar">
                         <div class="d-flex align-items-center">
                            <div class="name">
                               <a href="javascript:void(0)">Conversation</a>
                            </div>
                         </div>
                         <div>
                         </div>
                      </div>
                      <div class="chats" >
                       
                        @foreach ($conversations as $conversation)
                            @if ($conversation->sender_id == Auth::user()->id)
                            <div class="chat-box this-side">
                                <div class="text-wrapper">
                                   <div class="text">
                                      <p>{{$conversation->message}}</p>
                                   </div>
                                </div>
                                <div class="img">
                                   <img class="img-fluid" src="{{getFile(Auth::user()->image_driver,Auth::user()->image)}}" alt="" />
                                </div>
                             </div>
                             @else
                             @if ($conversation->admin_id && $conversation->sender_id == $conversation->admin_id)
                                <div class="chat-box opposite-side">
                                    <div class="img">
                                    <img class="img-fluid" src="{{getFile($conversation->admin->image_driver,$conversation->admin->image)}}" alt="" />
                                    </div>
                                    <div class="text-wrapper">
                                    <div class="text">
                                        <p>{{$conversation->message}}</p>
                                    </div>
                                    <span class="time">Admin</span>
                                    </div>
                                </div>
                                @else
                                @if ($conversation->sender_id ==$conversation->reporter_id )
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
                            
                            @endif
                        @endforeach
                  </div>
                      <!-- chats -->
                      <!-- typing area -->
                      <div class="typing-area">
                        <form action="{{route('user.send.report.message')}}" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="hidden" name="report_id" value="{{$report->id}}">
                                <input type="hidden"name="reporter_id"value="{{$report->reporter->id}}">
                                <input type="hidden"name="repotedUser_id"value="{{$report->repotedUser->id}}">
                                <input type="text" name="message" class="form-control" />
                                <button type="submit" class="submit-btn">
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
 @endsection