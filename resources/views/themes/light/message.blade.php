@extends($theme.'layouts.user')
@section('title',trans('Messages'))
@section('content')
 <!-- main -->
 <div class="container-fluid">
    <div class="main row">
       <div class="col-12">
         

          <div class="message-wrapper">
             <div class="row g-lg-0">
                <div class="col-lg-3">
                   <h5 class="m-3">Messages</h5>
                   <div class="messages-box">
                     
                     
                      
                     
                     
                      
                     
                      <div class="message">
                         <div class="img-box">
                            <img src="https://cdn.pixabay.com/photo/2016/03/31/20/37/client-1295901_1280.png" class="img-fluid" alt="" />
                         </div>
                         <div class="text-box">
                            <a href="">
                               <p class="name">
                                  Trista Francis
                                  <span class="time">4h</span>
                               </p>
                               <p>Wants to connect your network.</p>
                            </a>
                         </div>
                      </div>
                      <div class="message">
                         <div class="img-box">
                            <img src="https://cdn.pixabay.com/photo/2016/03/31/20/37/client-1295901_1280.png" class="img-fluid" alt="" />
                         </div>
                         <div class="text-box">
                            <a href="">
                               <p class="name">
                                  Trista Francis
                                  <span class="time">4h</span>
                               </p>
                               <p>Wants to connect your network.</p>
                            </a>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="col-lg-9">
                   <div class="inbox-wrapper">
                      <!-- top bar -->
                      <div class="top-bar">
                         <div class="d-flex align-items-center">
                            <img class="user img-fluid" src="https://cdn.pixabay.com/photo/2016/03/31/20/37/client-1295901_1280.png" alt="" />
                            <div class="name">
                               <a href="influencer-profile.html">Kimberley Lang</a>
                               <span>Active Now</span>
                            </div>
                         </div>
                         <div>
                            <button class="info-btn" id="infoBtn">
                               <i class="fal fa-info-circle"></i>
                            </button>
                         </div>
                      </div>
                      <!-- chats -->
                      <div class="chats" style="background-image: url('./img/pxfuel.jpg');">
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
                      <div class="typing-area mt-5">
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
@endsection