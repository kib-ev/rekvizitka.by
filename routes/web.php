<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

const PER_PAGE = 2000;


Route::get('/v', function () {

    $res = DB::table('contractors')
        ->select('reg_code', DB::raw('COUNT(*) c'))
        ->groupBy('reg_code')
        ->havingRaw('c > 1')
        ->get();

    foreach ($res as $row) {
        $contractors = \App\Models\Contractor::where('reg_code', $row->reg_code)->get();
        $contractors->sortBy('id')[1]->delete();
    }


});

Route::get('/info', function () {
    $activeContractors = \App\Models\Contractor::where('is_company', 0)->where('is_active', 1)->count();

    dd($activeContractors);
});

Route::get('/test', function () {


//    phpinfo();

    $redis = new Redis();

    try {
        $redis->connect(host: '194.62.19.48');
        $redis->auth('test');

        if ( $redis->ping() ) {
            echo 'Connection is ok';
        }

    } catch (RedisException $redisException) {
        echo $redisException->getMessage();
    }



    dd(1);

    $res = \Illuminate\Support\Facades\Cache::store('redis')->remember('test', now()->addMinutes(1), function () {
        return 123;
    });

    dd(\Illuminate\Support\Facades\Cache::store('redis')->get('test'));


});


Route::get('/', function () {

    if(request('search')) {
        return  redirect()->to('/' . request('search'));
    }

    return view('welcome');
});

Route::get('/api/sync/{reg_code}', function ($reqCode) {
    \Illuminate\Support\Facades\Artisan::call('sync:egr '. $reqCode . ' '. $reqCode);

    $contractor = \App\Models\Contractor::where('reg_code', $reqCode)->first();

    return $contractor && $contractor->updated_at->isToday()
        ? ['status' => 'synced']
        : ['status' => 'error'] ;
});

Route::get('/page', function () {
    return redirect()->to('/page/1');
});


Route::get('/page/{page}', function ($page) {


//    return \Illuminate\Support\Facades\Cache::rememberForever("page_$page.html",  function () use ($page) {

        $limit = PER_PAGE;

        $skip = $limit * ($page - 1);


        $contractors = \App\Models\Contractor::/*orderBy('reg_code')-*/skip($skip)->take($limit)->get();

        if(count($contractors) > 0) {
            return view('page', compact('contractors', 'page'))->render();
        } else {
            return redirect(302)->to('/page/1');
        }

//    });


});

Route::get('/banks', function () {
    $banks = \App\Models\Bank::all();
    return view('banks.index', compact('banks'));
});


// https://egr.gov.by/api/v2/egr/getJurNamesByPeriod/2023-01-01/2023-01-30


Route::get('/{reg_code}', function ($regCode) {

    $contractor = \App\Models\Contractor::where('reg_code', $regCode)->firstOrFail();

    if (/*!$contractor || */ request()->has('update')) {
        $content = file_get_contents_ssl("https://egr.gov.by/egrmobile/api/search/checkStatusSubject?pan=$regCode");
        $data = json_decode($content, true);

        if ($data['content'][0]['pan'] ?? null) {
            $contractor = syncContractor($data);
        }
    }

    return view('contractor')->with('contractor', $contractor ?? null)->render();

});

Route::resource('contractor', \App\Http\Controllers\ContractorController::class);

function syncContractor($data)
{
    $isCompany = $data['content'][0]['typePerson'] == 1;
    $isActive = $data['content'][0]['stateObject'] == 1;

    $companyName = $data['content'][0]['nameRu'] ?? $data['content'][0]['specialNameRu'] ?? '-';
    $companyFullName = $data['content'][0]['specialNameRu'] ?? $data['content'][0]['nameRu'] ?? '-';

    $personName = $data['content'][0]['fio'] ?? $companyName;

    $address = str_replace(['Республика Беларусь, '], '', $data['content'][0]['locationPlace']);

    $contractor =  \App\Models\Contractor::updateOrCreate([
        'reg_code' => $data['content'][0]['pan'],
    ], [
        'name' => $isCompany ? $companyName : $personName,
        'full_name' => $isCompany ? $companyFullName : $personName,
        'registration_date' => $data['content'][0]['dateRegistration'],
        'exclude_date' => $data['content'][0]['dateExclude'],

        'address' => $address,
        'registration_authority' => $data['content'][0]['registrationAuthority'],

        'state' => $data['content'][0]['nameState'],
        'state_code' => $data['content'][0]['stateObject'],

        'is_company' => $isCompany,
        'is_active' => $isActive,
        'synced_at' => now(),
    ]);

    return $contractor ?? null;
}

