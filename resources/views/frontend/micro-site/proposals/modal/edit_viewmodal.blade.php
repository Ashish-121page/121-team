
  <!-- Modal -->
  <div class="modal fade" id="edit_view" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="edit_view_Label" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content modal-fullscreen">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="edit_view_Label">View</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @php
                 $items = $added_products;
                 
                 foreach ($items as $products) 
          
            @endphp
            <iframe src="{{ route('panel.products.edit', $products->id) }}" frameborder="0" style="width: 100%; height: 100vh;"></iframe>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary">Understood</button>
        </div>
      </div>
    </div>
  </div>