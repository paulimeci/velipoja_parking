<div class="modal fade" id="upload_clients_excel" tabindex="-1"
     aria-hidden="true">
    <div class="modal-dialog app_modal_sm">
        <div class="modal-content">
            <form action="{{ Route('store_upload_clients') }}" method="POST" enctype="multipart/form-data"  onsubmit="showLoading()">
                @csrf
                <div class="modal-header bg-primary-800">
                    <h1 class="modal-title fs-5 text-white" id="exampleModal2">Ngarko liste klientave nga csv, excel etj</h1>
                    <button type="button" class="fs-5 border-0 bg-none text-white" data-bs-dismiss="modal"
                            aria-label="Close"><i class="fa-solid fa-xmark fs-3"></i></button>
                </div>
                <div class="modal-body text-center">
                    <!-- Hidden Field for Kompania -->
                    <div class="form-group" hidden>
                        <label for="id_kompania">Kompania</label>
                        <input type="number" name="id_kompania" class="form-control" value="{{ request('kompania') }}">
                    </div>

                    <!-- Logo Upload -->
                    <div class="form-group">
                        <label for="img_logo">File Excel</label>
                        <input type="file" name="excel" class="form-control">
                        @error('excel')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-light-primary" id="submitButton">Ngarko</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Modern Loading Overlay -->
<div id="loadingOverlay" class="loading-overlay" style="display: none;">
    <div class="loading-spinner">
        <div class="spinner"></div>
        <p class="loading-text">Duke u ngarkuar ...</p>
    </div>
</div>

<style>
    /* Overlay i modernizuar */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        backdrop-filter: blur(8px);
        background: rgba(0, 0, 0, 0.6);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        transition: opacity 0.3s ease-in-out;
    }

    .loading-spinner {
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* Spinner modern me gradient */
    .spinner {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        border: 6px solid transparent;
        border-top: 6px solid #ff3d00;
        border-bottom: 6px solid #ff3d00;
        animation: spin 0.8s linear infinite, pulse 1.5s ease-in-out infinite;
        box-shadow: 0px 4px 10px rgba(255, 61, 0, 0.5);
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Efekt pulsues për spinner-in */
    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.1); opacity: 0.8; }
    }

    /* Tekst me animacion */
    .loading-text {
        font-size: 18px;
        font-weight: bold;
        color: #fff;
        margin-top: 15px;
        text-shadow: 2px 2px 8px rgba(255, 255, 255, 0.2);
        animation: fadeInOut 1.5s infinite ease-in-out;
    }

    @keyframes fadeInOut {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
</style>

<script>
    function showLoading() {
        document.getElementById('loadingOverlay').style.display = 'flex';
        document.getElementById('submitButton').disabled = true;
    }

    function hideLoading() {
        document.getElementById('loadingOverlay').style.display = 'none';
        document.getElementById('submitButton').disabled = false;
    }
</script>

