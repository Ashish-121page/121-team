  <!-- Modal -->
  <div class="modal fade" id="BuyerModal" tabindex="-1" aria-labelledby="BuyerModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="background-color:blueviolet">
      <div class="modal-content" style="margin-top:50%;">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="BuyerModalLabel">Enter Buyer Name</h1>
          {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
        </div>
        <div class="modal-body w-100">
          <div class="dropdown">
            <h5> Buyer Name</h5>
            <select class="form-select" aria-label="Default select example">
              <option selected>Open this select menu</option>
              <option value="1">One</option>
              <option value="2">Two</option>
              <option value="3">Three</option>
            </select>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          {{-- <form id="proceedForm" action="{{ route('panel.invoice.secondview') }}" method="GET">
            @csrf <!-- Add CSRF token for Laravel forms -->
            <button type="submit" class="btn btn-primary ml-auto">Proceed</button>
        </form> --}}
          {{-- <button type="submit"  class="btn btn-primary ml-auto">Proceed</button>
          <a href="{{ route('panel.invoice.index')}}" --}}

          <button onclick="proceedToSecondView()" class="btn btn-primary ml-auto">Proceed</button>
          {{-- <a href="{{ route('panel.invoice.index') }}" class="btn btn-secondary ml-auto">Go to Invoice Index</a> --}}
      
      
      
      </div>
    </div>
  </div>

  <script>
    function proceedToSecondView() {
        // Redirect to the route for second view
        window.location.href = "{{ route('panel.Documents.secondview') }}";
    }
  </script>
