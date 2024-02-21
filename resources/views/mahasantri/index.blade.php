@extends('template')
@section('konten')
     <h2>
        Data Mahasantri
    </h2>

    <form action="{{ route('santri') }}" method="GET">
    <input type="text" name="cari" id="">
    <button type="submit">Cari</button>
    </form>

    <ul>
        @if(empty($cari))
        @foreach ($mahasantri as $item)
            <li>{{ $item['id']." ".$item['nama'] }}</li>
        @endforeach
    @else
        @foreach ($mahasantri as $item)
            @if ($cari == $item['nama'])
                <li>{{ $item['id']." ".$item['nama'] }}</li>
            @endif
        @endforeach
    @endif
    </ul>
@endsection
   
