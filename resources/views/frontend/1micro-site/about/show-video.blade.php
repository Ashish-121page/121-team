<div class="modal fade" id="playVideoModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded shadow-lg border-0 overflow-hidden">
            <div class="modal-header">
                <h5>Video</h5>
                <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close" style="padding: 0px 20px;font-size: 20px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if (isset($story) && @$story['video_link'] != null)
                    {{-- <video autoplay="" loop="" controls="" width="100%">
                        <source type="video/mp4" src="{{ @$story['video_link'] }}">
                    </video>  --}}
                    <iframe width="100%" height="250px" src="{{ @$story['video_link'] }}" frameborder="0"  allowfullscreen></iframe>
                @endif
            </div>
        </div>
    </div>
</div>