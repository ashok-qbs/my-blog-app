<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">File Manager</h4>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div id="fileManager" style="width: 100%;">
                    <button class="btn btn-primary" onclick="attachFileManager()">Open File Manager</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="module">

    // In real app replace with:
    // import Flmngr from "flmngr";
    import Flmngr from "https://cdn.skypack.dev/flmngr";

    Flmngr.load({
        apiKey: "FLMNFLMN",
        urlFileManager: 'https://fm.n1ed.com/fileManager',
        urlFiles: 'https://fm.n1ed.com/files',
        allowDownload: true
    }, {
        onFlmngrLoaded: () => {
            attachFileManager();
        }
    });

    window.attachFileManager = function () {
        // let elLoading = document.getElementsByClassName("loading-full-screen")[0];
        let elLoading = document.getElementById('fileManager')
        // elLoading.parentElement.removeChild(elLoading);

        Flmngr.open({
            isMultiple: null,
            isMaximized: true,
            showCloseButton: true,
            showMaximizeButton: false,
            hideFiles: [
                "index.php",
                ".htaccess",
                ".htpasswd"
            ],
            hideDirs: [
                "vendor"
            ],
            allowDownload: true
        });
    }
</script>