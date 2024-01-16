<div class="row mb-3">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <label for="NameLabel" class="form-label mb-0">@lang("Content")</label>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#blockModal">@lang("Insert Section")</button>
        </div>
        <textarea class="form-control" name="page_content" id="summernote"
                  rows="20">{{ old("page_content") }}</textarea>
        @error("page_content")
        <span class="invalid-feedback d-block">{{ $message }}</span>
        @enderror
    </div>
</div>




<div class="col-md-12 mt-4 laterShowSlug mb-2">
    <div class="">
        <label for="permalinkLabel" class="form-label">@lang("Permalink")</label>
        <div class="d-inline-flex">
            <div class="default-slug d-flex justify-content-end align-items-center">
                <span class="ps-3"></span>
                <input type="text" class="form-control set-slug" name="slug"
                       id="newSlug" placeholder="@lang("Slug")" autocomplete="off" value="{{ old("slug") }}">
            </div>
        </div>
    </div>
    @error("slug")
    <span class="invalid-feedback d-block">{{ $message }}</span>
    @enderror
</div>