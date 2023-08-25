<!-- Asset Modal -->
<div class="modal fade" id="asset_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_new_asset_form_title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="add_new_asset_form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class=" col-md-6 asset_name_container">
                            <x-forms.input name="name" id="asset_name" label="Name:" placeholder="Enter asset name" simple></x-forms.input>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="exampleFormControlInput1" class="form-label type_class">
                                <div class="d-flex justify-content-between align-items-end type_container">
                                   <span>Type</span>
                                    <span>
                                        <button type="button" class="btn btn-outline-primary add_new_category_type_button">Add New</button>
                                    </span>
                                </div>

                            </label>
                            <select name="type_id" id="type_id" class="form-select" aria-label="Default select example">
                                <option value="">Select type</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="save_asset_button" class="btn btn-outline-primary">
                      <span class="indicator-label">
                        Save
                       </span>
                            <span id="indicatorProgress" class="indicator-progress d-none">
                        Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                     </span>
                </button>
            </div>
        </div>
    </div>
</div>
