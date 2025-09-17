<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
    <title>Manager Dashboard</title>
</head>

<body class="bg-light">
    <div class="container py-5">
        {{-- เรียกใช้ Livewire Component --}}
        {{--@livewire('manager.inventory')--}}

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">Manager Dashboard</h2>
                <p class="text-secondary mb-0">ส่วนจัดการข้อมูล</p>
            </div>
            <div>
                <a href="{{ url('/') }}" class="btn btn-outline-secondary">Home</a>
            </div>
        </div>

        <!-- Flash Message -->
        @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <!-- Table Selection & Filter -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('manager.index') }}" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small">Select Table</label>
                        <select name="table" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="items" @selected($table=='items' )>Items</option>
                            <option value="units" @selected($table=='units' )>Item Units</option>
                            <option value="types" @selected($table=='types' )>Item Types</option>
                            <option value="users" @selected($table=='users' )>Users</option>
                            <option value="user_types" @selected($table=='user_types' )>User Types</option>
                        </select>
                    </div>

                    @if($table=='items')
                    <div class="col-md-2">
                        <label class="form-label small">Filter by Unit</label>
                        <select name="unit_id" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">- All Units -</option>
                            @foreach($units as $unit)
                            <option value="{{ $unit->item_unit_id }}" {{ request('unit_id')==$unit->item_unit_id ? 'selected' : '' }}>{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small">Filter by Type</label>
                        <select name="type_id" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">- All Types -</option>
                            @foreach($types as $type)
                            <option value="{{ $type->item_type_id }}" {{ request('type_id')==$type->item_type_id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small">Items per page</label>
                        <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()">
                            @foreach([5,10,20,50,100] as $n)
                            <option value="{{ $n }}" {{ request('per_page',20)==$n ? 'selected' : '' }}>{{ $n }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">Search Items</label>
                        <input type="text" id="search_keyword" name="search" class="form-control form-control-sm" value="{{ request('search') }}" placeholder="Type to search...">
                    </div>
                    @endif
                </form>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-end mb-2 gap-2">
            @if($table=='items')
            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addItemModal">New Item</button>
            @elseif($table=='units')
            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addUnitModal">New Unit</button>
            @elseif($table=='types')
            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addTypeModal">New Type</button>
            @elseif($table=='user_types')
            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addUserTypeModal">New User Type</button>
            @endif
        </div>

        <!-- Tables -->
        @if($table=='items')
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
                            @forelse($items as $i => $item)
                            <tr>
                                <td>{{ $items->firstItem() + $i }}</td>
                                <td>{{ $item->item_name }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->type->name ?? '-' }}</td>
                                <td>{{ $item->unit->name ?? '-' }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->stock ?? '-' }}</td>
                                <td>
                                    @foreach($item->images as $img)
                                    <img src="{{ asset('storage/'.$img->path) }}" width="50" style="object-fit:cover; cursor:pointer;" data-bs-toggle="modal" data-bs-target="#viewImageModal{{ $img->id }}">
                                    @endforeach
                                </td>
                                <td class="d-flex gap-1">
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editItemModal{{ $item->item_id }}">Edit</button>
                                    <form method="POST" action="{{ route('manager.items.destroy', $item->item_id) }}" onsubmit="return confirm('Delete this item?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center text-secondary">No items</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">{{ $items->withQueryString()->links() }}</div>
                </div>
            </div>
        </div>
        @elseif($table=='units')
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
                        @forelse($units as $i=>$unit)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $unit->name }}</td>
                            <td>{{ $unit->description }}</td>
                            <td class="d-flex gap-1">
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editUnitModal{{ $unit->item_unit_id }}">Edit</button>
                                <form method="POST" action="{{ route('manager.units.destroy',$unit->item_unit_id) }}" onsubmit="return confirm('Delete this unit?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-secondary">No units</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @elseif($table=='types')
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
                        @forelse($types as $i=>$type)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $type->name }}</td>
                            <td>{{ $type->description }}</td>
                            <td class="d-flex gap-1">
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editTypeModal{{ $type->item_type_id }}">Edit</button>
                                <form method="POST" action="{{ route('manager.types.destroy',$type->item_type_id) }}" onsubmit="return confirm('Delete this type?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-secondary">No types</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        {{-- ✅ START: Table for Users --}}
        @if($table == 'users')
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3">Users</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td><span class="badge bg-info">{{ $user->userType->name ?? 'N/A' }}</span></td>
                                <td><span class="badge {{ $user->status == 'active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($user->status) }}</span></td>
                                <td class="d-flex gap-1">
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">Edit</button>
                                    <form method="POST" action="{{ route('manager.users.destroy', $user->id) }}" onsubmit="return confirm('Delete this user? This cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-secondary">No users found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">{{ $users->withQueryString()->links() }}</div>
                </div>
            </div>
        </div>
        @endif
        {{-- ✅ END: Table for Users --}}


        {{-- ✅ START: Table for User Types --}}
        @if($table == 'user_types')
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3">User Types (Roles)</h5>
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
                        @forelse($user_types as $user_type)
                        <tr>
                            <td>{{ $user_type->id }}</td>
                            <td>{{ $user_type->name }}</td>
                            <td>{{ $user_type->description }}</td>
                            <td class="d-flex gap-1">
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editUserTypeModal{{ $user_type->id }}">Edit</button>
                                <form method="POST" action="{{ route('manager.user_types.destroy', $user_type->id) }}" onsubmit="return confirm('Delete this user type?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-secondary">No user types found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        {{-- ✅ END: Table for User Types --}}

    </div>

    <!-- Include Add and Update Modals -->
    @include('manager.modals.add')
    @include('manager.modals.update')

</body>

</html>