@extends($theme.'layouts.user')
@section('title',trans('Sell Your Vehicle'))
@section('content')      <!-- main -->
   <div class="container-fluid">
      <div class="main row">
         <div class="col-12">
            <div class="dashboard-heading">
               <h4 class="mb-0">Add Your Vehicle</h4>
            </div>
            <section class="profile-setting">
               <form action="{{route('user.listing.vehicle')}}" enctype="multipart/form-data"  method="POST">
                  @csrf
                  <div class="row g-4 g-lg-5">
                     <div class="col-lg-8">
                        <div class="card-box">
                           <div class="row g-4">
                              <div class="input-box col-md-12">
                                 <label for="Title">Title</label>
                                 <input type="title" name="title" value="{{ old('title') }}" class="form-control" placeholder="Title" autocomplete="off" />
                                  @error("title")
                                  <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                              </div>
                              <div class="input-box col-md-12">
                                 <label for="VehicleType">Vehicle Type</label>
                                 <input type="text" name="vehicle_type" value="{{ old('vehicle_type') }}" class="form-control" placeholder="e.g : front-engine, rear-wheel-drive, 4-passenger coupe" autocomplete="off" />
                                  @error("vehicle_type")
                                  <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                              </div>
                              <div class="input-box col-md-12">
                                 <label for="EngineType">Engine Type</label>
                                 <input type="text" name="engine_type" value="{{ old('engine_type') }}" class="form-control" placeholder="e.g : V-8, water-cooled, cast iron block and heads" autocomplete="off" />
                                  @error("engine_type")
                                  <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                              </div>
                              <div class="input-box col-md-6">
                                 <label for="power">Power</label>
                                 <input type="text" name="power" value="{{ old('power') }}" class="form-control" placeholder="e.g : 335 hp @ 5200 rpm" autocomplete="off"/>
                                  @error("power")
                                  <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                              </div>
                              <div class="input-box col-md-6">
                                 <label for="torque">Torque</label>
                                 <input type="text" name="torque" value="{{ old('torque') }}" class="form-control" placeholder="e.g : 440 lb-ft @ 3400 rpm" autocomplete="off" />
                                  @error("torque")
                                  <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                              </div>
                              <div class="input-box col-md-6">
                                 <label for="displacement">Displacement</label>
                                 <input type="text" name="displacement" value="{{ old('displacement') }}" class="form-control" placeholder="e.g : 428 in3, 7002 cm3" autocomplete="off" />
                                  @error("displacement")
                                  <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                              </div>
                              <div class="input-box col-md-6">
                                 <label for="transmission">Transmission</label>
                                 <input type="text" name="transmission" value="{{ old('transmission') }}" class="form-control" placeholder="e.g : 3-speed automatic" autocomplete="off" />
                                  @error("transmission")
                                  <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                              </div>
                              <div class="input-box col-md-12">
                                 <label for="testResult">C/D Test Results</label>
                                  <textarea id="testResult" name="testResult">{{ old('testResult') }}</textarea>
                                  @error("testResult")
                                  <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                              </div>
                              <div class="input-box col-md-12">
                                 <label for="dimensions">Dimensions</label>
                                  <textarea id="dimensions" name="dimensions">{{ old('dimensions') }}</textarea>
                                  @error("dimensions")
                                  <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                              </div>
                              <div class="input-box col-md-12">

                                 <label for="ShortDescription">Short Description</label>
                                  <textarea id="shortDescription" name="shortDescription">{{ old('shortDescription') }}</textarea>
                                  @error("shortDescription")
                                  <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                              </div>
                              <div class="input-box col-md-12">
                                 <label for="Description">Description</label>
                                  <textarea id="description" name="description">{{ old('description') }}</textarea>
                                  @error("description")
                                  <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                              </div>
                           </div>
                        </div>
                        <div class="card-box mt-4">
                            <div class="input-box col-md-12">
                               <label class="mb-2" for="carImage">Vehicle Images</label>
                                <div class="input-field">
                                    <div class="input-images-1" id="carImage" name="images[]" ></div>
                                </div>
                                @error("images.*")
                                <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @error("images")
                                <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                     </div>
                     <div class="col-lg-4">
                        <div class="card-box">
                           <h5>Pricing</h5>
                           <div class="row g-3">
                              <div class="input-box col-12">
                                 <div class="form-group">
                                    <label for="InitialPrice" class="form-label  ">@lang("Bid Start")
                                        <i class="fa-solid fa-question text-body ms-1 fs-6" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Initial Price." data-bs-original-title="Initial Price."></i>
                                    </label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" value="{{old('price')}}" name="price" placeholder="Bid Start" aria-label="Initial Price" aria-describedby="InitialPrice" autocomplete="off">
                                        <span class="input-group-text" id="InitialPrice">{{basicControl()->base_currency}}</span>
                                    </div>
                                     @error("price")
                                         <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                     @enderror
                                </div>
                              </div>
                           </div>
                        </div>
                        <div class="card-box">
                           <h5>Auction Validity</h5>
                           <div class="row g-3">
                              <div class="input-box col-12">
                                  <input type="text" name="auction_ending_date" value="{{old('auction_ending_date')}}" class="form-control" id="datetimepicker" placeholder="Auction Ending Date" autocomplete="off">
                                  @error("last_date")
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                              </div>
                           </div>
                        </div>
                        <div class="card-box mt-4">
                           <h5>Organization</h5>
                           <div class="row g-3">
                              <div class="input-box col-12">
                                 <label for="">Select Brand</label>
                                 <select class="js-example-basic-single form-control" name="brand_id">
                                     @foreach($brand as $item)
                                         <option value="{{$item->id}}">{{$item->name}}</option>
                                     @endforeach
                                 </select>
                                  @error("brand_id")
                                      <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                              </div>
                              <div class="input-box col-12">
                                 <label for="">Select Category</label>
                                 <select class="js-example-basic-single form-control" name="category_id">
                                     @foreach($category as $item)
                                         <option value="{{$item->id}}">{{$item->name}}</option>
                                     @endforeach
                                 </select>
                                  @error("category_id")
                                      <span class="invalid-feedback d-block" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                              </div>
                           </div>
                        </div>

                     </div>
                  </div>
                  <div class="d-flex justify-content-start mt-4">
                     <button type="submit"
                             class="btn btn-primary submit_btn">@lang("Save & Publish")</button>
                 </div>
               </form>
            </section>
         </div>
      </div>
   </div>
