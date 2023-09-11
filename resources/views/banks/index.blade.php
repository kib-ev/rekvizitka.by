@extends('index')


@section('meta')
    <meta name="description" content="Реквизиты всех банков Беларуси">
@endsection


@section('title')
    Реквизиты всех банков Беларуси | Реквизитка.бай
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mt-4">

                <div class="card-body">
                    <table class="table-bordered table-sm">
                        @foreach($banks as $bank)
                            <tr>
                                <td>{{ $bank->contractor->name }}</td>
                                <td>{{ $bank->swift }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
