@extends($theme.'layouts.user')
@section('title',trans('Notification Permission'))
@section('content')
    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <form action="{{route('user.notification.permission.update')}}" method="post">
                    @csrf
                   <div class="card">
                       <div class="card-header bg-white">
                           <h5 class="card-header-titled">@lang('Notification Permission')</h5>
                       </div>
                       <div class="card-body">
                           <div class="account-settings-profile-section">
                               <div class="cmn-table mt-20">
                                   <div class="table-responsive">
                                       <table class="table">
                                           <thead>
                                           <tr>
                                               <th  style="width: 45%;" scope="col">Type</th>
                                               <th  scope="col">✉️ Email</th>
                                               <th  scope="col">✉️ SMS</th>
                                               <th  scope="col">🖥 Push</th>
                                               <th  class="text-start" scope="col">@lang('👩🏻‍💻 In App')</th>
                                           </tr>
                                           </thead>
                                           <tbody>
                                           @forelse($allTemplates as $item)
                                               <tr>
                                                   <td data-label="Type">
                                                       <div class="d-flex align-items-center">
                                                           <span>{{$item->name}}</span>
                                                       </div>

                                                   </td>
                                                   <td data-label="✉️ Email">
                                                       <div class="form-check form-switch">
                                                           <input class="form-check-input" type="checkbox"
                                                                  role="switch" name="email_key[]"
                                                                  value="{{$item->template_key ?? ""}}"
                                                                  {{ !$item->email ? 'disabled':'' }}
                                                                  id="emailSwitch"
                                                               {{ in_array($item->template_key, optional($user->notifypermission)->template_email_key ?? []) ? 'checked' : '' }}>
                                                       </div>
                                                   </td>
                                                   <td data-label="✉️ SMS">
                                                       <div class="form-check form-switch">
                                                           <input class="form-check-input" type="checkbox"
                                                                  role="switch" name="sms_key[]"
                                                                  value="{{$item->template_key ?? ""}}"
                                                                  {{ !$item->sms ? 'disabled':'' }}
                                                                  id="smsSwitch"
                                                               {{ in_array($item->template_key, optional($user->notifypermission)->template_sms_key ?? []) ? 'checked' : '' }}>
                                                       </div>
                                                   </td>
                                                   <td data-label="🖥 Browser">
                                                       <div class="form-check form-switch">
                                                           <input class="form-check-input" type="checkbox"
                                                                  role="switch"
                                                                  name="push_key[]"
                                                                  value="{{ $item->template_key ?? "" }}"
                                                                  {{ !$item->push ? 'disabled' : '' }}
                                                                  id="pushSwitch"
                                                               {{ in_array($item->template_key, optional($user->notifypermission)->template_push_key ?? []) ? 'checked' : '' }}>
                                                       </div>
                                                   </td>

                                                   <td data-label="👩🏻‍💻 App">
                                                       <div class="form-check form-switch">
                                                           <input class="form-check-input" type="checkbox"
                                                                  role="switch"
                                                                  name="in_app_key[]"
                                                                  value="{{$item->template_key ?? ""}}"
                                                                  id="appSwitch"
                                                               {{!$item->in_app ? 'disabled':''}}
                                                               {{ in_array($item->template_key, optional($user->notifypermission)->template_in_app_key ?? []) ? 'checked' : '' }}>
                                                       </div>
                                                   </td>
                                               </tr>
                                           @empty
                                               <tr>
                                                   <td class="text-center text-danger" colspan="100%">@lang('No Data Found.')</td>
                                               </tr>
                                           @endforelse
                                           </tbody>
                                       </table>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="card-footer text-end bg-white">
                           <button type="submit" class="btn-custom">Save Changes</button>
                       </div>
                   </div>
             </form>
            </div>
        </div>
    </div>
@endsection
@push('style')
@endpush

