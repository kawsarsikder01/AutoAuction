@extends($theme.'layouts.user')
@section('title',trans('Create Ticket'))
@section('content')
    <div class="container-fluid" id="create_ticket">
        <div class="main row d-flex align-items-center justify-content-center">
            <div class="col-lg-8 col-sm-10">
                <div class="search-bar">
                    <form class="form-row" action="{{route('user.ticket.store')}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12">
                            <div class="form-group mb-2">
                                <label>@lang('Subject')</label>
                                <input class="form-control" type="text" name="subject"
                                       value="{{old('subject')}}" placeholder="@lang('Enter Subject')">
                                @error('subject')
                                <div class="error text-danger">@lang($message) </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-2">
                                <label>@lang('Message')</label>
                                <textarea class="form-control ticket-box" name="message" rows="5"
                                          id="textarea1"
                                          placeholder="@lang('Enter Message')">{{old('message')}}</textarea>
                                @error('message')
                                <div class="error text-danger">@lang($message) </div>
                                @enderror
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="form-group mb-2">
                                <input type="file" name="attachments[]"
                                       class="form-control "
                                       multiple
                                       placeholder="@lang('Upload File')">

                                @error('attachments')
                                <span class="text-danger">{{trans($message)}}</span>
                                @enderror
                            </div>
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
@endsection
@push('script')
    <script>
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


