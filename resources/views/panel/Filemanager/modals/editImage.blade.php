<!-- Modal -->
<div class="modal fade" id="editImage" tabindex="-1" aria-labelledby="editImageLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editImageLabel">Edit Image</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <div class="row">
                <div class="col-3" style="object-fit: contain">
                    <span class="text-center d-block">Original</span>
                    <img src="https://picsum.photos/300" alt="Demo Image" id="editOgimage_path" style="height: 100%; width: 100%">
                    <input type="hidden" id="old_path" >
                </div>
                <div class="col-6">
                    <div class="row">
                        {{-- Nav pills --}}
                        <div class="col-12">
                            <ul class="nav  justify-content-center nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link btn active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Background</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link btn" id="cropimgbtn" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Crop</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link btn" id="imagefilterbtn" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Filter</button>
                                </li>
                            </ul>
                        </div>

                          <div class="col-12">
                            <div class="tab-content" id="pills-tabContent">

                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">

                                    <div class="col-4">
                                        <a class="btn btn-outline-primary" id="removebgbtn" role="button" href="#removebg">Remove Background</a>
                                    </div>

                                    <div class="col-8 d-flex mt-3">
                                            <span class="changecolorbtn" data-color="#6666cc"></span>
                                            <span class="changecolorbtn" data-color="#f1f1f1"></span>
                                            <span class="changecolorbtn" data-color="#111111"></span>
                                            <span class="changecolorbtn" data-color="#cccccc"></span>

                                            <div class="wrapper-color">
                                                <input type="color" id="colorPicker" value="#800080">
                                            </div>
                                    </div>


                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="cropimgbtn" tabindex="0">
                                    Crop Image
                                </div>
                                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="imagefilterbtn" tabindex="0">
                                    Filter Image
                                </div>

                              </div>
                          </div>


                    </div>
                </div>


                <div class="col-3 d-none" id="editpreview" style="object-fit: contain">
                    <span class="text-center d-block">Edited</span>
                    <img src="https://picsum.photos/300" alt="Demo Image" id="editpreviewimage" style="height: 100%; width: 100%">
                </div>

            </div>

        </div>
        <div class="modal-footer">
          <button type="button" id="closeimageeditmodal" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="downloadimage">Save changes</button>
        </div>
      </div>
    </div>
  </div>
