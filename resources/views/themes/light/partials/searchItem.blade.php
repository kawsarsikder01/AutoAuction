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
                      <input type="text" class="form-control" name="name" placeholder="Search" />
                   </div>
                   <div class="input-box col-xl-2">
                      <select class="js-example-basic-single form-control" name="category">
                         <option value="">Select Category</option>
                          @foreach($categories as $categorie)
                              <option value="{{$categorie->id}}">{{$categorie->name}}</option>
                          @endforeach
                      </select>
                   </div>
                   <div class="input-box col-xl-2">
                      <select class="js-example-basic-single form-control" name="brand">
                         <option value="">Select Brand</option>
                         @foreach($brands as $brand)
                              <option value="{{$brand->id}}">{{$brand->name}}</option>
                         @endforeach
                      </select>
                   </div>
                   <div class="input-box col-xl-2">
                      <select class="js-example-basic-single form-control" name="status">
                         <option value="">Select Status</option>
                         <option value="1">Sold</option>
                         <option value="0">Unsold</option>

                      </select>
                   </div>
                   <div class="input-box col-xl-2">
                      <button class="btn-custom w-100"><i class="fal fa-search"></i> Filter</button>
                   </div>
                </div>
             </form>
          </div>
       </div>
    </div>
 </div>

 <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
       <h5 class="offcanvas-title" id="offcanvasRightLabel">Offcanvas right</h5>
       <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">...</div>
 </div>
