@extends($theme.'layouts.user')
@section('title',trans('KYC Verification'))
@section('content')

    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div class="dashboard-heading">
                    <h4 class="mb-0">@lang('KYC Verification')</h4>
                </div>

                <div class="table-parent table-responsive mt-4">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">@lang('SL')</th>
                            <th scope="col">@lang('Type')</th>
                            <th scope="col">@lang('Status')</th>
                            <th scope="col">@lang('Submitted At')</th>
                            <th scope="col">@lang('Action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($userKycs as $key => $item)
                            <tr>
                                <td data-label="@lang('SL')"><span>{{++$key}}</span></td>
                                <td data-label="@lang('Type')">
                                    <span>{{$item->kyc_type}}</span>
                                </td>
                                <td data-label="@lang('Status')">
                                  @if($item->status == 0)
                                      <span class="badge bg-warning">@lang('Pending')</span>
                                    @elseif($item->status == 1)
                                        <span class="badge bg-success">@lang('Verified')</span>
                                    @elseif($item->status == 2)
                                        <span class="badge bg-primary">@lang('Rejected')</span>
                                  @endif
                                </td>
                                <td data-label="@lang('Submitted At')">
                                    <span>{{dateTime($item->created_at)}}</span>
                                </td>
                                <td data-label="@lang('Action')">
                                    <div class="dropdown">
                                        <button class="action-btn2" type="button" id="verificationAction" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                            <i class="fa-regular fa-ellipsis-stroke-vertical text-primary"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item showVerificationDetails" data-bs-toggle="modal"
                                                   data-bs-target="#exampleModalCenter"
                                                   data-res="{{json_encode($item->kyc_info)}}"
                                                   data-type="{{$item->kyc_type}}"
                                                   href="javascript:void(0)">@lang('View')</a>
                                            </li>
                                            @if($item->status == 2)
                                                <li><a class="dropdown-item showRejectedReason"
                                                       data-bs-target="#RejectedReasonModal"
                                                       data-bs-toggle="modal" data-reason="{{$item->reason}}"
                                                       href="javascript:void(0)">@lang('Reason')</a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if (count($userKycs) == 0)
                        <div class="text-center p-4" >
                            <img  class="dataTables-image mb-3"
                                  id="emptyImage"
                                  src="{{ asset($themeTrue.'img/img/no-data.png') }}"
                                  alt="Image Description">
                            <p class="mb-0">@lang("No Data Found")</p>
                        </div>
                    @endif

                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end mt-4">
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="exampleModalCenter" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalCenterTitle"></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group list-group-flush list-group-no-gutters verificationlistShow">

                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button"class="btn btn-primary" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
    <!-- Modal -->
    <div id="RejectedReasonModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalCenterTitle">@lang('Rejected Reason')</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <p id="rejectedReason"></p>
                </div>
                <div class="modal-footer">
                    <button type="button"class="btn btn-primary" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
@endsection

@push('script')
<script>
    $(document).ready(function (){
        $('.showVerificationDetails').on('click',function(){
            let kycInfo =  $(this).data('res');
            let details = '';
            $('#exampleModalCenterTitle').text($(this).data('type'))
            const verificationShow = $('.verificationlistShow');
            verificationShow.empty();
            $.each(kycInfo, function(key, value) {
                details += `
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5>${value.field_label}</h5>
                                    <ul class="list-unstyled list-py-2 text-body">
                                        <li>${value.field_value}</li>
                                    </ul>
                                </div>
                            </li>`
            });
            verificationShow.append(details);
        })
        $('.showRejectedReason').on('click',function(){
                let reason = $(this).data('reason');
                console.log(reason)
                $('#rejectedReason').text(reason);
        })
    })
</script>
@endpush
@push('style')
    <style>
        #verificationAction{
            padding: 5px 15px;
            border: 1px solid red;
            border-radius: 5px;
        }
        #rejectedReason{
            font-size: 18px;
        }
    </style>
@endpush
