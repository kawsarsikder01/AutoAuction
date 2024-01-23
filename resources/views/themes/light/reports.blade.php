@extends($theme.'layouts.user')
@section('title',trans('Bidding History'))
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
                      <th scope="col">No</th>
                      <th scope="col">Subject</th>
                      <th scope="col">Reporter</th>
                      <th scope="col">Reported User</th>
                      <th scope="col">Action</th>
                   </tr>
                </thead>
                <tbody>
                    @forelse($reports as $key => $report)
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
                            <a href="{{route('user.get.conversation',$report->id)}}" class="btn-action-icon bg-warning">
                                <i class="fa-brands fa-rocketchat"></i>
                            </a>
                         </td>
                    </tr>
                @empty
                    <tr class="text-center">
                        <td>{{__('No Data Found!')}}</td>
                    </tr>
                @endforelse
                </tbody>
             </table>

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
