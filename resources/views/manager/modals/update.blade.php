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
          <div class="mb-3">
            <label class="form-label">Description</label>
            <input name="des" class="form-control" value="{{ $unit->description }}">
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
          <div class="mb-3">
            <label class="form-label">Description</label>
            <input name="des" class="form-control" value="{{ $type->description }}">
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

@if(isset($users))
@foreach($users as $user)
<div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit User: {{ $user->username }}</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('manager.users.update', $user->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="mb-3"><label class="form-label">Username</label><input type="text" class="form-control" name="username" value="{{ $user->username }}" required></div>
          <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control" name="email" value="{{ $user->email }}" required></div>
          <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="user_type_id" class="form-select" required>
              @foreach($user_types as $user_type)
              <option value="{{ $user_type->id }}" @selected($user->user_type_id == $user_type->id)>{{ $user_type->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
              <option value="active" @selected($user->status == 'active')>Active</option>
              <option value="inactive" @selected($user->status == 'inactive')>Inactive</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary w-100">Update User</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach
@endif

@if(isset($user_types))
@foreach($user_types as $user_type)
<div class="modal fade" id="editUserTypeModal{{ $user_type->id }}" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit User Type: {{ $user_type->name }}</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('manager.user_types.update', $user_type->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="mb-3"><label class="form-label">Name</label><input type="text" class="form-control" name="name" value="{{ $user_type->name }}" required></div>
          <div class="mb-3"><label class="form-label">Description</label><textarea class="form-control" name="description" rows="3">{{ $user_type->description }}</textarea></div>
          <button type="submit" class="btn btn-primary w-100">Update User Type</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach
@endif

@if(isset($items))
@foreach($items as $item)
<div class="modal fade" id="updateImagesModal{{ $item->item_id }}" tabindex="-1" aria-labelledby="updateImagesModalLabel{{$item->item_id}}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateImagesModalLabel{{$item->item_id}}">Update Images for: {{ $item->item_name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4 text-center">
                    <p class="mb-2">Current Main Image:</p>
                    @if($item->mainImage)
                        <img src="{{ asset('storage/' . $item->mainImage->path) }}" class="img-fluid rounded" style="max-height: 400px; margin: auto;">
                    @else
                        <p class="text-secondary">No main image.</p>
                    @endif
                </div>

                <hr class="my-4">

                <form action="{{ route('manager.items.update_images', $item->item_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="images-{{$item->item_id}}" class="form-label">Upload New Images</label>
                        <p class="small text-muted">All old images will be replaced. The first image you select will be the main image.</p>
                        <input type="file" class="form-control" name="images[]" id="images-{{$item->item_id}}" multiple required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Upload and Replace Images</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif

