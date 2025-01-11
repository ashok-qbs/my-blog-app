<? //= phpinfo(); 
?>

<?= view(ADMIN_URL . "/includes/lib_ckeditor") ?>

<?= view(ADMIN_URL . "/includes/lib_dropzone") ?>

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

        <form action="<?= url_to('posts.add') ?>" method="post" class="form" id="postForm">
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
                                <div class="editor-menu-bar" id="editor-menu-bar"></div>
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
                                <label class="form-label" for="summary">Summery</label>
                                <textarea name="summary" id="summary" class="summernote form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-6 px-3">
                            <div class="form-group">
                                <label class="form-label" for="keywords">Meta Keywords</label>
                                <input type="text" name="meta_keywords" class="form-control" id="keywords" required>
                            </div>
                        </div>

                        <div class="col-lg-6 px-3">
                            <div class="form-group">
                                <label class="form-label" for="keywords">Meta Description</label>
                                <input type="text" name="meta_description" class="form-control" id="decs" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <!-- DROPZONE HERE -->
                            <div class="form-group">
                                <label class="form-label" for="keywords">Post Image</label>
                                <div action="<?= url_to('media.post.upload.temp') ?>" class="my-dropzone"
                                    id="my-dropzone">
                                </div>
                            </div>
                            <style>
                                .my-dropzone {
                                    border: 2px dashed #007bff;
                                    border-radius: 5px;
                                    background: #f8f9fa;
                                    padding: 20px;
                                    text-align: center;
                                    font-size: 16px;
                                    color: #6c757d;
                                }

                                .my-dropzone .dz-message {
                                    font-weight: bold;
                                    color: #007bff;
                                }

                                .my-dropzone .dz-preview .dz-image img {
                                    width: 100%;
                                    height: auto;
                                }

                                .my-dropzone .dz-preview .dz-error-message {
                                    color: #dc3545;
                                }

                                .my-dropzone .dz-preview .dz-success-mark,
                                .my-dropzone .dz-preview .dz-error-mark {
                                    display: none;
                                }
                            </style>

                            <input type="hidden" name="post-image" id="image-upload-url">

                            <button type="button" class="btn btn-primary d-none" data-bs-toggle="modal"
                                data-bs-target="#imageEditor">
                                Launch demo modal
                            </button>
                        </div>

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

        </form>
    </div>

    <div class="modal codeingil-modal fade" id="imageEditor" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="editor_container">
            </div>
        </div>
    </div>


</div>

