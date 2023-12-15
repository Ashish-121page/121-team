  <!-- Modal -->
  <div class="modal fade" id="exporterModal" tabindex="-1" aria-labelledby="exporterLabel" aria-hidden="true">
    <div class="modal-dialog" style="background-color:">
      <div class="modal-content" style="margin-top:0%;">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exporterModalLabel">Exporter Details</h1>
          <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
        </div>
        <div class="modal-body">
          <div class="form-group w-100">
            <div class="row">
              <div class="" style="display:block">

                <label for="expotername" style="width:100%">Exporter Name</label>
                <br>
                <input type="text" style="width:100%" placeholder="Enter">

              </div>
            </div>
            <div class="row">
              <div class="" style="display:block">
                <label for="expotermail" style="width:100%">Email id</label>
                <br>
                <input type="text" style="width:100%" placeholder="Enter">
              </div>
            </div>

            <div class="row">
              <div class="" style="display:block">
                <label for="expoterrefr" style="width:100%">Other Reference</label>
                <br>
                <input type="text" style="width:100%" placeholder="Enter">
              </div>
            </div>
            <div class="row">
              <div class="" style="display:block">
                <label for="expotername" style="width:100%">Address</label>
                <br>
                <input type="text" style="width:100%" placeholder="Enter">
              </div>
            </div>
            <div class="row">
              <div style="display:block">
                <label for="country" style="width:100%">Country</label>
                <br>
                <select id="country" name="country" style="width:100%">
                    <option value="">Select a country</option>
                    <option value="India">India</option>
                    <option value="United States">United States</option>
                    <option value="China">China</option>
                    <option value="United Kingdom">United Kingdom</option>
                    <!-- Add more countries as needed -->
                </select>
            </div>
            
            </div>
            <div class="row">
              <div class="" style="display:block">
                <label for="expotername" style="width:100%">Exporter Reference Id(IEC Code)</label>
                <br>
                <input type="text" style="width:100%" placeholder="Enter">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-between">
          
            <button type="button" class="btn btn-primary" id="saveBtn">Save</button>
      
          <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary ml-auto">Proceed</button> -->
        </div>


      </div>
    </div>
  </div>
