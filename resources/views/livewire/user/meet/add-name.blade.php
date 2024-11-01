@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"
        integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

<div class="container p-10 pt-16">
    <form wire:submit.prevent='save' class="col-md-6 mx-auto">
        <fieldset>
            <legend>Enter Your Name to continue</legend>
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" placeholder="John Doe">
            </div>

            <button type="submit" wire:loading.attr.disabled class="d-flex1 btn gap-2 btn-primary w-full">
                Continue
                <div wire:loading wire:target='save' class="spinner-border text-white spinner-border-sm" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </button>
        </fieldset>
    </form>
</div>
