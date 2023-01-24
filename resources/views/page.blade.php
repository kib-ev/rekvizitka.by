@extends('index')


@section('title')
    Каталог - Страница {{ $page }} | Реквизитка.бай
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header">
                    Каталог - Страница {{ $page }}
                </div>

                <div class="card-body">
                    {{--                        <h4 class="card-title">--}}
                    {{--                            --}}
                    {{--                        </h4>--}}

                    @foreach($contractors as $contractor)
                        <div class="item">
                            <a href="/{{ $contractor->reg_code }}">Реквизиты {{ $contractor->is_company ? '' : 'ИП ' }} {{ $contractor->name }}, УНП {{ $contractor->reg_code }}</a>
                        </div>
                    @endforeach

                </div>

            </div>
        </div>
    </div>
@endsection
