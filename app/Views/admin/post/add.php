<?//= phpinfo(); ?>

<?= view(ADMIN_URL . "/includes/lib_ckeditor") ?>

<?= view(ADMIN_URL . "/includes/lib_filepond") ?>

<link rel="stylesheet" href="<?= b_assets('vendor/selectizeJS/css/selectize.bootstrap5.css') ?>">
<script src="<?= b_assets('vendor/selectizeJS/js/selectize.js') ?>"></script>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Write An Article Below!</h4>
                </div>

                <a class="btn btn-primary" href="<?= url_to('posts.add.page') ?>">
                    <i class="fa-solid fa-backward me-2"></i>Go
                    Back</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 px-3">
                        <div class="form-group">
                            <label class="form-label" for="title">Post Title</label>
                            <input type="text" name="title" class="form-control" id="title" required
                                placeholder="Enter Post Title">
                        </div>
                    </div>
                    <div class="col-lg-6 px-3">
                        <div class="form-group">
                            <label class="form-label" for="category">Select Category</label>
                            <select name="category" id="category" class="select2 form-select">
                                <?= renderCategoryOptions() ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6 px-3">
                        <div class="form-group">
                            <label class="form-label" for="post_slug">Slug</label>
                            <input type="text" name="post_slug" class="form-control" id="post_slug" required>
                        </div>
                    </div>

                    <div class="col-lg-6 px-3">
                        <div class="form-group">
                            <label class="form-label" for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 px-3">
                        <div class="form-group">
                            <label class="form-label" for="content">Post Body</label>
                            <div class="editor-container editor-container_classic-editor editor-container_include-style editor-container_include-block-toolbar editor-container_include-word-count"
                                id="editor-container">
                                <div class="editor-container__editor">
                                    <div id="editor"></div>
                                </div>
                                <div class="editor_container__word-count" id="editor-word-count"></div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1 border-bottom">
                    </div>

                    <div class="col-lg-12 py-3 px-3">
                        <div class="form-group">
                            <label class="form-label" for="summery">Summery</label>
                            <textarea name="summery" id="summery" class="summernote form-control"></textarea>
                        </div>
                    </div>

                    <div class="col-lg-6 px-3">
                        <div class="form-group">
                            <label class="form-label" for="keywords">Meta Keywords</label>
                            <input type="text" name="keywords" class="form-control" id="keywords" required>
                        </div>
                    </div>

                    <div class="col-lg-6 px-3">
                        <div class="form-group">
                            <label class="form-label" for="keywords">Meta Description</label>
                            <input type="text" name="decs" class="form-control" id="decs" required>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <form action="/target" class="dropzone" id="image-uploader"></form>
                    </div>
                    <div id="image-editor-container"></div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <input type="text" id="tags" name="tags">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body float-right">
                <div class="d-flex align-items-center float-end">
                    <button type="clear" class="btn btn-secondary me-3">CLOSE</button>
                    <button type="submit" class="btn btn-primary me-3"><i
                            class="fa-solid fa-floppy-disk me-2"></i>SAVE</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function () {
        const postTitle = $('#title');
        const postSlug = $('#post_slug');

        postTitle.on('keyup', function () {
            let slugValue = $(this).val();
            checkSlug(slugValue).then(function (response) {
                postSlug.val(response.final_slug);
                if (response.status == true) {
                    postSlug.removeClass('is-invalid').addClass('is-valid');
                } else {
                    postSlug.addClass('is-invalid');
                }
            }).catch(function (error) {
                console.error("Error:", error);
            });
        });

        postSlug.on('change', function () {
            let slugValue = $(this).val();
            checkSlug(slugValue).then(function (response) {
                postSlug.val(response.final_slug);
                if (response.status == true) {
                    postSlug.removeClass('is-invalid').addClass('is-valid');
                } else {
                    postSlug.addClass('is-invalid');
                }
            }).catch(function (error) {
                console.error("Error:", error);
            });
        });

        function checkSlug(slug) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: "<?= url_to('ajax.post.slug') ?>",
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




        function init_text_editor(height = 150, wordLimit = 90) {
            $('.summernote').summernote({
                height: height, // Set editor height
                toolbar: [
                    ['para', ['ul', 'ol', 'paragraph']] // Keep only the "para" group
                ],

                callbacks: {
                    onKeyup: function (e) {
                        const maxWords = wordLimit; // Set word limit here
                        const content = $(this).summernote('code'); // Get content from the editor
                        const text = $('<div>').html(content).text(); // Strip HTML tags
                        const words = text.trim().split(/\s+/); // Split into words

                        console.log(words.length);

                        if (words.length > maxWords) {
                            // Truncate content to word limit
                            const truncated = words.slice(0, maxWords).join(' ');
                            $(this).summernote('code', truncated); // Update editor content
                            alert('Word limit reached! Words Limit is : ' + wordLimit);
                        }
                    }
                }
            });
        }


        $(document).on('submit', 'form', function (e) {

            if ($(this).find('.is-invalid').length > 0) {
                e.preventDefault();
            }
        });


        // IMAGE UPLOAD LIB

        // Dropzone.js setup
        // Initialize Dropzone (with custom options)
        const myDropzone = new Dropzone("#image-uploader", {
            url: '<?= url_to('media.post.upload') ?>', // Upload URL
            maxFilesize: 5, // Max file size in MB
            acceptedFiles: 'image/*', // Allow only image files
            addRemoveLinks: true, // Option to remove files
            dictDefaultMessage: "Drag & Drop your images here or click to select",
            dictRemoveFile: "Remove file",
            init: function () {
                this.on("success", function (file, response) {
                    // Handle successful file upload (optionally initialize editor)
                    // You can call a function to initialize your image editor
                    console.log("File uploaded successfully", response);
                    // Initialize the image editor if needed, for example with Filerobot Image Editor
                    if (response && response.fileUrl) {
                        $('#image-editor-container').html('<img src="' + response.fileUrl + '" alt="Uploaded Image">');
                        initImageEditor(response.fileUrl); // Initialize image editor here
                    }
                });

                this.on("error", function (file, errorMessage) {
                    // Handle error on file upload
                    alert("Error uploading file: " + errorMessage);
                });
            }
        });

        // Function to initialize the image editor (Filerobot)
        function initImageEditor(imageUrl) {
            new FilerobotImageEditor(
                document.querySelector('#image-editor-container'),
                {
                    availableTools: ['crop', 'rotate', 'resize', 'filters'],
                    theme: 'light',  // Optional: Use light or dark theme
                    image: imageUrl   // Pass the uploaded image URL to the editor
                }
            );
        }



        $('#tags').selectize({
            plugins: ['remove_button'],
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            create: true, // Allow adding new tags

            createFilter: function (input) {
                // Ensure no duplicates are allowed
                var existingOptions = this.options || {};
                return !Object.keys(existingOptions).some(function (key) {
                    return (
                        existingOptions[key] &&
                        existingOptions[key].text &&
                        existingOptions[key].text.toLowerCase() === input.toLowerCase()
                    );
                });
            },

            load: function (query, callback) {
                if (!query.length) return callback();
                $.ajax({
                    url: '<?= url_to('api.fetch_tags') ?>', // API to fetch tags
                    type: 'GET',
                    data: { q: query },
                    error: function () {
                        callback();
                    },
                    success: function (res) {
                        callback(res.data); // Pass the data to Selectize
                    }
                });
            },
            onOptionAdd: function (value, data) {
                // Save the new tag to the backend

                if (data && data.id) {
                    // This is an existing tag; do nothing
                    return;
                }

                $.ajax({
                    url: '<?= url_to('api.add_tags') ?>', // Endpoint to save the new tag
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ name: value }),
                    success: function (response) {
                        // Optionally handle the server response
                        $('#tags').addClass('is-valid');
                        console.log('Tag added:', response);
                    },
                    error: function () {
                        console.error('Failed to save the new tag.');
                    }
                });
            }
        });



        init_text_editor();

    });
</script>