

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">List</h4>
                </div>

                <a class="btn btn-primary" href="<?= url_to('posts.add.page') ?>"><i
                        class="fa-regular fa-square-plus icon me-2"></i>Add New</a>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="postTable" class="table table-striped" data-toggle="data-table">
                        <thead>

                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>

        // Initialize DataTable
        var table = $('#postTable').DataTable({
            processing: true, // Shows loading message
            serverSide: true, // Enables server-side processing
            ajax: {
                url: "<?= url_to('ajax.category.list') ?>",
                type: "POST",
            }, columns: [
                { data: 'name', title: 'Name' },
                { data: 'category', title: 'Category' },
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
    </script>