<iframe
    id="map"
    src="{{$contact['single']['map_url']??''}}"
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
                        <h4>@lang('Get Ahold of Us')</h4>
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
                    <form action="{{route('user.store.contact.information')}}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" name="fullname" class="form-control" id="floatingName"
                                           placeholder="@lang('Name')" autocomplete="off"/>
                                    <label for="floatingName">@lang('Full Name')</label>
                                </div>
                            </div>
                            @error("fullname")
                            <span class="invalid-feedback d-block" role="alert">
                           <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input
                                        type="email"
                                        name="email"
                                        class="form-control"
                                        id="floatingInput"
                                        placeholder="@lang('Enter Your Email Address')"
                                        autocomplete="off"
                                    />
                                    <label for="floatingInput">@lang('Email address')</label>
                                </div>
                            </div>
                            @error("email")
                            <span class="invalid-feedback d-block" role="alert">
                           <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" name="subject" class="form-control" id="floatingSubject"
                                           placeholder="@lang('Subject')" autocomplete="offf"/>
                                    <label for="floatingSubject">@lang('Subject')</label>
                                </div>
                            </div>
                            @error("subject")
                            <span class="invalid-feedback d-block" role="alert">
                           <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                            <div class="col-md-12">
                                <div class="form-floating">
                            <textarea
                                class="form-control"
                                name="comment"
                                placeholder="Leave a comment here"
                                id="floatingTextarea"
                            ></textarea>
                                    <label for="floatingTextarea">@lang('Comments')</label>
                                </div>
                            </div>
                            @error("comment")
                            <span class="invalid-feedback d-block" role="alert">
                           <strong>{{ $message }}</strong>
                        </span>
                            @enderror
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
