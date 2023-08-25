
<div class="modal fade" id="category_type_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content change-color">
            <div class="modal-header">
                <h5 class="modal-title category_type_modal_title" id="exampleModalLabel">ADD CATEGORY TYPE</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="category_type_container">
                        <x-forms.input label="Name" name="name" required simple/>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn btn-dark" data-bs-dismiss="modal">Close</button>
                <button type="button" id="save_category_type_button" class="btn btn-primary">
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
