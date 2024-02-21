{{-- <h5>ID Mahasantri {{$id}} {{$nama}}</h5> --}}
<h1>ID mahasantri</h1>

@foreach ($data as $item)
    @if ($item['id'] == $idd)
        <p>ID: {{ $item['id'] }}</p>
        <p>Nama: {{ $item['nama'] }}</p>
    @endif
@endforeach