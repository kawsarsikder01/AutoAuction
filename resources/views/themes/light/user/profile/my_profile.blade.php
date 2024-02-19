@extends($theme.'layouts.user')
@section('title',trans('Profile'))
@section('content')
<div class="container-fluid">
   <div class="main row">
      <div class="col-12">
         <div class="dashboard-heading">
            <h4 class="mb-0">Edit Profile</h4>
         </div>
         <section class="profile-setting">
            <div class="row g-4 g-lg-5">
               <div class="col-xl-4">
                  <div class="sidebar-wrapper">
                     <form method="post" action="{{ route('user.profile.update.image') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="profile">
                           <div class="img">
                              <img id="profile" src="{{getFile(Auth::user()->image_driver, Auth::user()->image)}}" alt="" class="img-fluid" />
                              <span class="upload-img">
                                 <i class="fal fa-camera"></i>
                                 <input
                                    class="form-control"
                                    name="image"
                                    accept="image/*"
                                    type="file"
                                    onchange="previewImage('profile')"
                                 />
                              </span>
                           </div>
                           <div class="text">
                              <h5 class="name">{{Auth::user()->firstname. ' ' .Auth::user()->lastname}}</h5>
                              <span>{{'@'.Auth::user()->username}}</span>
                           </div>
                           <button type="submit" class="btn-custom">@lang('Update')</button>
                        </div>
                     </form>
                     <div class="profile-navigator nav" id="nav-tab" role="tablist">
                        <button
                           class="tab {{$errors->all() || session('kycForm')?$errors->has('profile') || $errors->has('profileImage') ?'active':'':'active'}}"
                           id="profile-info-tab"
                           data-bs-toggle="tab"
                           data-bs-target="#profile-info"
                           type="button"
                           role="tab"
                           aria-controls="profile-info"
                           aria-selected=""
                        >
                           <i class="fal fa-user"></i>
                           @lang('Profile Information')
                        </button>
                        <button
                           class="tab {{$errors->has('password')? 'active':''}}"
                           id="password-setting-tab"
                           data-bs-toggle="tab"
                           data-bs-target="#password-setting"
                           type="button"
                           role="tab"
                           aria-controls="password-setting"
                           aria-selected="false"
                        >
                           <i class="fal fa-key"></i>
                           @lang('Password Setting')
                        </button>
                         @foreach($kyc as $key => $value)

                             <button
                                 class="tab {{$errors->has($value->name) || session('kycForm') ==$value->name? 'active':''}} {{session($value->name)?'active':''}} "
                                 id="{{'#tab-'.$key.'-tab'}}"
                                 data-bs-toggle="tab"
                                 data-bs-target="{{'#tab-'.$key}}"
                                 type="button"
                                 role="tab"
                                 aria-controls="{{'#tab-'.$key}}"
                                 aria-selected="false"
                             >
                                 <i class="fal fa-id-card"></i>
                                 @lang(ucfirst($value->name))
                             </button>
                         @endforeach
                     </div>
                  </div>
               </div>
               <div class="col-xl-8">
                  <div class="tab-content content" id="nav-tabContent">
                          <div
                              class="tab-pane fade {{$errors->all() || session('kycForm')?$errors->has('profile')|| $errors->has('profileImage')?'show active':'':'show active'}}"
                              id="profile-info"
                              role="tabpanel"
                              aria-labelledby="profile-info-tab"
                          >
                        <form  action="{{ route('user.profile.update')}}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                           <div class="row g-4">
                              <div class="input-box col-md-6">
                                 <label>First name</label>
                                 <input type="text" class="form-control" value="{{ old('first_name', $user->firstname) }}" name="first_name" placeholder="Mr. John" autocomplete="off"/>
                                 @if($errors->has('first_name'))
                                    <div class="error text-danger">@lang($errors->first('first_name')) </div>
                                 @endif
                              </div>
                              <div class="input-box col-md-6">
                                 <label>last name</label>
                                 <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $user->lastname) }}" placeholder="Doe" autocomplete="off" />
                                 @if($errors->has('last_name'))
                                    <div class="error text-danger">@lang($errors->first('last_name')) </div>
                                 @endif
                              </div>
                              <div class="input-box col-md-6">
                                 <label>username</label>
                                 <input type="text" name="username" class="form-control" value=" {{ old('username', $user->username) }}" placeholder="johndoe"  autocomplete="off"/>
                                 @if($errors->has('username'))
                                    <div class="error text-danger">@lang($errors->first('username')) </div>
                                 @endif
                              </div>
                              <div class="input-box col-md-6">
                                 <label>email address</label>
                                 <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email', $user->email) }}"
                                    class="form-control"
                                    placeholder="example@gmail.com"
                                    autocomplete="off"
                                 />
                                 @if($errors->has('email'))
                                    <div class="error text-danger">@lang($errors->first('email')) </div>
                                 @endif
                              </div>
                              <div class="input-box col-md-6">
                                 <label>phone number</label>
                                 <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control" placeholder="01234567891" autocomplete="off" />
                                 @if($errors->has('phone'))
                                    <div class="error text-danger">@lang($errors->first('phone')) </div>
                                 @endif
                              </div>
                              <div class="input-box col-md-6">
                                 <label>preferred language</label>
                                 <select
                                    class="js-example-basic-single form-control"
                                    name="language_id"
                                 >
                                 <option value="" disabled>@lang('Select Language')</option>
                                 @foreach($languages as $la)
                                     <option value="{{$la->id}}"
                                         {{ old('language_id', $user->language_id) == $la->id ? 'selected' : '' }}>@lang($la->name)</option>
                                 @endforeach
                                 </select>
                              </div>
                              <div class="input-box col-12">
                                 <label>address</label>
                                 <textarea
                                    class="form-control"
                                    cols="30"
                                    rows="3"
                                    name="address"
                                    placeholder="457 Morningview, New York USA"
                                 >{{ old('address', $user->address_one) }}</textarea>
                                 @if($errors->has('address'))
                                 <div class="error text-danger">@lang($errors->first('address')) </div>
                                 @endif
                              </div>
                              <div class="input-box col-12">
                                 <button class="btn-custom">@lang('Submit')</button>
                              </div>
                           </div>
                        </form>
                     </div>
                          <div
                              class="tab-pane fade {{$errors->has('password')?'show active':''}}"
                              id="password-setting"
                              role="tabpanel"
                              aria-labelledby="password-setting-tab"
                          >
                        <form action="{{ route('user.updatePassword') }}" method="post">
                           @csrf
                           <div class="row g-4">
                              <div class="input-box col-md-6">
                                 <label>Current Password</label>
                                 <input type="password" name="current_password" class="form-control"  autocomplete="off" />
                                 @if($errors->has('current_password'))
                                    <div class="error text-danger">@lang($errors->first('current_password')) </div>
                                 @endif
                              </div>
                              <div class="input-box col-md-6">
                                 <label>New Password</label>
                                 <input type="password" name="password" class="form-control" placeholder="" autocomplete="off"/>
                                 @if($errors->has('password'))
                                    <div class="error text-danger">@lang($errors->first('password')) </div>
                                 @endif
                              </div>
                              <div class="input-box col-md-6">
                                 <label>Confirm Password</label>
                                 <input type="password" name="password_confirmation" class="form-control" placeholder="" autocomplete="off"/>
                                 @if($errors->has('password_confirmation'))
                                    <div class="error text-danger">@lang($errors->first('password_confirmation')) </div>
                                 @endif
                              </div>
                              <div class="input-box col-12">
                                 <button type="submit" class="btn-custom">@lang('change password')</button>
                              </div>
                           </div>
                        </form>
                     </div>
                     @forelse($kyc as $kyc_key => $item)

                              <div class="tab-pane fade {{$errors->has($item->name) || session('kycForm') ==$item->name ?'show active':''}} "
                                   id="tab-{{$kyc_key}}"
                                   role="tabpanel"
                                   aria-labelledby="tab-{{$kyc_key}}-tab" >
                                  <div class="alert mb-0">

                                      <form action="{{ route('user.kyc.verification.submit') }}" method="post"
                                            enctype="multipart/form-data">
                                          @csrf
                                          <div class="row g-4">
                                              <input type="hidden" name="type" value="{{ $item->id }}">
                                              @foreach($item->input_form as $k => $value)

                                                  @if($value->type == "text")
                                                      <div class="input-box col-md-12">
                                                          <label for="">{{ $value->field_label }}</label>
                                                          <input type="text" class="form-control"
                                                                 name="{{ $value->field_name }}"
                                                                 placeholder="{{ $value->field_label }}" autocomplete="off"/>
                                                          @if($errors->has($value->field_name))
                                                              <div
                                                                  class="error text-danger">@lang($errors->first($value->field_name)) </div>
                                                          @endif
                                                      </div>
                                                  @endif
                                                  @if($value->type == "number")
                                                      <div class="input-box col-md-12">
                                                          <label for="">{{ $value->field_label }}</label>
                                                          <input type="text" class="form-control"
                                                                 name="{{ $value->field_name }}"
                                                                 placeholder="{{ $value->field_label }}" autocomplete="off"/>
                                                          @if($errors->has($value->field_name))
                                                              <div
                                                                  class="error text-danger">@lang($errors->first($value->field_name)) </div>
                                                          @endif
                                                      </div>
                                                  @endif
                                                  @if($value->type == "date")
                                                      <div class="input-box col-md-12">
                                                          <label for="">{{ $value->field_label }}</label>
                                                          <input type="date" class="form-control"
                                                                 name="{{ $value->field_name }}"
                                                                 placeholder="{{ $value->field_label }}" autocomplete="off"/>
                                                          @if($errors->has($value->field_name))
                                                              <div
                                                                  class="error text-danger">@lang($errors->first($value->field_name)) </div>
                                                          @endif
                                                      </div>
                                                  @endif

                                                  @if($value->type == "textarea")
                                                      <div class="input-box col-md-12">
                                                          <label for="">{{ $value->field_label }}</label>
                                                          <textarea class="form-control" id="" cols="30" rows="10"
                                                                    name="{{ $value->field_name }}"></textarea>
                                                          @if($errors->has($value->field_name))
                                                              <div
                                                                  class="error text-danger">@lang($errors->first($value->field_name)) </div>
                                                          @endif
                                                      </div>
                                                  @endif

                                                  @if($value->type == "file")
                                                      <div class="input-box col-12">
                                                          <label for="">{{ $value->field_label }}</label>
                                                          <div class="attach-file">
                                             <span class="prev"> <i
                                                     class="fa-duotone fa-link"></i> </span>
                                                              <input class="form-control" accept="image/*"
                                                                     name="{{ $value->field_name }}" type="file"/>
                                                              @if($errors->has($value->field_name))
                                                                  <div
                                                                      class="error text-danger">@lang($errors->first($value->field_name)) </div>
                                                              @endif
                                                          </div>
                                                      </div>

                                                  @endif

                                              @endforeach


                                              <div class="input-box col-12">
                                                  <button type="submit" class="btn-custom">@lang('Submit')</button>
                                              </div>
                                          </div>
                                      </form>
                                  </div>
                              </div>
                        @empty
                        @endforelse
                  </div>
               </div>
            </div>
         </section>
      </div>
   </div>
</div>
@endsection


