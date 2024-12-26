<form action="<?= url_to('categories.edit', uencode($data['id'])) ?>" method="post">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Blog Category</h1>
            <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                    class="fa-solid fa-xmark"></i></button>
        </div>

        <div class="modal-body overflow-y-auto">
            <div class="row">
                <div class="col-lg-6 px-4">
                    <div class="form-group">
                        <label class="form-label" for="e_category_name">Category Title</label>
                        <input type="text" name="e_category_name" class="form-control" id="e_category_name"
                            value="<?= $data['name'] ?>" required>
                    </div>
                </div>
                <div class="col-lg-6 px-4">
                    <div class="form-group">
                        <label class="form-label" for="e_category_slug">Slug</label>
                        <input type="text" name="e_category_slug" class="form-control" id="e_category_slug"
                            value="<?= $data['slug'] ?>" readonly required>

                        <div class="form-check form-check-inline mx-2 py-2">
                            <input type="checkbox" class="form-check-input edit_slug" id="edit_slug">
                            <label class="form-check-label pl-2" for="edit_slug">Enable Slug Edit (That's Not
                                Recommended)</label>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 px-4">
                    <div class="form-group">
                        <label class="form-label" for="e_category_desc">Description</label>
                        <textarea type="text" name="e_category_desc" class="form-control summernote"
                            value="<?= $data['description'] ?>" id="e_category_desc"
                            required><?= $data['description'] ?></textarea>
                    </div>
                </div>

                <div class="col-lg-6 px-4">
                    <div class="form-group">
                        <label class="form-label" for="e_category_meta_desc">Meta Description</label>
                        <input type="text" name="e_category_meta_desc" class="form-control"
                            value="<?= $data['meta_description'] ?>" id="e_category_meta_desc" required>
                    </div>
                </div>
                <div class="col-lg-6 px-4">
                    <div class="form-group">
                        <label class="form-label" for="e_category_meta_keyword">Meta Keyword</label>
                        <input type="text" name="e_category_meta_keyword" class="form-control"
                            value="<?= $data['meta_keywords'] ?>" id="e_category_meta_keyword" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </div>
</form>