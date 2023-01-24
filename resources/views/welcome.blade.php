@extends('index')


@section('content')
    <div class="row mt-4">
        <div class="col-12">
            @for($page = 1, $items = \App\Models\Contractor::count(), $pages = intdiv($items, PER_PAGE); $page <= $pages; $page++)
                <a class="page" href="/page/{{ $page }}">{{ $page }}</a>
            @endfor
        </div>
    </div>
@endsection
