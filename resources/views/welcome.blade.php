@extends('index')


@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <ul>
                <li>Количество юридических лиц в реестре РБ: {{ \App\Models\Contractor::count() }}</li>
                <li>Количество действующих юридических лиц: {{ \App\Models\Contractor::whereNull('exclude_date')->count() }}</li>
                <li>Количество юридических лиц в процессе ликвидации: {{ \App\Models\Contractor::where('state_code', 3)->count() }}</li>
                <li>Количество ликвидированных юридических лиц: {{ \App\Models\Contractor::whereNotNull('exclude_date')->count() }}</li>
            </ul>

            @if(request()->has('info'))

                Обновлено сегодня: {{ \App\Models\Contractor::whereDate('updated_at', \Carbon\Carbon::today())->count() }}

                <hr>

                Задач в очереди: {{ \Illuminate\Support\Facades\DB::table('jobs')->count() }}

                <ul>
                    <li>
                        Количество ликвидированных юридических лиц в 2019 году: {{ \App\Models\Contractor::whereYear('exclude_date', 2019)->count() }},
                        из них ИП: {{ \App\Models\Contractor::whereYear('exclude_date', 2019)->where('is_company', 0)->count() }}
                    </li>
                    <li>
                        Количество ликвидированных юридических лиц в 2020 году: {{ \App\Models\Contractor::whereYear('exclude_date', 2020)->count() }},
                        из них ИП: {{ \App\Models\Contractor::whereYear('exclude_date', 2020)->where('is_company', 0)->count() }}
                    </li>
                    <li>
                        Количество ликвидированных юридических лиц в 2021 году: {{ \App\Models\Contractor::whereYear('exclude_date', 2021)->count() }},
                        из них ИП: {{ \App\Models\Contractor::whereYear('exclude_date', 2021)->where('is_company', 0)->count() }}
                    </li>
                    <li>
                        Количество ликвидированных юридических лиц в 2022 году: {{ \App\Models\Contractor::whereYear('exclude_date', 2022)->count() }},
                        из них ИП: {{ \App\Models\Contractor::whereYear('exclude_date', 2022)->where('is_company', 0)->count() }}
                    </li>
                    <li>
                        Количество ликвидированных юридических лиц в 2023 году: {{ \App\Models\Contractor::whereYear('exclude_date', 2023)->count() }},
                        из них ИП: {{ \App\Models\Contractor::whereYear('exclude_date', 2023)->where('is_company', 0)->count() }}
                    </li>
                </ul>

            @endif

        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            @for($page = 1, $items = \App\Models\Contractor::count(), $pages = intdiv($items, PER_PAGE); $page <= $pages; $page++)
                <a class="page" href="/page/{{ $page }}">{{ $page }}</a>
            @endfor
        </div>
    </div>
@endsection

