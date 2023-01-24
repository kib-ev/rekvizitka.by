@extends('index')


@section('meta')
    <meta name="description" content="Информация и реквизиты {{ $contractor->is_company ? '' : 'ИП ' }} {{ $contractor->name }} УНП {{ $contractor->reg_code }}">
@endsection

@section('title')
    @if(isset($contractor))
        Реквизиты {{ $contractor->is_company ? '' : 'ИП ' }} {{ $contractor->name }} УНП {{ $contractor->reg_code }} | Реквизитка.бай
    @else
        Страница не найдена | Реквизитка.бай
    @endif
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mt-4">
{{--                <div class="card-header">--}}
{{--                    Реквизиты--}}
{{--                </div>--}}

                <div class="card-body">
                    @if(isset($contractor))
                        <h1 class="card-title" style="font-size: 1.5rem;">
                            Реквизиты {{ $contractor->is_company ? '' : 'ИП ' }} {{ $contractor->name }}
                        </h1>
                        <p>
                            Статус:
                            <span class="{{ $contractor->is_active ? 'text-success' : 'text-danger' }}">{{ $contractor->state }}
                                @if($contractor->exclude_date)
                                    ({{ \Illuminate\Support\Carbon::parse($contractor->exclude_date)->format('d.m.Y') }})
                                @endif
                            </span>
                        </p>

                        <div itemprop="address" itemscope="" itemtype="https://schema.org/PostalAddress">

                            <div class="text fs12" style="margin-bottom: 15px;">
                                <table class="table table-bordered">

                                    <tr>
                                        <td>УНП</td>
                                        <td>{{ $contractor->reg_code }}</td>
                                    </tr>

                                    <tr>
                                        <td>Полное наименование</td>
                                        <td>{{ $contractor->is_company ? '' : 'Индивидуальный предприниматель ' }}{{ $contractor->full_name }}</td>
                                    </tr>

                                    <tr>
                                        <td>Юридический адрес</td>
                                        <td>{{ $contractor->address }}</td>
                                    </tr>

                                    <tr>
                                        <td>Почтовый адрес</td>
                                        <td>-</td>
                                    </tr>

                                    <tr>
                                        <td>Дата регистрации</td>
                                        <td>{{ \Illuminate\Support\Carbon::parse($contractor->registration_date)->format('d.m.Y') }}</td>
                                    </tr>

                                    <tr>
                                        <td>Телефон</td>
                                        <td itemprop="telephone">{{ $contractor->phone ?? '-' }}</td>
                                    </tr>

                                    <tr>
                                        <td>Электронная почта</td>
                                        <td><span itemprop="email">{{ $contractor->email ?? '-' }}</span></td>
                                    </tr>

                                </table>


                            </div>


                            {{--                            <a href="#" class="btn btn-primary">Еще</a>--}}

                        </div>

                    @else
                        Ничего не найдено.
                    @endif

                </div>

            </div>
        </div>
    </div>
@endsection
