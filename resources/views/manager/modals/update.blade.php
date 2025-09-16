<!-- manager.modals.update.blade.php -->

<!-- Edit Item Modals -->
@foreach($items as $item)
<div class="modal fade" id="editItemModal{{ $item->item_id }}" tabindex="-1" aria-labelledby="editItemModalLabel{{ $item->item_id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="{{ route('manager.items.update', $item->item_id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title" id="editItemModalLabel{{ $item->item_id }}">Edit Item</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Item Name</label>
            <input name="name" class="form-control" value="{{ $item->item_name }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ $item->description }}</textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ $item->price }}">
          </div>
          <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control" value="{{ $item->stock }}">
          </div>
          <div class="mb-3">
            <label class="form-label">Unit</label>
            <select name="item_unit_id" class="form-select">
              <option value="">Select unit</option>
              @foreach($units as $unit)
              <option value="{{ $unit->item_unit_id }}" {{ $item->item_unit_id == $unit->item_unit_id ? 'selected' : '' }}>{{ $unit->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Type</label>
            <select name="item_type_id" class="form-select">
              <option value="">Select type</option>
              @foreach($types as $type)
              <option value="{{ $type->item_type_id }}" {{ $item->item_type_id == $type->item_type_id ? 'selected' : '' }}>{{ $type->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Images</label>
            <input type="file" name="images[]" class="form-control" multiple>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Update Item</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

<!-- Edit Unit Modals -->
@foreach($units as $unit)
<div class="modal fade" id="editUnitModal{{ $unit->item_unit_id }}" tabindex="-1" aria-labelledby="editUnitModalLabel{{ $unit->item_unit_id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="{{ route('manager.units.update', $unit->item_unit_id) }}">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title" id="editUnitModalLabel{{ $unit->item_unit_id }}">Edit Unit</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Unit Name</label>
            <input name="name" class="form-control" value="{{ $unit->name }}" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Update Unit</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

<!-- Edit Type Modals -->
@foreach($types as $type)
<div class="modal fade" id="editTypeModal{{ $type->item_type_id }}" tabindex="-1" aria-labelledby="editTypeModalLabel{{ $type->item_type_id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="{{ route('manager.types.update', $type->item_type_id) }}">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title" id="editTypeModalLabel{{ $type->item_type_id }}">Edit Type</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Type Name</label>
            <input name="name" class="form-control" value="{{ $type->name }}" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Update Type</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach
