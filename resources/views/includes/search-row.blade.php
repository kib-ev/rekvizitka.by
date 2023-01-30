<div class="row">
    <div class="col-12">

        <div class="mt-4">
            <form action="https://rekvizitka.by/" method="get" autocomplete="off">
                <input class="form-control" name="search" type="search" placeholder="Поиск по УНП" value="{{ request('reg_code') }}">
            </form>
        </div>

        <div class="mt-2">
            <span style="font-size: 0.9rem; margin-top: 20px;">Всего записей в базе: {{ \App\Models\Contractor::count() }}</span>
        </div>

    </div>
</div>
