{{-- <x-banner-component heading="Contact Us" page="Contact Us"/> --}}
<iframe
id="map"
src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3615.337182229823!2d55.27369701188658!3d25.022628814644584!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f710571deae53%3A0x4540d9158c55eec2!2sAl%20Naseem%20B1!5e0!3m2!1sen!2sbd!4v1686720050207!5m2!1sen!2sbd"
width="100%"
height="600"
style="border: 0"
allowfullscreen=""
loading="lazy"
referrerpolicy="no-referrer-when-downgrade"
></iframe>
<!-- contact section -->
<div class="contact-section">
    <div class="container">
       <div class="row g-4">
          <div class="col-lg-6">
             <div class="section-header">
                <h5>{{$contact['single']['heading']??''}}</h5>
                <h2>{{$contact['single']['title']??''}}</span></h2>
                <p>
                  {!! $contact['single']['description']??'' !!}
                </p>
             </div>
             <div class="row">
                <div class="col-12">
                   <h4>Get Ahold of Us</h4>
                   <div class="info-box">
                      <div class="icon">
                         <div class="icon"><i class="fa-light fa-envelope"></i></div>
                      </div>
                      <div class="text">
                         <h4>{{$contact['single']['email']??''}}</h4>
                      </div>
                   </div>
                   <div class="info-box">
                      <div class="icon">
                         <div class="icon"><i class="fa-light fa-phone"></i></div>
                      </div>
                      <div class="text">
                         <h4>{{$contact['single']['phone_no']??''}}</h4>
                      </div>
                   </div>
                   <div class="info-box">
                      <div class="icon">
                         <div class="icon"><i class="fa-light fa-location-dot"></i></div>
                      </div>
                      <div class="text">
                         <h4>{{$contact['single']['address']??''}}</h4>
                      </div>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-lg-1"></div>
          <div class="col-lg-5">
             <div class="form-box">
                <form action="">
                   <div class="row g-4">
                      <div class="col-md-12">
                         <div class="form-floating">
                            <input type="text" name="name" class="form-control" id="floatingName" placeholder="Name" />
                            <label for="floatingName">Full Name</label>
                         </div>
                      </div>
                      <div class="col-md-12">
                         <div class="form-floating">
                            <input
                               type="email"
                               name="email"
                               class="form-control"
                               id="floatingInput"
                               placeholder="name@example.com"
                            />
                            <label for="floatingInput">Email address</label>
                         </div>
                      </div>
                      <div class="input-box col-12">
                         <select class="form-select" name="subject" aria-label="Default select example">
                            <option selected>Subject</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                         </select>
                      </div>
                      <div class="col-md-12">
                         <div class="form-floating">
                            <textarea
                               class="form-control"
                               name="message"
                               placeholder="Leave a comment here"
                               id="floatingTextarea"
                            ></textarea>
                            <label for="floatingTextarea">Comments</label>
                         </div>
                      </div>
                      <div class="input-box col-12">
                         <button class="btn-custom" type="submit"><span>@lang('Submit')</span></button>
                      </div>
                   </div>
                </form>
             </div>
          </div>
       </div>
    </div>
 </div>
