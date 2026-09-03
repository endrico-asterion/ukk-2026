@extends ('layouts.app')

@section ('content')
<div class="container">
    <h1>Kategori</h1>
    <table class="table table-bordered table-strinped">
        <thead>
            <tr>
                <th>No</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $kategori)
            <tr>
                    <td>{{ $kategori->id_kategori }}</td>
                    <td>{{ $kategori->keterangan }}</td>
                    <td>
                        <a href="" class=" btn btn-success btn-sm">Edit</a>
                        <a href="" class=" btn btn-danger btn-sm">Hapus</a>
                    </td>
                </tr>
                @endforeach
        </tbody>
    </table>
    {!! $data->links() !!}
</div>
@endsection