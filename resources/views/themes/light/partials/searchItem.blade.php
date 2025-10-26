<div class="sec-lines">
    <div class="container h-100">
       <div class="line-item"></div>
       <div class="line-item"></div>
       <div class="line-item"></div>
       <div class="line-item"></div>
       <div class="line-item"></div>
    </div>
 </div>
 <!-- Modal -->
 <div
    class="modal fade"
    id="homeSearchModal"
    tabindex="-1"
    aria-labelledby="homeSearchModalLabel"
    aria-hidden="true"
 >
    <div class="modal-dialog modal-dialog-centered modal-xl">
       <div class="modal-content">
          <div class="modal-body">
             <form action="{{route('filter.vehicle')}}" method="get">
                <div class="row g-3 align-items-end">
                   <div class="input-box col-xl-4">
                      <input type="text" class="form-control" value="{{request()->name}}" name="name" placeholder="@lang('Search')" />
                   </div>
                   <div class="input-box col-xl-2">
                      <select class="js-example-basic-single form-control" name="category">
                         <option value="">@lang('Select Category')</option>
                          @foreach($categories as $categorie)
                              <option value="{{$categorie->id}}" @selected(request()->category == $categorie->id)>@lang($categorie->name)</option>
                          @endforeach
                      </select>
                   </div>
                   <div class="input-box col-xl-2">
                      <select class="js-example-basic-single form-control" name="brand">
                         <option value="">@lang('Select Brand')</option>
                         @foreach($brands as $brand)
                              <option value="{{$brand->id}}" @selected(request()->brand == $brand->id)>@lang($brand->name)</option>
                         @endforeach
                      </select>
                   </div>
                   <div class="input-box col-xl-2">
                      <select class="js-example-basic-single form-control" name="status">
                         <option value="0" @selected(request()->status == 0)>@lang('Select Status')</option>
                         <option value="1" @selected(request()->status == 1)>@lang('Sold')</option>
                         <option value="2" @selected(request()->status == 2)>@lang('Unsold')</option>

                      </select>
                   </div>
                   <div class="input-box col-xl-2">
                      <button class="btn-custom w-100"><i class="fal fa-search"></i> @lang('Filter')</button>
                   </div>
                </div>
             </form>
          </div>
       </div>
    </div>
 </div>