@endsection
@push('css-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/summernote-bs5.min.css') }}">
    <link rel="stylesheet" href="{{asset($themeTrue.'css/image-uploader.min.css')}}" />
    <link rel="stylesheet" href="{{asset($themeTrue.'css/image-uploader.css')}}" />
@endpush
@push('js-lib')
    <script src="{{ asset('assets/admin/js/summernote-bs5.min.js') }}"></script>
    <script src="{{asset($themeTrue.'js/image-uploader.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/hs-file.min.js')}}"></script>
@endpush
@push('script')
<script>

     $(document).ready(function () {
         flatpickr('#datetimepicker', { // Enable time selection
             dateFormat: 'Y-m-d',
             minDate: 'today', // Set minimum selectable date to today
             maxDate: new Date().fp_incr(), // Set maximum selectable date to 7 days from now
         });
         // $("#fileUpload").fileUpload();
         $('#testResult').summernote({
         placeholder:   `e.g :
                         Zero to 60 mph: 5.7 sec ,
                         Zero to 100 mph: 14.3 sec ,
                         Standing ¼-mile: 14.3 sec @ 100 mph ,
                         Top speed (est): 115 mph ,
                         Braking, 80-0 mph: 256 ft `,
             height: 160,
             callbacks: {
                 onBlurCodeview: function () {
                     let codeviewHtml = $(this).siblings('div.note-editor').find('.note-codable').val();
                     $(this).val(codeviewHtml);
                 }
             },
         });
         $('#dimensions').summernote({
             placeholder: `
                            e.g :
                            Wheelbase: 108.0 in ,
                            Length: 187.4 in ,
                            Width: 71.3 in ,
                            Height: 51.2 in ,
                            Curb weight: 3607 lb
                            `,
             height: 160,
             callbacks: {
                 onBlurCodeview: function () {
                     let codeviewHtml = $(this).siblings('div.note-editor').find('.note-codable').val();
                     $(this).val(codeviewHtml);
                 }
             },
         });
         $('#shortDescription').summernote({
             placeholder: 'Short Description',
             height: 160,
             callbacks: {
                 onBlurCodeview: function () {
                     let codeviewHtml = $(this).siblings('div.note-editor').find('.note-codable').val();
                     $(this).val(codeviewHtml);
                 }
             },
         });
         $('#description').summernote({
             placeholder: 'Description',
             height: 160,
             callbacks: {
                 onBlurCodeview: function () {
                     let codeviewHtml = $(this).siblings('div.note-editor').find('.note-codable').val();
                     $(this).val(codeviewHtml);
                 }
             },
         });

         $('.input-images-1').imageUploader();

     })

 </script>
 @endpush

