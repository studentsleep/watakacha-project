<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <?php echo $__env->make('partials.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <title>Manager Dashboard</title>
</head>

<body class="bg-light">
    <div class="container py-5">
    
    

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">Manager Dashboard</h2>
                <p class="text-secondary mb-0">ส่วนจัดการข้อมูล</p>
            </div>
            <div>
                <a href="<?php echo e(url('/')); ?>" class="btn btn-outline-secondary">Home</a>
            </div>
        </div>

        <!-- Flash Message -->
        <?php if(session('status')): ?>
            <div class="alert alert-success"><?php echo e(session('status')); ?></div>
        <?php endif; ?>

        <!-- Table Selection & Filter -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('manager.index')); ?>" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small">Select Table</label>
                        <select name="table" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="items" <?php echo e($table=='items' ? 'selected' : ''); ?>>Items</option>
                            <option value="units" <?php echo e($table=='units' ? 'selected' : ''); ?>>Units</option>
                            <option value="types" <?php echo e($table=='types' ? 'selected' : ''); ?>>Types</option>
                        </select>
                    </div>

                    <?php if($table=='items'): ?>
                        <div class="col-md-2">
                            <label class="form-label small">Filter by Unit</label>
                            <select name="unit_id" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">- All Units -</option>
                                <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($unit->item_unit_id); ?>" <?php echo e(request('unit_id')==$unit->item_unit_id ? 'selected' : ''); ?>><?php echo e($unit->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small">Filter by Type</label>
                            <select name="type_id" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">- All Types -</option>
                                <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($type->item_type_id); ?>" <?php echo e(request('type_id')==$type->item_type_id ? 'selected' : ''); ?>><?php echo e($type->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small">Items per page</label>
                            <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()">
                                <?php $__currentLoopData = [5,10,20,50,100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($n); ?>" <?php echo e(request('per_page',20)==$n ? 'selected' : ''); ?>><?php echo e($n); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small">Search Items</label>
                            <input type="text" id="search_keyword" name="search" class="form-control form-control-sm" value="<?php echo e(request('search')); ?>" placeholder="Type to search...">
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-end mb-2 gap-2">
            <?php if($table=='items'): ?>
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addItemModal">New Item</button>
            <?php elseif($table=='units'): ?>
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addUnitModal">New Unit</button>
            <?php elseif($table=='types'): ?>
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addTypeModal">New Type</button>
            <?php endif; ?>
        </div>

        <!-- Tables -->
        <?php if($table=='items'): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Items</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Type</th>
                                    <th>Unit</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($items->firstItem() + $i); ?></td>
                                        <td><?php echo e($item->item_name); ?></td>
                                        <td><?php echo e($item->description); ?></td>
                                        <td><?php echo e($item->type->name ?? '-'); ?></td>
                                        <td><?php echo e($item->unit->name ?? '-'); ?></td>
                                        <td><?php echo e($item->price); ?></td>
                                        <td><?php echo e($item->stock ?? '-'); ?></td>
                                        <td>
                                            <?php $__currentLoopData = $item->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <img src="<?php echo e(asset('storage/'.$img->path)); ?>" width="50" style="object-fit:cover; cursor:pointer;" data-bs-toggle="modal" data-bs-target="#viewImageModal<?php echo e($img->id); ?>">
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                        <td class="d-flex gap-1">
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editItemModal<?php echo e($item->item_id); ?>">Edit</button>
                                            <form method="POST" action="<?php echo e(route('manager.items.destroy', $item->item_id)); ?>" onsubmit="return confirm('Delete this item?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="9" class="text-center text-secondary">No items</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <div class="mt-3"><?php echo e($items->withQueryString()->links()); ?></div>
                    </div>
                </div>
            </div>
        <?php elseif($table=='units'): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Units</h5>
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($i+1); ?></td>
                                    <td><?php echo e($unit->name); ?></td>
                                    <td><?php echo e($unit->description); ?></td>
                                    <td class="d-flex gap-1">
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editUnitModal<?php echo e($unit->item_unit_id); ?>">Edit</button>
                                        <form method="POST" action="<?php echo e(route('manager.units.destroy',$unit->item_unit_id)); ?>" onsubmit="return confirm('Delete this unit?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="3" class="text-center text-secondary">No units</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php elseif($table=='types'): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Types</h5>
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($i+1); ?></td>
                                    <td><?php echo e($type->name); ?></td>
                                    <td><?php echo e($type->description); ?></td>
                                    <td class="d-flex gap-1">
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editTypeModal<?php echo e($type->item_type_id); ?>">Edit</button>
                                        <form method="POST" action="<?php echo e(route('manager.types.destroy',$type->item_type_id)); ?>" onsubmit="return confirm('Delete this type?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="3" class="text-center text-secondary">No types</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <!-- Include Add and Update Modals -->
    <?php echo $__env->make('manager.modals.add', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('manager.modals.update', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</body>

</html><?php /**PATH C:\xampp\htdocs\watakacha-project\resources\views/manager/index.blade.php ENDPATH**/ ?>