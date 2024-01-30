@extends($theme.'layouts.user')
@section('title',trans('Messages'))
@section('content')
 <!-- main -->
 <div class="container-fluid">
    <div class="main row  d-flex justify-content-center">
       <div class="col-10 ">
         

          <div class="message-wrapper" id="MessageArea">
             <div class="row g-lg-0">
                <div class="col-lg-12">
                   <div class="inbox-wrapper">
                      <!-- top bar -->
                      <div class="top-bar">
                         <div class="d-flex align-items-center">
                            <img class="user img-fluid" src="{{getFile($user->image_driver,$user->image)}}" alt="" />
                            <div class="name">
                               <a href="javascript:void(0);">{{$user->firstname." ".$user->lastname}} </a>
                            </div>
                         </div>
                         <div>
                            <button class="info-btn" id="infoBtn">
                               <i class="fal fa-info-circle"></i>
                            </button>
                         </div>
                      </div>
                      <!-- chats -->
                      <div class="chats">
                        <div class="div">
                           @foreach ($messages as $message)
                           @if ($message->sender_id == Auth::user()->id)
                              <div class="chat-box this-side">
                                 <div class="text-wrapper" >
                                    <div class="text">
                                       <p>{{$message->message}}</p>
                                    </div>
                                 </div>
                                 <div class="img">
                                    <img class="img-fluid" src="{{getFile($message->sender->image_driver,$message->sender->image)}}" alt="" />
                                 </div>
                              </div>
                              @else
                              <div class="chat-box opposite-side">
                                 <div class="img">
                                    <img class="img-fluid" src="{{getFile($user->image_driver,$user->image)}}" alt="" />
                                 </div>
                                 <div class="text-wrapper">
                                    <div class="text">
                                       <p>{{$message->message}}</p>
                                    </div>
                                 </div>
                              </div>
                           @endif
                          
                           @endforeach
                          

                           

                        </div>
                         
                      </div>
                      <!-- typing area -->
                      <div class="typing-area mt-5">
                        <form action="{{route('user.send.message')}}" method="POST">
                           @csrf
                           <div class="input-group">
                            <input type="hidden" name="receiver_id" value="{{$user->id}}">
                            <input type="hidden" name="sender_id" value="{{Auth::user()->id}}">
                              <input type="text" name="message" class="form-control" />
                              <button type="submit" class="submit-btn" >
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