<script>
    $(document).ready(function() {



        const postTitle = $('#title');
        const postSlug = $('#post_slug');

        postTitle.on('keyup', function() {
            let slugValue = $(this).val();
            checkSlug(slugValue).then(function(response) {
                postSlug.val(response.final_slug);
                if (response.status == true) {
                    postSlug.removeClass('is-invalid').addClass('is-valid');
                } else {
                    postSlug.addClass('is-invalid');
                }
            }).catch(function(error) {
                console.error("Error:", error);
            });
        });

        postSlug.on('change', function() {
            let slugValue = $(this).val();
            checkSlug(slugValue).then(function(response) {
                postSlug.val(response.final_slug);
                if (response.status == true) {
                    postSlug.removeClass('is-invalid').addClass('is-valid');
                } else {
                    postSlug.addClass('is-invalid');
                }
            }).catch(function(error) {
                console.error("Error:", error);
            });
        });

        function checkSlug(slug) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: "<?= url_to('ajax.post.slug') ?>",
                    method: 'POST',
                    data: {
                        slug: slug
                    },
                    success: function(response) {
                        resolve(response);
                    },
                    error: function(xhr, status, error) {
                        reject(error);
                    },
                });
            });
        }

        // DROPZONE + filerobot
        Dropzone.autoDiscover = false;

        var myDropzone = new Dropzone("#my-dropzone", {
            url: "<?= url_to('media.post.upload.temp') ?>", // Set the url for your upload script
            acceptedFiles: "image/*",
            addRemoveLinks: true,
            success: function(file, response) {
                console.log(response);
                $('#imageEditor').modal('show');
                // Initialize Filerobot Image Editor
                var config = {
                    source: response.file_url, // Use the image URL from PHP response
                    onSave: function(editedImageObject, designState) {
                        console.log('saved', editedImageObject, designState);
                        console.log('editedImageObject', editedImageObject);
                        // Handle the edited image after user finishes editing
                        uploadEditedImage(editedImageObject);
                    },
                    onClose: function(closingReason) {
                        console.log('Closing reason', closingReason);
                        $('#imageEditor').modal('hide');
                    },
                    annotationsCommon: {
                        fill: '#ff0000',
                    },
                    Text: {
                        text: 'Filerobot...'
                    },
                    Rotate: {
                        angle: 90,
                        componentType: 'slider'
                    },
                    translations: {
                        profile: 'Profile',
                        coverPhoto: 'Cover photo',
                        facebook: 'Facebook',
                        socialMedia: 'Social Media',
                        fbProfileSize: '180x180px',
                        fbCoverPhotoSize: '820x312px',
                    },
                    Crop: {
                        presetsItems: [{
                                titleKey: 'classicTv',
                                descriptionKey: '4:3',
                                ratio: 4 / 3,
                            },
                            {
                                titleKey: 'cinemascope',
                                descriptionKey: '21:9',
                                ratio: 21 / 9,
                            },
                        ],
                        presetsFolders: [{
                            titleKey: 'socialMedia',
                            groups: [{
                                titleKey: 'facebook',
                                items: [{
                                        titleKey: 'profile',
                                        width: 180,
                                        height: 180,
                                        descriptionKey: 'fbProfileSize',
                                    },
                                    {
                                        titleKey: 'coverPhoto',
                                        width: 820,
                                        height: 312,
                                        descriptionKey: 'fbCoverPhotoSize',
                                    },
                                ],
                            }, ],
                        }, ],
                    },
                    tabsIds: [FilerobotImageEditor.TABS.ADJUST, FilerobotImageEditor.TABS.ANNOTATE, FilerobotImageEditor.TABS.WATERMARK],
                    defaultTabId: FilerobotImageEditor.TABS.ANNOTATE,
                    defaultToolId: FilerobotImageEditor.TOOLS.TEXT,
                };

                var filerobotImageEditor = new FilerobotImageEditor(
                    document.querySelector('#editor_container'),
                    config
                );

                filerobotImageEditor.render({
                    onClose: function(closingReason) {
                        console.log('Closing reason', closingReason);
                        filerobotImageEditor.terminate();
                    },
                });
            },

            removedfile: function(file) {
                // Handle file removal
                $.ajax({
                    url: "", // Endpoint to remove the file
                    method: 'POST',
                    data: {
                        file_name: file.name
                    },
                    success: function(response) {
                        console.log('File removed:', response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to remove file:', error);
                    },
                });
            }
        });

        function uploadEditedImage(imageFile) {
            var formData = new FormData();

            console.log(imageFile);
            formData.append('file', imageFile.imageBase64);

            $.ajax({
                url: "<?= url_to('media.post.upload') ?>",
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);

                    if (response.status) {
                        $('#image-upload-url').val(response.file_url);
                        $('#imageEditor').modal('hide');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                },
            });
        }

        function init_text_editor(height = 150, wordLimit = 90) {
            $('.summernote').summernote({
                height: height, // Set editor height
                toolbar: [
                    ['para', ['ul', 'ol', 'paragraph']] // Keep only the "para" group
                ],

                callbacks: {
                    onKeyup: function(e) {
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


        $(document).on('submit', 'form', function(e) {

            if ($(this).find('.is-invalid').length > 0) {
                e.preventDefault();
            }
        });



        $('#tags').selectize({
            plugins: ['remove_button'],
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            create: true, // Allow adding new tags

            createFilter: function(input) {
                // Ensure no duplicates are allowed
                var existingOptions = this.options || {};
                return !Object.keys(existingOptions).some(function(key) {
                    return (
                        existingOptions[key] &&
                        existingOptions[key].text &&
                        existingOptions[key].text.toLowerCase() === input.toLowerCase()
                    );
                });
            },

            load: function(query, callback) {
                if (!query.length) return callback();
                $.ajax({
                    url: '<?= url_to('api.fetch_tags') ?>', // API to fetch tags
                    type: 'GET',
                    data: {
                        q: query
                    },
                    error: function() {
                        callback();
                    },
                    success: function(res) {
                        callback(res.data); // Pass the data to Selectize
                    }
                });
            },
            onOptionAdd: function(value, data) {
                // Save the new tag to the backend

                if (data && data.id) {
                    // This is an existing tag; do nothing
                    return;
                }

                $.ajax({
                    url: '<?= url_to('api.add_tags') ?>', // Endpoint to save the new tag
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        name: value
                    }),
                    success: function(response) {
                        // Optionally handle the server response
                        $('#tags').addClass('is-valid');
                        console.log('Tag added:', response);
                    },
                    error: function() {
                        console.error('Failed to save the new tag.');
                    }
                });
            }
        });



        init_text_editor();

        $(document).on('submit', '#postForm', function(e) {
            e.preventDefault();

            var editorContent = window.editor.getData();

            if (editorContent.trim() === '') {
                alert('Post Body cannot be empty.');
                return false;
            }

            // Check if a hidden input already exists
            let hiddenInput = this.querySelector('input[name="content"]');
            if (!hiddenInput) {
                hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'content';
                this.appendChild(hiddenInput);
            }

            // Update the hidden input value with editor content
            hiddenInput.value = editorContent;

            this.submit();
        });

    });
</script>