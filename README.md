# Hvad har jeg lavet

Projektet er langt fra færdigt, men jeg har allerede brugt mere en 10 timer, så dette er så langt jeg nåede.
Hjemmesiden er lavet med php frameworket laravel.
Det er en slags kalender hvor man kan tilføje opgaver til ugen.
Man opretter en bruger og logger ind.
Hjemmesiden kan kun vise 1 uge (jeg havde ikke tid til at implementere forskellige uger/måneder/år)
Man kan få vist alle opgaver i kalenderen
Man kan tilføje opgaver.
Man kan markere opgaver og slette dem.
Jeg mangler at man kan redigere opgaver.

## Hvordan har jeg lavet det

Jeg bruger composer (en slags package manager til php) til at hente en frisk laravel projekt
```
composer create-project laravel/laravel calendar
```
laravel har et authentication pakke vi kan bruge som hedder ui
```
composer require laravel/ui
```
jeg ville ikke bruge et framework, men man skal åbentbart vælge en af dem tror jeg
```
php artisan ui bootstrap --auth
npm install
npm run dev
```
nu er der nogle modeller og frontend til loginsysten, så nu skal .env sættes til vores database og vi kan nu migrere
```
php artisan migrate
```
Til mine opgaver laver jeg en table der hedder tasks
```
php artisan make:migration create_tasks_table --create=tasks
php artisan migrate
```
jeg skal også have en model til task så jeg ikke behøver at lave sql statements men bare kan kalde metoder på modellen i stedet. Jeg laver også en controller her, som jeg kunne bruge til at håndtere crud, men jeg lavede mine crud i calendar/app/Http/Controllers/HomeController.php
```
php artisan make:controller TaskController --resource --model=Task
```
Jeg havde glemt at have en kolonne som holdte styr på hvilken dag opgaven tilhørte så jeg laver en ekstra migration
```
php artisan make:migration add_day_to_tasks_table --table=tasks
php artisan migrate
```

Inde i calendar/routes/web.php definere jeg hvilke routes jeg vil have
```php
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home.store', [App\Http\Controllers\HomeController::class, 'store'])->name('home.store');
Route::get('/home.destroy', [App\Http\Controllers\HomeController::class, 'destroy'])->name('home.destroy');
```

Inde i calendar/app/Http/Controllers/HomeController.php bliver requests håndteret
For eksempelt så bliver min store/create håndteret således:
```php
public function store(Request $request)
{
    //since I in my html need to calculate how big the div containing the task and its 
    //position i thought percentage was easier to work with, so thats how im storing the data
    //the time gets in the request like 12:30 but hours arent the same as minutes so they need to be calculated differently
    $starttime_h = ((floatval(substr($request->starttime, 0,2)))/24)*100;
    $starttime_m = (((floatval(substr($request->starttime, 3,4)))/60)/24)*100;
    $starttime = $starttime_h+$starttime_m;
    $endtime_h = ((floatval(substr($request->endtime, 0,2)))/24)*100;
    $endtime_m = (((floatval(substr($request->endtime, 3,4)))/60)/24)*100;
    $endtime = $endtime_h+$endtime_m;
    $user_id = Auth::user()->id;
    //finally create the task based on input from the request, and users login id
    Task::create(['starttime' => $starttime] + ['endtime' => $endtime] + ['name' => $request->name] + ['day' => $request->day] + ['owner_fk' => $user_id]);
    //to refresh the page since new data is in database
    return redirect()->route('home');
}
```

I denne fil viser jeg mine tasks calendar/resources/views/home.blade.php men den er lidt kompliceret med noget php matematik og loops med både blade og php for at korrekt vise de tasks der tilhøre de forskellige dage med den rigtige placering og størrelse.
Dog er min tidbereging omrking 3 minutter ved siden af, men jeg kunne ikke helt gennemskue hvorfor.
