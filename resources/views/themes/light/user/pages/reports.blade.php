@extends($theme.'layouts.user')
@section('title',trans('Reports'))
@section('content')
<div class="container-fluid">
    <div class="main row">
       <div class="col-12">
          <div class="dashboard-heading">
             <h4 class="mb-0">Reports</h4>
          </div>

          <!-- table -->
          <div class="table-parent table-responsive mt-4">
             <table class="table table-striped">
                <thead>
                   <tr>
                      <th scope="col">@lang('No')</th>
                      <th scope="col">@lang('Subject')</th>
                      <th scope="col">@lang('Reporter')</th>
                      <th scope="col">@lang('Reported User')</th>
                      <th scope="col">@lang('Action')</th>
                   </tr>
                </thead>
                <tbody>
                    @foreach($reports as $key => $report)
                    <tr>
                        <td data-label="@lang('No')">
                                {{$key + 1}}
                        </td>
                        <td data-label="@lang('Subject')">
                            {{$report->subject}}
                        </td>
                        <td data-label="@lang('Reporter')">
                           {{$report->reporter->firstname." ".$report->reporter->lastname}}
                        </td>
                        <td data-label="@lang('Reported User')">
                          {{$report->repotedUser->firstname." ".$report->repotedUser->lastname}}
                        </td>
                        <td data-label="@lang('Action')">
                            <a href="{{route('user.get.conversation',$report->id)}}" data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-title="Message"  class="btn-action-icon bg-warning">
                                <i class="fa-brands fa-rocketchat"></i>
                            </a>
                         </td>
                    </tr>
                @endforeach
                </tbody>
             </table>
             @if (count($reports) == 0)
                  <div class="text-center p-4" >
                      <img  class="dataTables-image mb-3"
                            id="emptyImage"
                            src="{{ asset($themeTrue.'img/img/no-data.png') }}"
                            alt="Image Description">
                      <p class="mb-0">@lang("No Data Found")</p>
                  </div>
                @endif

             <!-- pagination -->
             <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end mt-4">
                     {{ $reports->appends($_GET)->links($theme.'partials.pagination') }}
                </ul>
             </nav>
          </div>
       </div>
    </div>
 </div>
@endsection
