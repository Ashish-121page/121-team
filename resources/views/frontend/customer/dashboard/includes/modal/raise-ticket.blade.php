<div class="modal fade" id="ticketRaiseModal" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{ route('panel.support_ticket.store') }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Raise a new ticket</h5>
                    <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close"
                        style="padding: 0px 20px;font-size: 20px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="subject" class="form-label">Subject:</label>
                                <select required name="subject" class="form-control" id="subject">
                                    <option value="" aria-readonly="true">Select Subject</option>
                                    @foreach (getSubjectOptions() as $subject)
                                        <option value="{{ $subject['name'] }}">{{ $subject['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="subject" class="form-label">Prioirty</label>
                                <select required name="priority" class="form-control" id="subject">
                                    <option value="" aria-readonly="true">Select Prioirty</option>
                                    @foreach (getPriorityStatus() as $priority)
                                        <option value="{{ $priority['name'] }}">{{ $priority['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="message" class="form-label">Explain Problem/Referenece URL:</label>
                                <textarea name="message" required class="form-control" id="message" rows="5" placeholder="Share URL of error snapshot & Nature of problem for quick resolution"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="message" class="form-label">Add Attachment:</label>
                                <input type="file" class="form-control" name="attachment" id="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </div>
        </form>
    </div>
</div>


