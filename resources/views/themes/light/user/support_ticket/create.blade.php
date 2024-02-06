@extends($theme.'layouts.user')
@section('title',trans('Create Ticket'))
@section('content')
    <div class="container-fluid" id="create_ticket">
        <div class="main row d-flex align-items-center justify-content-center">
            <div class="col-lg-8 col-sm-10">
                <div class="card">
                    <div class="card-header bg-white">
                        <h4 class="card-header-title ">
                            Create Ticket
                        </h4>
                    </div>
                    <div class="card-body">
                        <form class="form-row" action="{{route('user.ticket.store')}}" method="post"
                        enctype="multipart/form-data">
                    @csrf
                    <div class="input-box col-md-12">
                        <label for="subject">@lang('Subject')</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" class="form-control" placeholder="Subject"  autocomplete="off"/>
                        @error("subject")
                        <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                    <div class="input-box col-md-12 mt-2">
                        <label for="message">Message</label>
                        <textarea id="message" name="message">{{ old('message') }}</textarea>
                        @error("message")
                        <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>

                        <div class="input-box col-md-12 mt-4">
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

                    <div class="col-md-12">
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">
                                <span>@lang('Submit')</span></button>
                        </div>
                    </div>
                </form>
                    </div>
                </div>
                
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
        $(document).ready(function (){
            $('#message').summernote({
                placeholder: 'C/D Test Results.',
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
        function copyFunction() {
            var copyText = document.getElementById("referralURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            Notiflix.Notify.Success(`Copied: ${copyText.value}`);
        }
    </script>
@endpush


