<div class="modal" id="raiseTicketModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form action="{{ route('panel.support_ticket.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    <div class="modal-header">
                        <h5 class="modal-title">Raise a new Ticket</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                        {{-- <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="Close">x</button> --}}
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="subject">Subject:</label>
                            <select required name="subject" class="form-control" id="subject">
                                <option value="" readonly>Select Subject</option>
                                @foreach (getSubjectOptions() as $subject)
                                        <option value="{{ $subject['name'] }}">{{ $subject['name'] }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subject" class="form-label">Priority</label>
                            <select required name="priority" class="form-control" id="subject">
                                <option value="" aria-readonly="true">Select Priority</option>
                                @foreach (getPriorityStatus() as $priority)
                                    <option value="{{ $priority['name'] }}">{{ $priority['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message">Message:</label>
                            <textarea name="message" required class="form-control" id="message" rows="5" placeholder="Enter Message"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="message" class="form-label">Add Attachment:</label>
                            <input type="file" class="form-control" name="attachment" id="">
                        </div>
                        <div class="modal-footer">
                            {{-- <button type="button" class="btn btn-secondary mb-0" data-dismiss="modal">Close</button> --}}
                            <button type="submit" class="btn btn-primary mb-0">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>