<!DOCTYPE html>
<html>
<head>
    <title>Daftar Barang</title>
</head>
<body>

<h1>Daftar Barang Rentalin</h1>

<a href="{{ route('items.create') }}">
    Tambah Barang
</a>

<hr>

@foreach($items as $item)

<div>

    <h3>{{ $item->name }}</h3>

    <p>
        Rp {{ number_format($item->price_per_day) }}
    </p>

    <a href="{{ route('items.show',$item->id) }}">
        Detail
    </a>

    <a href="{{ route('items.edit',$item->id) }}">
        Edit
    </a>

    <form
        action="{{ route('items.destroy',$item->id) }}"
        method="POST">

        @csrf
        @method('DELETE')

        <button type="submit">
            Hapus
        </button>

    </form>

</div>

<hr>

@endforeach

{{ $items->links() }}

</body>
</html>