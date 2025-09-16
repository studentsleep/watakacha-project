<tbody>
@forelse($items as $i => $item)
<tr>
    <td>{{ $items->firstItem() + $i }}</td>
    <td>{{ $item->name }}</td>
    <td>{{ $item->type->name ?? '-' }}</td>
    <td>{{ $item->unit->name ?? '-' }}</td>
    <td>{{ $item->price }}</td>
    <td>{{ $item->stock ?? '-' }}</td>
    <td class="d-flex gap-1">
        <a href="{{ route('manager.items.edit', $item->item_id) }}" class="btn btn-sm btn-primary">Edit</a>
        <form method="POST" action="{{ route('manager.items.destroy', $item->item_id) }}" onsubmit="return confirm('Delete this item?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
        </form>
    </td>
</tr>
@empty
<tr><td colspan="7" class="text-center text-secondary">No items</td></tr>
@endforelse
</tbody>
</table>