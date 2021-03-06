# Hvad har jeg lavet

Projektet er langt fra færdigt, men jeg har allerede brugt langt mere end 10 timer, så dette er så langt jeg nåede. <br>
Hjemmesiden er lavet med php frameworket laravel.<br>
Det er en slags kalender hvor man kan tilføje opgaver til ugen.<br>
Man opretter en bruger og logger ind.<br>
Hjemmesiden kan kun vise 1 uge (jeg havde ikke tid til at implementere forskellige uger/måneder/år)<br>
Man kan få vist alle opgaver i kalenderen<br>
Man kan tilføje opgaver.<br>
Man kan markere opgaver og slette dem.<br>
Jeg mangler at man kan redigere opgaver.<br>
<img width="1436" alt="Screenshot 2021-04-30 at 19 49 23" src="https://user-images.githubusercontent.com/54975711/116734054-36671280-a9ed-11eb-94c6-435ebf07de65.png">


## Hvordan har jeg lavet det

Jeg bruger composer (en slags package manager til php) til at hente en frisk laravel projekt
```
composer create-project laravel/laravel calendar
```
laravel har et authentication pakke vi kan bruge som hedder ui
```
composer require laravel/ui
```
jeg ville ikke bruge et framework, men man skal åbentbart vælge en af dem tror jeg, så jeg tog bare bootstrap
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

Inde i calendar/app/Http/Controllers/HomeController.php bliver requests håndteret<br>
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

I denne fil viser jeg mine tasks <br>
calendar/resources/views/home.blade.php <br>
men den er lidt kompliceret med noget php matematik og loops med både blade og php for at korrekt vise de tasks der tilhøre de forskellige dage med den rigtige placering og størrelse.
Dog er min tidbereging omrking 3 minutter ved siden af, men jeg kunne ikke helt gennemskue hvorfor.
