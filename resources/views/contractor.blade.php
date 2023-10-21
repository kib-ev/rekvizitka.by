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
                                    @if(request()->has('info'))
                                        <tr>
                                            <td>ID</td>
                                            <td>{{ $contractor->id }}</td>
                                        </tr>
                                    @endif

                                    <tr>
                                        <td style="width: 250px;">УНП</td>
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

                                        @if(request()->has('edit'))
                                            <td itemprop="telephone">
                                                <form action="{{ route('contractor.update', $contractor) }}" method="post" autocomplete="off">
                                                    @csrf
                                                    @method('patch')

                                                    <input type="text" name="phone" style="width: 100%;" value="{{ $contractor->phone ?? '' }}">
                                                </form>
                                            </td>
                                        @else
                                            <td>
                                                @if($contractor->phone)
                                                    <span itemprop="telephone">
                                                        <a class="js-show-phone" href="#">показать</a>
                                                    </span>
                                                @else
                                                    <span itemprop="telephone">-</span>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>

                                    <tr>
                                        <td>Электронная почта</td>

                                        @if(request()->has('edit'))
                                            <td itemprop="email">
                                                <form action="{{ route('contractor.update', $contractor) }}" method="post" autocomplete="off">
                                                    @csrf
                                                    @method('patch')

                                                    <input type="text" name="email" style="width: 100%;" value="{{ $contractor->email ?? '' }}">
                                                </form>
                                            </td>
                                        @else
                                            <td>
                                                @if($contractor->email)
                                                    <span itemprop="email">
                                                        <a class="js-show-email" href="#">показать</a>
                                                    </span>
                                                @else
                                                    <span itemprop="email">-</span>
                                                @endif
                                            </td>
                                        @endif

                                    </tr>

                                    <tr>
                                        <td>Вебсайт</td>

                                        @if(request()->has('edit'))
                                            <td itemprop="website">
                                                <form action="{{ route('contractor.update', $contractor) }}" method="post" autocomplete="off">
                                                    @csrf
                                                    @method('patch')

                                                    <input type="text" name="website" style="width: 100%;" value="{{ $contractor->website ?? '' }}">
                                                </form>
                                            </td>
                                        @else
                                            <td><span itemprop="website">{{ $contractor->website ?? '-' }}</span></td>
                                        @endif

                                    </tr>

                                </table>



                                @if($contractor->bankAccounts->count())
                                    <h4>Банковские реквизиты</h4>
                                @endif


                                @foreach($contractor->bankAccounts->load(['bank']) as $account)
                                    <table class="table table-bordered">

                                        <tr>
                                            <td>Банк</td>
                                            <td colspan="2" itemprop="telephone">{{ $account->bank->name ?? '-' }}</td>
                                        </tr>

{{--                                        <tr>--}}
{{--                                            <td>БИК</td>--}}
{{--                                            <td><span itemprop="email">{{ $account->bank->swift ?? '-' }}</span></td>--}}
{{--                                        </tr>--}}

                                        <tr>
                                            <td>Номер счета</td>
                                            <td><span itemprop="email">{{ $account->number ?? '-' }}</span></td>

                                            <td>{{ $account->currency ?? '-' }}</td>
                                        </tr>


                                    </table>
                                @endforeach


                            </div>


                            {{--                            <a href="#" class="btn btn-primary">Еще</a>--}}

                        </div>

                    @else
                        Ничего не найдено.
                    @endif

                    <span style="font-size: 0.8em; color: #ccc; text-align: right; float: right;">
                        Последнее обновление записи: {{ $contractor->updated_at->format('d.m.Y') }}
                    </span>
                </div>

            </div>
        </div>
    </div>
@endsection
