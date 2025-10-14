# Laravel Easy(Quick) Learning Guide

## Table of Contents

-   [Routes in Laravel](#routes-in-laravel)
-   [Passing Data from Route to View](#passing-data-from-route-to-view)
-   [Creating View Files](#creating-view-files)
-   [Blade Templates](#blade-templates)
-   [Terminal Commands](#terminal-commands)
-   [Master Layout](#master-layout-with-extends-and-yield)
-   [Controllers](#controllers)
-   [Migration in Laravel](#migration-in-laravel)
-   [Migration Rollback Commands](#migration-rollback-commands)
-   [Working with Models](#working-with-models)
-   [CRUD Operations with Model and Controller](#crud-operations-with-model-and-controller)
-   [Factory](#factory)
-   [Run SQL Queries in Laravel](#run-sql-queries-in-laravel)
-   [Where Types](#where-types)
-   [Query Scope](#query-scope)
-   [Soft Delete](#soft-delete)

---

## Routes in Laravel

### Simple Routing

The `/` will automatically identify the files inside `resources/views` folder.

**Example:**

```php
Route::any('/program_1/post', function () {
    return view('welcome');
});
```

**OR create direct view route:**

```php
Route::view('/path', 'viewFileName');
```

### Dynamic Routing

**Example:**

```php
Route::get('student/{id}', function ($id) {
    echo "Student " . $id;
});
```

### FallBack Route (Invalid Route)

Called when the route is not found.

**Example:**

```php
Route::fallback(function () {
    return "please enter valid url";
});
```

---

## Passing Data from Route to View

### Send Data

**Using compact:**

```php
Route::get('/', function () {
    $data = "Data from web.php file";
    return view('test', compact('data'));  // compact only allows variables
});
```

**OR using with function:**

```php
Route::get('/', function () {
    $data = "Data from web.php file";
    return view('test')->with('data', $data);
});
```

**OR using key value array data:**

```php
Route::get('/', function () {
    return view('test', ['key' => value, 'key' => value]);
});
```

### Receive Data

In target `.php` file:

```blade
{{ $variable_name }}                    // to access variable
{{ request()->parameter_Name }}         // to access url variable
```

---

## Creating View Files

### Terminal Command

```bash
php artisan make:view contactUs
```

It will automatically create `contactUs.blade.php` file under views folder.

---

## Blade Templates

### Looping in Blade File

The loop starts with `@for` and ends with `@endfor`

**Example:**

```blade
@for($i=0; $i<10; $i++)
    <p> {{$i}} </p>     // It doesn't require {} brackets
@endfor
```

### Conditions in Blade File

Condition statements start with `@` and end with `@endif`

**Example:**

```blade
@if($i<0)
    <p> {{$i}} is Less then 0</p>
@else
    <p> {{$i}} is Greater then 0</p>
@endif
```

**For More Templates:** [https://laravel.com/docs/12.x/blade](https://laravel.com/docs/12.x/blade)

### Adding Sub Components/Views

**Basic include:**

```blade
@include('fileName')
```

**Example:**

```blade
@include('subViews.input')
```

**Call subview with data passing:**

```blade
@include('subViews.input', [
    'lableFor' => 'Name',
    'myName' => 'Umang'
])
```

Access those data from subview with `{{ $variable_name }}`

---

## Terminal Commands

### Get All Routes

```bash
php artisan route:list
```

It will return all the routes list with 2 other routes:

-   **up**: to see our application is up, running or not
-   **storage{path}**: later discuss

### Store Site in Cache

```bash
php artisan view:cache
```

It will cache the site in cache memory for faster loading.

### Remove Cache

```bash
php artisan view:clear
```

---

## Master Layout with @extends and @yield

### @extends

This directive tells Laravel to extend a layout.

**Example:**

```blade
@extends('layouts.app')
```

### @yield

Used in the layout to define a placeholder for content.

**Example:**

```blade
<title>@yield('title', 'My Laravel App')</title>
```

### @section

Defines content for a specific section that will be injected into the layout's `@yield`.

**Example:**

```blade
@section('title', 'Home Page')

@section('content')
    <p>Welcome to the home page!</p>
@endsection
```

### @show

Immediately displays the content of a section after it's been defined.

**Example:**

```blade
@section('header')
    <h2>Header Content</h2>
@show
```

---

## Controllers

Controllers are the main part of MVC. It can get data from view, process data and set back data to view. It has ability to get data from database/Model also.

### Create a Controller

**Manually:** Inside `App/Http/Controllers`

**OR using command:**

```bash
php artisan make:controller controller_name
```

**Example:**

```php
class StudentController extends Controller
{
    public function index()
    {
        return "From Student Controller";
    }
}
```

### Route for Controller

```php
Route::get('controller', [StudentController::class, 'index']);
```

### Controller Route Group

```php
Route::controller(StudentController::class)->group(function () {
    Route::get('studentController', 'index');
    Route::get('aboutstudent', 'aboutStudent');
});
```

### Pass Data to the Controller

```php
Route::controller(StudentController::class)->group(function () {
    Route::get('studentController', 'index');
    Route::get('aboutstudent/{id}/{name}', 'aboutStudent');
});
```

### Private Controllers

Private controller can only access within the same class.

**Example:**

```php
private function studentResult($id)
{
    return "Student Id " . $id . " has 50 marks";
}
```

### \_\_construct()

It automatically calls when object is created. Whenever we need any calculation, run any logic, or anything computation.

**Example:**

```php
protected $status;  // Global variable

public function __construct()
{
    $this->status = "fail";
}
```

---

## Types of Controllers

### 1. Invokable Controller

It is also called single method controller which means if any controller has only 1 function and we don't want to use like index, create, update, delete etc. It has only 1 method where we can put our logic which is `__invoke` function.

**Create command:**

```bash
php artisan make:controller controller_name --invokable
```

**Example file:**

```php
class InvokableController extends Controller
{
    public function __invoke(Request $request)
    {
        return "Inside invokable controller";
    }
}
```

**Route for invokableController:**

```php
// Don't need to specify method, automatically gets __invoke
Route::get('/invoke', InvokableController::class);
```

### 2. Resource Controller

It has already predefined methods: index, create, store, show, edit, update and destroy.

**Create command:**

```bash
php artisan make:controller controller_name --resource
```

**Route:**

```php
Route::resource('/resource', ResourceController::class);
```

---

## Migration in Laravel

Migrations are version control for our database similar like Git which is version control for our code.

We track our changes over time and that database table. It allows us to define table structures and update them over time using PHP code instead of writing raw SQL query and creating tables or changing them manually.

The migrations are stored inside `database/migrations` folder.

### Commands

**Check all required tables are available:**

```bash
php artisan migrate
```

**Create migration file:**

```bash
php artisan make:migration StudentTable
```

### Migration File Structure

The migration file has by default 2 methods: `up()` and `down()`

-   **up()**: Used for creating table structures
-   **down()**: To reverse migration

### Create Migration Table with Command

```bash
php artisan make:migration create_tablename_table
```

It has by default these methods:

```php
public function up(): void
{
    Schema::create('students', function (Blueprint $table) {
        $table->id();           // columns
        $table->timestamps();
    });
}

/**
 * Reverse the migrations.
 */
public function down(): void
{
    Schema::dropIfExists('students');
}
```

### Example: Create Student Table

```php
Schema::create('students', function (Blueprint $table) {
    $table->id();
    $table->string('studentName');
    $table->integer('age');
    $table->float('percentage');
    $table->timestamps();
});
```

It automatically adds 2 columns: `created_at` and `updated_at`

---

## Modify Migration

```bash
php artisan make:migration updateMigrationName --table=table_name
```

**Example:**

```php
public function up(): void
{
    Schema::table('students', function (Blueprint $table) {
        // Insert new columns
        $table->date('date_of_birth')->nullable();
        $table->enum('gender', ['male', 'female'])->default('male');
    });
}

/**
 * Reverse the migrations.
 */
public function down(): void
{
    Schema::table('students', function (Blueprint $table) {
        // Columns to be deleted
    });
}
```

## Migration Rollback Commands

### Rollback Last Migration

```bash
php artisan migrate:rollback
```

### Rollback Till N Migration

```bash
php artisan migrate:rollback --step=2
```

### Reset Database

```bash
php artisan migrate:reset
```

It will reset the database, deletes every table and its data.

### Fresh Migration

```bash
php artisan migrate:fresh
```

It will delete all our migrations and re-migrate again.

---

## Working with Models

### Create Model

```bash
php artisan make:model model_name
```

It will create `model_name.php` file under `Http/Models` folder.

### Create Model with Controller

```bash
php artisan make:model model_name -mc
```

-   `m` for migration
-   `c` for controller

---

## CRUD Operations with Model and Controller

### Select All Records

```php
public function index()
{
    return teacher::all();
}
```

### Insert Record

```php
public function add()
{
    $item = new teacher();
    $item->name = 'test';
    $item->save();
    return teacher::all();
}
```

### Select Single Record

```php
public function getTeacher($id)
{
    $item = teacher::findOrFail($id);
    return $item;
}
```

### Update Record

```php
public function updateTeacher($id)
{
    $item = teacher::findOrFail($id);
    $item->name = 'abcd';
    $item->update();
    return "updated";
}
```

### Delete Record

```php
public function deleteTeacher($id)
{
    $item = teacher::findOrFail($id);
    $item->delete();
    return "deleted";
}
```

---

## Routes for CRUD

```php
Route::get('teachers', [TeacherController::class, 'index']);
Route::get('addTeacher', [TeacherController::class, 'add']);
Route::get('getTeacher/{id}', [TeacherController::class, 'getTeacher']);
Route::get('updateTeacher/{id}', [TeacherController::class, 'updateTeacher']);
Route::get('deleteTeacher/{id}', [TeacherController::class, 'deleteTeacher']);
```

---

## Factory

Used for testing / temporary data.

### Create Factory Command

```bash
php artisan make:factory factoryName --model=model_name
```

**Example:**

```bash
php artisan make:factory StudentFactory --model=student
```

### Problem: user_id Field Error

**Error:** Field 'user_id' doesn't have a default value during seeding.

**Cause:** user_id column is required but not provided in factory or seeder.

**Fix:**

Add `user_id` to `StudentFactory.php` like this:

```php
'user_id' => User::factory(),
```

This makes sure each student is linked to a user.

**Optional:** Make user_id nullable

Change migration to:

```php
$table->foreignId('user_id')->nullable()->constrained('users');
```

Run migrations again with:

```bash
php artisan migrate:fresh --seed
```

### Create Country Seeder

```bash
php artisan make:seeder CountriesSeeder
```

**List of countries:** [https://gist.github.com/keeguon/2310008](https://gist.github.com/keeguon/2310008)

### Run CountriesSeeder

```bash
php artisan db:seed --class=CountriesSeeder
```

---

## Run SQL Queries in Laravel

There are 3 approaches:

### 1. Raw SQL

-   **Security:** High risk of SQL injection if not properly handled
-   **Performance:** Fastest because it directly interacts with the database
-   **Flexibility:** Fully customizable, allows complex queries
-   **Maintainability:** Harder to maintain and debug, requires manual query writing

### 2. Query Builder

-   **Security:** Protects against SQL injection
-   **Performance:** Faster than Eloquent but slower than Raw SQL
-   **Flexibility:** Flexible, allows complex queries with readable syntax
-   **Maintainability:** Easier to maintain than Raw SQL but lacks full ORM capabilities

#### Insert Data Using Query Builder

```php
DB::table('students')->insert([
    "studentName" => 'test',
    "age" => 20,
    "date_of_birth" => '2005-03-16',
    "gender" => 'male',
    "percentage" => 99,
    "user_id" => 10
]);
```

#### Select Data Using Query Builder

```php
public function getData()
{
    return DB::table('students')->get();
}
```

**Additional Query Options:**

```php
// Get data with limit
DB::table('students')->limit(5)->get();

// Get first row
DB::table('students')->first();

// Get last row
DB::table('students')->last();

// Get data with where clause
DB::table('students')->where('column', 'Condition', value);
// Example: where('salary', '>=', 10000)

// Select only required columns
DB::table('students')->select('name', 'number');
```

#### Update Data

```php
DB::table('students')->where('id', $id)->update([
    'studentName' => "student5"
]);
```

#### Delete Data

```php
DB::table('students')->where('id', $id)->delete();
```

#### Aggregate Functions in Query Builder

```php
public function getStudentsCount()
{
    return DB::table('students')->count();
}
```

### 3. Eloquent ORM [Eloquent Object-Relational Mapping]

-   **Security:** High secure, prevents SQL injection
-   **Performance:** Slowest because of abstraction overhead
-   **Flexibility:** Less flexible for highly optimized queries
-   **Maintainability:** Easier to maintain, follows object-oriented principles

#### Insert Data Using Eloquent ORM

```php
$item = new Student();
$item->name = 'test';
$item->save();
```

#### Select Data

```php
// Eloquent ORM
Student::all();
```

#### Create Restriction Inside Model File

```php
protected $hidden = [
    'studentName'
];
```

It will not display the name column and can be used with Eloquent ORM only.

---

## Where Types

### Simple Where

```php
Students::where('name', 'abc');
```

### Multiple Where

```php
Students::where('name', 'abc')->orWhere('id', ">=", 20);
```

### whereAny

```php
Students::whereAny(['age', 'score'], '=', 25)->get();
```

Any from age or score equal to 25.

### whereAll

```php
Students::whereAll(['age', 'score', 'id'], '=', 25)->get();
```

All from age and score and id equal to 25.

---

## Query Scope

When we require same query output multiple times then the query scope is useful.

The function name should start with `scope` inside model file.

**Example:**

```php
public function scopeMale($query)
{
    return $query->where('gender', 'male');
}
```

### To Access These Functions

```php
$items = Student::male()->get();
```

From controller file, we can further add more conditions as needed.

---

## Soft Delete

To create soft delete, first we need to add column `deleted_at` for tracking deleted records.

### Command to Create Soft Delete Migration

```bash
php artisan make:migration addSoftDeleteToStudentsTable
```

It does not delete the data but the deleted record does not get selected.

### Inside Controller

```php
$item = Student::findOrFail($id);
$item->delete();
```

### Get Deleted Records

```php
// To select deleted students
$item = Student::onlyTrashed()->get();

// To select all students including deleted students
$item = Student::withTrashed()->get();
```

### Restore Deleted Students

```php
// To restore deleted student
$item = Student::withTrashed()->find(7)->restore();
```

### To Permanently Delete Item

```php
Student::find($id)->forceDelete();
```

---

## Additional Resources

-   [Laravel Documentation](https://laravel.com/docs)
-   [Blade Templates Documentation](https://laravel.com/docs/12.x/blade)
-   [Laravel Eloquent Documentation](https://laravel.com/docs/eloquent)
-   [Laravel Query Builder Documentation](https://laravel.com/docs/queries)
-   [Laravel Migrations Documentation](https://laravel.com/docs/migrations)

---

**Note:** This guide covers Laravel Models, CRUD operations, database queries, and advanced features like soft deletes and query scopes. Always refer to the official Laravel documentation for the most up-to-date information.
