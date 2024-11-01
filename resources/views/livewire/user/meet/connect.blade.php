@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"
        integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        /* Custom Styles */
        body {
            background-color: #f5f7fa;
        }

        .meeting-card {
            position: relative;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            height: 400px;
        }

        .btn-circle {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
        }

        .bottom-buttons {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
        }

        .connect-panel {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
@endpush

<div class="container my-5">
    <div class="row">
        <!-- Left: Meeting Card (70% of the grid) -->
        <div class="col-md-8">
            <div class="meeting-card">
                <h3 class="text-center mb-4">Meeting Room</h3>
                <!-- Content of the meeting room goes here -->

                <!-- Bottom center: Microphone and Camera buttons -->
                <div class="bottom-buttons d-flex">
                    <button type="button" class="btn btn-circle btn-primary mx-2">
                        <i class="bi bi-mic-fill"></i>
                    </button>
                    <button type="button" class="btn btn-circle btn-danger mx-2">
                        <i class="bi bi-camera-video-fill"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Right: Connect Panel (30% of the grid) -->
        <div class="col-md-4">
            <div class="connect-panel">
                <h5>Request Connect</h5>
                <button type="button" class="btn btn-success mt-3">Connect</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <!-- Bootstrap and Icons Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"
        integrity="sha512-7Pi/otdlbbCR+LnW+F7PwFcSDJOuUJB3OxtEHbg4vSMvzvJjde4Po1v4BR9Gdc9aXNUNFVUY+SK51wWT8WF0Gg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
@endpush
