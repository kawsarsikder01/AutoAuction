@extends($theme.'layouts.user')
@section('title',trans('Bidding History'))
@section('content')
<div class="container-fluid">
    <div class="main row">
       <div class="col-12">
          <div class="dashboard-heading">
             <h4 class="mb-0">User Bidding History</h4>
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
                    {{-- {{ $tickets->appends($_GET)->links($theme.'partials.pagination') }} --}}
                </ul>
             </nav>
          </div>
       </div>
    </div>
 </div>
@endsection