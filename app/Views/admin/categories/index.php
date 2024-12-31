<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">List</h4>
                </div>

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategory"><i
                        class="fa-regular fa-square-plus icon me-2"></i> Add New</button>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="categoryTable" class="table table-striped" data-toggle="data-table">
                        <thead>

                        </thead>
                        <tbody>
                            <!-- <tr>
                                <td>Tiger Nixon</td>
                                <td>System Architect</td>
                                <td>Th</td>
                                <td>2011/04/25</td>
                                <td>
                                    <div class="d-flex align-items-center justify-space-between list-user-action">
                                        <a href="#" class="btn btn-icon btn-primary me-2"> <svg class="icon-22"
                                                width="32" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M13.7476 20.4428H21.0002" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                </path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M12.78 3.79479C13.5557 2.86779 14.95 2.73186 15.8962 3.49173C15.9485 3.53296 17.6295 4.83879 17.6295 4.83879C18.669 5.46719 18.992 6.80311 18.3494 7.82259C18.3153 7.87718 8.81195 19.7645 8.81195 19.7645C8.49578 20.1589 8.01583 20.3918 7.50291 20.3973L3.86353 20.443L3.04353 16.9723C2.92866 16.4843 3.04353 15.9718 3.3597 15.5773L12.78 3.79479Z"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path d="M11.021 6.00098L16.4732 10.1881" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                </path>
                                            </svg></a>
                                        <a href="#" class="btn btn-icon btn-danger"> <svg class="icon-22" width="32"
                                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path
                                                    d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </svg> </a>
                                    </div>
                                </td>
                            </tr> -->
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Add -->
    <div class="modal codeingil-modal fade" id="addCategory" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="<?= url_to('categories.add') ?>" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Blog Category</h1>
                        <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                class="fa-solid fa-xmark"></i></button>
                    </div>

                    <div class="modal-body overflow-y-auto">
                        <div class="row">
                            <div class="col-lg-6 px-4">
                                <div class="form-group">
                                    <label class="form-label" for="category_name">Category Title</label>
                                    <input type="text" name="category_name" class="form-control " id="category_name"
                                        required>
                                </div>
                            </div>
                            <div class="col-lg-6 px-4">
                                <div class="form-group">
                                    <label class="form-label" for="category_slug">Slug</label>
                                    <input type="text" name="category_slug" class="form-control" id="category_slug"
                                        required>
                                </div>
                            </div>

                            <div class="col-lg-12 px-4">
                                <div class="form-group">
                                    <label class="form-label" for="category_desc">Description</label>
                                    <textarea type="text" name="category_desc" class="form-control summernote"
                                        id="category_desc" required></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6 px-4">
                                <div class="form-group">
                                    <label class="form-label" for="category_meta_desc">Meta Description</label>
                                    <input type="text" name="category_meta_desc" class="form-control"
                                        id="category_meta_desc" required>
                                </div>
                            </div>
                            <div class="col-lg-6 px-4">
                                <div class="form-group">
                                    <label class="form-label" for="category_meta_keyword">Meta Keyword</label>
                                    <input type="text" name="category_meta_keyword" class="form-control"
                                        id="category_meta_keyword" required>
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
        </div>
    </div>

    <!-- Category Edit -->
    <div class="modal codeingil-modal fade" id="editCategory" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" id="editCategoryHolder">

        </div>
    </div>





</div>

<script>
    $(document).ready(function () {
        const addSlug = $('#category_slug');
        const addCategoryName = $('#category_name');

        const editHolder = $('#editCategoryHolder');

        // category edit constants
        const enableEditSlug = $('#edit_slug');
        let editSlug = $('#e_category_slug');

        // Initialize DataTable
        var table = $('#categoryTable').DataTable({
            processing: true, // Shows loading message
            serverSide: true, // Enables server-side processing
            ajax: {
                url: "<?= url_to('ajax.category.list') ?>",
                type: "POST",
            }, columns: [
                { data: 'name', title: 'Name' },
                { data: 'created_by', title: 'Created By' },
                { data: 'created_at', title: 'Created At' },
                { data: 'actions', title: 'Actions', orderable: false, searchable: false }
            ]
        });

        // Initialize Summernote
        function init_text_editor() {
            $('.summernote').summernote({
                height: 150,
            });
        }

        let editStatus = false;
        $(document).on('change', '#edit_slug', function () {

            if ($(this).is(':checked')) {
                console.log('checked');
                editStatus = true;
            } else {
                console.log('unchecked');
                $('#e_category_name').off('keyup');
                $('#e_category_slug').off('change');
                editStatus = false;
            }
        });

        $(document).on('keyup', '#e_category_name', function () {
            let slugValue = $(this).val();
            editSlug = $('#e_category_slug');
            if (editStatus) {
                console.log(slugValue);
                checkSlug(slugValue).then(function (response) {
                    editSlug.val(response.final_slug);
                    if (response.status == true) {
                        editSlug.removeClass('is-invalid').addClass('is-valid');
                    } else {
                        editSlug.addClass('is-invalid');
                    }
                }).catch(function (error) {
                    console.error("Error:", error);
                });
            }
        });


        $(document).on('change', '#e_category_slug', function () {
            let slugValue = $(this).val();
            if (editStatus) {
                checkSlug(slugValue).then(function (response) {
                    $(this).val(response.final_slug);
                    if (response.status == true) {
                        $(this).removeClass('is-invalid').addClass('is-valid');
                    } else {
                        $(this).addClass('is-invalid');
                    }
                }).catch(function (error) {
                    console.error("Error:", error);
                });
            }
        });


        addCategoryName.on('keyup', function () {
            let slugValue = $(this).val();
            checkSlug(slugValue).then(function (response) {
                addSlug.val(response.final_slug);
                if (response.status == true) {
                    addSlug.removeClass('is-invalid').addClass('is-valid');
                } else {
                    addSlug.addClass('is-invalid');
                }
            }).catch(function (error) {
                console.error("Error:", error);
            });
        });

        addSlug.on('change', function () {
            let slugValue = $(this).val();
            checkSlug(slugValue).then(function (response) {
                addSlug.val(response.final_slug);
                if (response.status == true) {
                    addSlug.removeClass('is-invalid').addClass('is-valid');
                } else {
                    addSlug.addClass('is-invalid');
                }
            }).catch(function (error) {
                console.error("Error:", error);
            });
        });

        // Function to check and generate slug via AJAX
        function checkSlug(slug) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: "<?= url_to('ajax.category.slug') ?>",
                    method: 'POST',
                    data: { slug: slug },
                    success: function (response) {
                        resolve(response);
                    },
                    error: function (xhr, status, error) {
                        reject(error);
                    },
                });
            });
        }

        $('[type="reset"]').on('click', function () {
            // Remove the validation classes
            $('.is-invalid').removeClass('is-invalid');
            $('.is-valid').removeClass('is-valid');
        });

        $(document).on('click', '[data-bs-target="#editCategory"]', function () {
            var ref = $(this).data('ref');
            editHolder.html('');
            $.ajax({
                url: "<?= url_to('ajax.editform') ?>",
                method: "POST",
                data: { ref: ref },
                success: function (response) {
                    editHolder.html(response);
                    init_text_editor();
                }, error: function (xhr, status, error) {
                    console.log(error);
                    editHolder.html('NOT FOUND');
                },
            })
        });

        init_text_editor();

        $(document).on('submit', 'form', function (e) {

            if ($(this).find('.is-invalid').length > 0) {
                e.preventDefault();
            }
        });

    });
</script>