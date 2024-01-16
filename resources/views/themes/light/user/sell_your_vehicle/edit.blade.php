@extends($theme.'layouts.user')
@section('title',trans('Sell a Car'))
@section('content')      <!-- main -->
   <div class="container-fluid">
      <div class="main row">
         <div class="col-12">
            <div class="dashboard-heading">
               <h4 class="mb-0">Edit Your Vehicle</h4>
            </div>
            <section class="profile-setting">
               <form action="{{route('user.update.vehicle',$vehicle->id)}}" enctype="multipart/form-data"  method="POST">
                  @csrf
                  <div class="row g-4 g-lg-5">
                     <div class="col-lg-8">
                        <div class="card-box">
                           <div class="row g-4">
                              <div class="input-box col-md-12">
                                 <label for="Title">Title</label>
                                 <input type="title" name="title" value="{{ old("title",optional($vehicle->details)->title) }}" class="form-control" placeholder="Title" />
                                  @error("title")
                                  <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                              </div>
                              <div class="input-box col-md-12">
                                 <label for="VehicleType">Vehicle Type</label>
                                 <input type="text" name="vehicle_type" value="{{ old('vehicle_type',optional($vehicle->details)->vehicle_type) }}" class="form-control" placeholder="Vehicle Type" />
                                  @error("vehicle_type")
                                  <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                              </div>
                              <div class="input-box col-md-12">
                                 <label for="EngineType">Engine Type</label>
                                 <input type="text" name="engine_type" value="{{ old('engine_type',optional($vehicle->details)->engine_type) }}" class="form-control" placeholder="Engine Type" />
                                  @error("engine_type")
                                  <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                              </div>
                              <div class="input-box col-md-6">
                                 <label for="power">Power</label>
                                 <input type="text" name="power" value="{{ old('power',optional($vehicle->details)->power) }}" class="form-control" placeholder="Power" />
                                  @error("power")
                                  <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                              </div>
                              <div class="input-box col-md-6">
                                 <label for="torque">Torque</label>
                                 <input type="text" name="torque" value="{{ old('torque',optional($vehicle->details)->torque) }}" class="form-control" placeholder="Torque" />
                                  @error("torque")
                                  <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                              </div>
                              <div class="input-box col-md-6">
                                 <label for="displacement">Displacement</label>
                                 <input type="text" name="displacement" value="{{ old('displacement',optional($vehicle->details)->displacement) }}" class="form-control" placeholder="Displacement" />
                                  @error("displacement")
                                  <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                              </div>
                              <div class="input-box col-md-6">
                                 <label for="transmission">Transmission</label>
                                 <input type="text" name="transmission" value="{{ old('transmission',optional($vehicle->details)->transmission) }}" class="form-control" placeholder="Transmission" />
                                  @error("transmission")
                                  <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                              </div>
                              <div class="input-box col-md-12">
                                 <label for="testResult">C/D Test Results</label>
                                  <textarea id="testResult" name="testResult">{{ old('testResult',optional($vehicle->details)->test_result) }}</textarea>
                                  @error("testResult")
                                  <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                              </div>
                              <div class="input-box col-md-12">
                                 <label for="dimensions">Dimensions</label>
                                  <textarea id="dimensions" name="dimensions">{{ old('dimensions',optional($vehicle->details)->dimension) }}</textarea>
                                  @error("dimensions")
                                  <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                              </div>
                              <div class="input-box col-md-12">

                                 <label for="ShortDescription">Short Description</label>
                                  <textarea id="shortDescription" name="shortDescription">{{ old('shortDescription',optional($vehicle->details)->short_description) }}</textarea>
                                  @error("shortDescription")
                                  <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                              </div>
                              <div class="input-box col-md-12">
                                 <label for="Description">Description</label>
                                  <textarea id="description" name="description"> {{ old('description',optional($vehicle->details)->description) }}</textarea>
                                  @error("description")
                                  <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                              </div>
                           </div>
                        </div>
                        @php
                            $appUrl = request()->root()
                        @endphp
                        <div class="card-box mt-4">
                            <div class="input-box col-md-12" id="inputImage" data-id="{{$vehicle->id}}" data-app-url="{{$appUrl}}">
                                <div class="input-field">
                                    <label class="active mb-2" for="carImage" >Car Images</label>
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

                                         <label for="InitialPrice" class="form-label  ">@lang("Initial Price")</label>
                                         <div class="input-group mb-3">
                                             <input type="number" class="form-control" value="{{old('price',optional($vehicle->details)->price)}}" name="price" placeholder="Initial Price" aria-label="Initial Price" aria-describedby="InitialPrice">
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
                                     <label for="torque">Auction Ending Date</label>
                                     <input type="text" name="auction_ending_date" value="{{old('auction_ending_date',optional($vehicle->details)->auction_ending_date)}}" class="form-control" id="datetimepicker" placeholder="Auction Ending Date">
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
                                         <option value="{{$item->id}}" @selected($item->id == $vehicle->brand_id?true:false)>{{$item->name}}</option>
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
                                         <option value="{{$item->id}}" @selected($item->id == $vehicle->category_id?true:false)>{{$item->name}}</option>
                                     @endforeach
                                 </select>
                                 <small>Add this Category to a collection so it’s easy to find in your store.</small>
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
    <script src="{{asset($themeTrue.'js/image-uploader.js')}}"></script>
    <script src="{{asset('assets/admin/js/hs-file.min.js')}}"></script>
    hs-file.min
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
             placeholder: 'C/D Test Results.',
             height: 160,
             callbacks: {
                 onBlurCodeview: function () {
                     let codeviewHtml = $(this).siblings('div.note-editor').find('.note-codable').val();
                     $(this).val(codeviewHtml);
                 }
             },
         });
         $('#dimensions').summernote({
             placeholder: 'Dimensions',
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
         let id = $("#inputImage").data('id');
         $.ajax({
            url: "{{ route('user.get.image', ':id') }}".replace(':id', id),
            method: 'GET',
            dataType: 'json', // Set the expected data type
            success: function(response) {
                let preloaded = [];
                for(let i =0; i < response.length;i++){
                    preloaded.push({id:i,src:response[i]})
                }

        $('#carImage').imageUploader({
            preloaded: preloaded,
            imagesInputName: 'images',
            preloadedInputName: 'photos',
        });

            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error('Error:', error);
            }
        });

     })

 </script>
 @endpush
