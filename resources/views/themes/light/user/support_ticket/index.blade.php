@extends($theme.'layouts.user')
@section('title',trans('Support Ticket'))
@section('content')
<div class="container-fluid">
    <div class="main row">
       <div class="col-12">
          <div class="dashboard-heading">
             <h4 class="mb-0">Support Ticket</h4>
             <a href="{{route('user.ticket.create')}}" type="button" class="btn-custom"  >
                @lang('Create ticket')
             </a>
          </div>

          <!-- table -->
          <div class="table-parent table-responsive mt-4">
             <div class="table-search-bar">
                <div class="d-none d-lg-block">
                   <form>
                      <div class="row g-3 align-items-end">
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <input type="text" class="form-control" placeholder="Search" />
                         </div>
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <select class="js-example-basic-single form-control" name="propertyType">
                               <option value="type1">Category</option>
                               <option value="type2">England</option>
                               <option value="type3">Pakistan</option>
                               <option value="type4">Palestine</option>
                            </select>
                         </div>
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <select class="js-example-basic-single form-control" name="propertyType">
                               <option value="type1">Category</option>
                               <option value="type2">England</option>
                               <option value="type3">Pakistan</option>
                               <option value="type4">Palestine</option>
                            </select>
                         </div>
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <select class="js-example-basic-single form-control" name="propertyType">
                               <option value="type1">Category</option>
                               <option value="type2">England</option>
                               <option value="type3">Pakistan</option>
                               <option value="type4">Palestine</option>
                            </select>
                         </div>
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <select class="js-example-basic-single form-control" name="propertyType">
                               <option value="type1">Category</option>
                               <option value="type2">England</option>
                               <option value="type3">Pakistan</option>
                               <option value="type4">Palestine</option>
                            </select>
                         </div>
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <button class="btn-custom w-100"><i class="fal fa-search"></i> Filter</button>
                         </div>
                      </div>
                   </form>
                </div>
                <div class="d-lg-none justify-content-end">
                   <button
                      type="button"
                      class="btn-action"
                      data-bs-toggle="modal"
                      data-bs-target="#editModal"
                   >
                      Filter <i class="fa-light fa-filter"></i>
                   </button>
                </div>
             </div>
             <table class="table table-striped">
                <thead>
                   <tr>
                      <th scope="col">Subject</th>
                      <th scope="col">Status</th>
                      <th scope="col">Last Reply</th>
                      <th scope="col">Action</th>
                   </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $key => $ticket)
                    <tr>
                        <td data-label="@lang('Subject')">
                                [{{ trans('Ticket#').$ticket->ticket }}] {{ $ticket->subject }}
                        </td>
                        <td data-label="@lang('Status')">
                            @if($ticket->status == 0)
                                <span class="badge bg-primary">@lang('Open')</span>
                            @elseif($ticket->status == 1)
                                <span class="badge bg-success">@lang('Answered')</span>
                            @elseif($ticket->status == 2)
                                <span class="badge bg-warning">@lang('Replied')</span>
                            @elseif($ticket->status == 3)
                                <span class="badge bg-danger">@lang('Closed')</span>
                            @endif
                        </td>
                        <td data-label="@lang('Last Reply')">
                            {{diffForHumans($ticket->last_reply) }}
                        </td>
                        <td data-label="@lang('Action')">
                            <div>
                               <button
                                  class="btn-action-icon bg-primary"
                                  type="button"
                                  data-bs-toggle="modal"
                                  data-bs-target="#formModal"
                               >
                                  <i class="fad fa-info-circle"></i>
                               </button>
                               <a href="{{ route('user.ticket.view', $ticket->ticket) }}" class="btn-action-icon bg-success">
                                  <i class="fad fa-eye"></i>
                               </a>
                            </div>
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
                    {{ $tickets->appends($_GET)->links($theme.'partials.pagination') }}
                </ul>
             </nav>
          </div>
       </div>
    </div>
 </div>
@endsection
