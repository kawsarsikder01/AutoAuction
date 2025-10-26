@extends($theme.'layouts.user')
@section('title',trans('Ticket Conversation'))
@section('content')
<div class="container-fluid">
    <div class="main row">
       <div class="col-12">
          <div class="dashboard-heading">
             <h4 class="mb-0">@lang('Support Ticket')</h4>
             <a href="{{route('user.ticket.create')}}" type="button" class="btn-custom"  data-bs-target="#editModal">
                @lang('Create ticket')
             </a>
          </div>
          {{-- data-bs-toggle="modal" --}}
          <div class="message-wrapper">
             <div class="row g-lg-0">
                <div class="col-lg-12">
                  <form class="form-row mt-4" action="{{ route('user.ticket.reply', $ticket->id)}}" method="post" enctype="multipart/form-data">
                     @csrf
                     @method('PUT')
                   <div class="inbox-wrapper">
                      <!-- top bar -->
                      <div class="top-bar">
                         <div class="d-flex align-items-center">
                            <div class="name">
                              [{{ trans('Ticket#').$ticket->ticket }}] {{ $ticket->subject }}
                            </div>
                         </div>
                         <div>
                            <button class="info-btn" id="infoBtn">
                               <i class="fal fa-info-circle"></i>
                            </button>
                         </div>
                      </div>


                       <!-- chats -->
                       @if(count($ticket->messages) > 0)
                       <div class="chats">
                           @foreach($ticket->messages as $item)
                               @if($item->admin_id == null)
                                   <div class="chat-box this-side">
                                       <div class="chat-box this-side">
                                           <div class="text-wrapper">
                                               <div class="text">
                                                   <p>
                                                       {!! $item->message !!}
                                                   </p>
                                               </div>
                                               @if(0 < count($item->attachments))
                                               <div class="attachment-wrapper">
                                                   @foreach($item->attachments as $k=> $file)
                                                       <a
                                                           class="attachment"
                                                           href="{{route('user.ticket.download',encrypt($file->id))}}"
                                                           data-fancybox="gallery">
                                                           <i class="fa fa-file"></i> @lang('File') {{++$k}}
                                                       </a>
                                                   @endforeach
                                               </div>
                                               @endif
                                               <small class="time"> {{dateTime($item->created_at, 'd M, y h:i A')}}</small>
                                           </div>
                                           <div class="img">
                                               <img class="img-fluid" src="{{ getFile($user->image_driver, $user->image) }}" alt="" />
                                           </div>
                                       </div>
                                   </div>
                               @else
                                   <div class="chat-box opposite-side">
                                       <div class="img">
                                           <img class="img-fluid" src="{{ getFile($item->admin->image_driver, $item->admin->image) }}" alt="" />
                                       </div>
                                       <div class="text-wrapper">
                                           <div class="text">
                                               <p>
                                                   {!! $item->message !!}
                                               </p>
                                           </div>
                                           <div class="attachment-wrapper">
                                               @foreach($item->attachments as $k=> $file)
                                                    <a
                                                           class="attachment"
                                                           href="{{route('user.ticket.download',encrypt($file->id))}}"
                                                           data-fancybox="gallery">
                                                           <i class="fa fa-file"></i> @lang('File') {{++$k}}
                                                       </a>
                                               @endforeach
                                           </div>
                                           <small class="time">{{dateTime($item->created_at, 'd M, y h:i A')}}</small>
                                       </div>
                                   </div>
                               @endif
                           @endforeach
                       </div>
                   @endif
                      <!-- typing area -->
                       <div class="typing-area">
                           <form  action="{{ route('user.ticket.reply', $ticket->id)}}" method="post" enctype="multipart/form-data"  method="post">
                               @csrf
                               @method('PUT')
                               <input type="hidden" name="replayTicket" value="1">
                               <div class="img-preview">
                                   <button class="delete" type="button" id="deleteImage">
                                       <i class="fal fa-times" type="button"></i>
                                   </button>
                                   <img
                                       id="attachment"
                                       src=""
                                       alt=""
                                       class="img-fluid"
                                   />

                               </div>
                               <div class="input-group">
                                   <div>
                                       <span class="upload-img send-file-btn">
                                          <i class="fal fa-paperclip"></i>
                                          <input
                                              class="form-control"
                                              name="attachments[]"
                                              accept="image/*"
                                              type="file"
                                              id="ticketImage"
                                              onchange="previewImage('attachment')"
                                              multiple
                                          />
                                       </span>
                                   </div>
                                   <input type="text" name="message"   class="form-control" placeholder="@lang('Enter your message')">
                                   <button type="submit" class="submit-btn" >
                                       <i class="far fa-paper-plane"></i>
                                   </button>
                               </div>
                               @error("message")
                               <span class="invalid-feedback d-block" role="alert">
                                     {{ $message }}
                                    </span>
                               @enderror
                           </form>

                       </div>
                   </div>
                  </form>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>

@endsection

@push('script')
    <script>

        $(document).on('click','#deleteImage',function (){
            $('.img-preview').hide();
            $('#attachment').attr('src',false);
            $('#ticketImage').val('');
        })
        $(document).ready(function () {
            $('.img-preview').hide();
        })
        const previewImage = (id) => {
            $('.img-preview').show();
            document.getElementById(id).src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
@endpush

