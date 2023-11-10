<div id="animatedModal3">
    <div id="btn-close-modal3" class="close-animatedModal3 custom-spacing" style="color:black; font-size: 1.5rem; ">
        <i class="far fa-times-circle fa-rotate-270 fa-lg "></i>
    </div>
    <div class="modal-content custom-spacing" style="background-color:#f3f3f3; height: 80%; width: 80%;">



        <div class="col-12">
            <iframe src="{{ route('panel.settings.index',encrypt(auth()->id())) }}" frameborder="0" style="width: 100%;height: 100%;"></iframe>
        </div>




    </div>
</div>