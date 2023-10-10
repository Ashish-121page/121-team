<div class="modal fade" id="UploadImages" role="dialog" aria-labelledby="AccessCodeTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AccessCodeTitle">Upload Image</h5>
                <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close"
                    style="padding: 0px 20px;font-size: 20px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <form action="{{ route('panel.update-profile-img', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="mx-auto text-center">
                        <img src="{{ ($user && $user->avatar) ? $user->avatar : asset('backend/default/default-avatar.png') }}" class=" avatar avatar-md-md rounded-circle" alt="" id="profile-image">
                    </div>
                    <div class="form-group">
                        <label for="avatar" class="form-label">Select profile image</label> <br>
                        <input type="file" required name="avatar" class="form-control" id="avatar" accept="image/jpg,image/png,image/jpeg">
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
