<!-- manager.modals.update.blade.php -->

<!-- Edit Item Modals -->
<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="editItemModal<?php echo e($item->item_id); ?>" tabindex="-1" aria-labelledby="editItemModalLabel<?php echo e($item->item_id); ?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="<?php echo e(route('manager.items.update', $item->item_id)); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="modal-header">
          <h5 class="modal-title" id="editItemModalLabel<?php echo e($item->item_id); ?>">Edit Item</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Item Name</label>
            <input name="name" class="form-control" value="<?php echo e($item->item_name); ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control"><?php echo e($item->description); ?></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?php echo e($item->price); ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control" value="<?php echo e($item->stock); ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Unit</label>
            <select name="item_unit_id" class="form-select">
              <option value="">Select unit</option>
              <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($unit->item_unit_id); ?>" <?php echo e($item->item_unit_id == $unit->item_unit_id ? 'selected' : ''); ?>><?php echo e($unit->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Type</label>
            <select name="item_type_id" class="form-select">
              <option value="">Select type</option>
              <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($type->item_type_id); ?>" <?php echo e($item->item_type_id == $type->item_type_id ? 'selected' : ''); ?>><?php echo e($type->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<!-- Edit Unit Modals -->
<?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="editUnitModal<?php echo e($unit->item_unit_id); ?>" tabindex="-1" aria-labelledby="editUnitModalLabel<?php echo e($unit->item_unit_id); ?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="<?php echo e(route('manager.units.update', $unit->item_unit_id)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="modal-header">
          <h5 class="modal-title" id="editUnitModalLabel<?php echo e($unit->item_unit_id); ?>">Edit Unit</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Unit Name</label>
            <input name="name" class="form-control" value="<?php echo e($unit->name); ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <input name="des" class="form-control" value="<?php echo e($unit->description); ?>">
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
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<!-- Edit Type Modals -->
<?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="editTypeModal<?php echo e($type->item_type_id); ?>" tabindex="-1" aria-labelledby="editTypeModalLabel<?php echo e($type->item_type_id); ?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="<?php echo e(route('manager.types.update', $type->item_type_id)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="modal-header">
          <h5 class="modal-title" id="editTypeModalLabel<?php echo e($type->item_type_id); ?>">Edit Type</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Type Name</label>
            <input name="name" class="form-control" value="<?php echo e($type->name); ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <input name="des" class="form-control" value="<?php echo e($type->description); ?>">
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
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php if(isset($users)): ?>
<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="editUserModal<?php echo e($user->id); ?>" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit User: <?php echo e($user->username); ?></h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="<?php echo e(route('manager.users.update', $user->id)); ?>" method="POST">
          <?php echo csrf_field(); ?>
          <?php echo method_field('PUT'); ?>
          <div class="mb-3"><label class="form-label">Username</label><input type="text" class="form-control" name="username" value="<?php echo e($user->username); ?>" required></div>
          <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control" name="email" value="<?php echo e($user->email); ?>" required></div>
          <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="user_type_id" class="form-select" required>
              <?php $__currentLoopData = $user_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($user_type->id); ?>" <?php if($user->user_type_id == $user_type->id): echo 'selected'; endif; ?>><?php echo e($user_type->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
              <option value="active" <?php if($user->status == 'active'): echo 'selected'; endif; ?>>Active</option>
              <option value="inactive" <?php if($user->status == 'inactive'): echo 'selected'; endif; ?>>Inactive</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary w-100">Update User</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php if(isset($user_types)): ?>
<?php $__currentLoopData = $user_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="editUserTypeModal<?php echo e($user_type->id); ?>" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit User Type: <?php echo e($user_type->name); ?></h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="<?php echo e(route('manager.user_types.update', $user_type->id)); ?>" method="POST">
          <?php echo csrf_field(); ?>
          <?php echo method_field('PUT'); ?>
          <div class="mb-3"><label class="form-label">Name</label><input type="text" class="form-control" name="name" value="<?php echo e($user_type->name); ?>" required></div>
          <div class="mb-3"><label class="form-label">Description</label><textarea class="form-control" name="description" rows="3"><?php echo e($user_type->description); ?></textarea></div>
          <button type="submit" class="btn btn-primary w-100">Update User Type</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php if(isset($items)): ?>
<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="updateImagesModal<?php echo e($item->item_id); ?>" tabindex="-1" aria-labelledby="updateImagesModalLabel<?php echo e($item->item_id); ?>" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateImagesModalLabel<?php echo e($item->item_id); ?>">Update Images for: <?php echo e($item->item_name); ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-4 text-center">
          <p class="mb-2">Current Main Image:</p>
          <?php if($item->mainImage): ?>
          <img src="<?php echo e(asset('storage/' . $item->mainImage->path)); ?>" class="img-fluid rounded" style="max-height: 400px; margin: auto;">
          <?php else: ?>
          <p class="text-secondary">No main image.</p>
          <?php endif; ?>
        </div>

        <hr class="my-4">

        <form action="<?php echo e(route('manager.items.update_images', $item->item_id)); ?>" method="POST" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
          <div class="mb-3">
            <label for="images-<?php echo e($item->item_id); ?>" class="form-label">Upload New Images</label>
            <p class="small text-muted">All old images will be replaced. The first image you select will be the main image.</p>
            <input type="file" class="form-control" name="images[]" id="images-<?php echo e($item->item_id); ?>" multiple required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Upload and Replace Images</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>




<?php if(isset($items)): ?>
<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php $__currentLoopData = $item->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="viewImageModal<?php echo e($img->id); ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo e($item->item_name); ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center p-2">
        <img src="<?php echo e(asset('storage/' . $img->path)); ?>" class="img-fluid rounded" style="max-height: 80vh;">
      </div>
    </div>
  </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>





<?php if(isset($items)): ?>
<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="manageImagesModal<?php echo e($item->item_id); ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Manage Images: <?php echo e($item->item_name); ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div class="card mb-4 border-success">
          <div class="card-body">
            <h6 class="card-title text-success">Upload New Image</h6>
            <form action="<?php echo e(route('manager.items.images.upload', $item->item_id)); ?>" method="POST" enctype="multipart/form-data">
              <?php echo csrf_field(); ?>
              <div class="input-group">
                <input type="file" class="form-control" name="image" required>
                <button class="btn btn-success" type="submit">Upload</button>
              </div>
            </form>
          </div>
        </div>

        <h6>Existing Images</h6>
        <?php if($item->images->count() > 0): ?>
        <div class="row g-3">
          <?php $__currentLoopData = $item->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="col-md-4 col-lg-3">
            <div class="card h-100">
              <div class="position-relative">
                <img src="<?php echo e(asset('storage/' . $image->path)); ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                <?php if($image->is_main): ?>
                <span class="badge bg-primary position-absolute top-0 start-0 m-2">Main Image</span>
                <?php endif; ?>
              </div>
              <div class="card-body text-center d-flex flex-column p-2">
                <div class="mt-auto d-grid gap-2">
                  
                  <?php if(!$image->is_main): ?>
                  <form action="<?php echo e(route('manager.items.images.set_main', $image->id)); ?>" method="POST" class="d-grid">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-sm btn-outline-primary">Set as Main</button>
                  </form>
                  <?php endif; ?>
                  
                  <form action="<?php echo e(route('manager.items.images.destroy', $image->id)); ?>" method="POST" class="d-grid" onsubmit="return confirm('Delete this image?')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php else: ?>
        <p class="text-center text-secondary py-5">No images for this item yet.</p>
        <?php endif; ?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\watakacha-project\resources\views/manager/modals/update.blade.php ENDPATH**/ ?>