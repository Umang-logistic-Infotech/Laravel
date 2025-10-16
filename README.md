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
-   [Implement Search Optional](#implement-search-optional)
-   [Display Images](#display-images)
-   [Insert Data from GUI](#insert-data-from-gui)
-   [CSRF Protection](#csrf-protection)
-   [Edit Student](#edit-student)
-   [Delete Student](#delete-student)
-   [Validation](#validation)
-   [Retain Old Values After Error](#retain-old-values-after-error)
-   [File Storage in Laravel](#file-storage-in-laravel)
-   [Eloquent Relationships](#eloquent-relationships)
-   [Laravel 12 Authentication Packages](#laravel-12-authentication-packages)

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

        or

        @section('content')
            <p>Welcome to the home page!</p>
        @endsection


        or

        @section('title')
            @include('Components.title', ['title' => 'Home Page'])
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

# Laravel Forms, Search and Validation Guide

## Implement Search Optional

Add request parameter to function to handle the incoming request.

### Route

```php
Route::get('/', function () {
    $students = (new StudentController)->index(request());
    return view('home', compact('students'));
});
```

### Controller

#### WITHOUT LIMITATION/PAGINATION/like query

```php
public function index(Request $request)
{
    // return Student::all();
    return Student::when($request->search, function ($query) use ($request) {
        return $query->whereAny([
            'studentName',
            'age',
            'percentage',
            'gender',
            'date_of_birth'
        ], $request->search);  // SEARCH QUERY
    })->get();  // WITHOUT LIMITATION/PAGINATION
}
```

#### WITHOUT LIMITATION/PAGINATION with like query

```php
public function index(Request $request)
{
    // return Student::all();
    return Student::when($request->search, function ($query) use ($request) {
        return $query->whereAny([
            'studentName',
            'age',
            'percentage',
            'gender',
            'date_of_birth'
        ], 'like', '%' . $request->search . '%');  // SEARCH LIKE QUERY
    })->get();  // WITHOUT LIMITATION/PAGINATION
}
```

#### WITH LIMITATION/PAGINATION/like query

```php
public function index(Request $request)
{
    // return Student::all();
    return Student::when($request->search, function ($query) use ($request) {
        return $query->whereAny([
            'studentName',
            'age',
            'percentage',
            'gender',
            'date_of_birth'
        ], 'like', '%' . $request->search . '%');  // SEARCH LIKE QUERY
    })->paginate(10);  // WITH LIMITATION/PAGINATION
}
```

### Get the Requested Value from URL

```blade
<input type="search" placeholder="Enter student name" id="search"
       name="search" value="{{ request('search') }}" />
```

### Handle PAGINATION with Bootstrap Pagination

We also need to add CDN link to main `app.blade.php` file.

```blade
<div class="pagination">
    {{ $students->links('pagination::bootstrap-5') }}
</div>
```

### Append All Previous Requests

`appends(request()->query())` for previous requests.

```blade
<div class="pagination">
    {{ $students->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>
```

---

## Display Images

The images should be inside the public folder.

```blade
<img src="{{ asset('images/delete.svg') }}" class="deleteButton m-0" alt="Delete">
```

---

## Insert Data from GUI

### Route to Create Student

```php
Route::post('createStudent', 'createStudent');
```

### Form Action to Submit Insert Data

```blade
<form method="POST" action="{{ URL('/createStudent') }}">
```

But here we need to write `@csrf` after this form line to prevent against attacks. If we did not write it, we get **419 Page Expired** error.

```blade
<form method="POST" action="{{ URL('/createStudent') }}">
    @csrf
```

---

## CSRF Protection

### Use of @csrf

The `@csrf` Blade directive in Laravel is used to protect web applications from **Cross-Site Request Forgery (CSRF)** attacks. CSRF is a type of attack where a malicious website tricks an authenticated user into submitting a form or making a request to another website without their knowledge, potentially leading to unauthorized actions.

### Our Actual Code

```blade
<form method="POST" action="/submit-data">
    @csrf
    <!-- Other form fields -->
    <button type="submit">Submit</button>
</form>
```

### This Will Render As

```html
<form method="POST" action="/submit-data">
    <input type="hidden" name="_token" value="YOUR_CSRF_TOKEN_HERE" />
    <!-- Other form fields -->
    <button type="submit">Submit</button>
</form>
```

### How @csrf Works

1. **CSRF Token Generation:** Laravel automatically generates a unique CSRF "token" for each active user session. This token is a random, unguessable string that is associated with the user's session.

2. **Inclusion in Forms:** When you use the `@csrf` Blade directive within an HTML form in your Laravel application, it generates a hidden input field containing this unique CSRF token.

3. **Token Validation:** When the form is submitted, Laravel's `VerifyCsrfToken` middleware automatically checks if the submitted token matches the one stored in the user's session. If the tokens don't match or the token is missing, Laravel will reject the request, typically with a **419 HTTP status code (Page Expired)**, preventing the CSRF attack.

---

## Edit Student

Same as create student, just 1 change: `$student->update();`

---

## Delete Student

To handle delete with confirm dialog:

```blade
<form action="{{ URL('/deleteStudent/' . $student->id) }}" method="POST"
      onsubmit="return confirm('Are you sure you want to delete this student?')">
    @csrf
    @method('delete')
    <button type="submit" class="deleteButton m-0" style="background: none; border: none;">
        <img src="{{ asset('images/delete.svg') }}" alt="Delete">
    </button>
</form>
```

**Notes:**

-   Button to handle submit form
-   Form to handle confirm dialog
-   We also need to change method to delete for delete record

---

## Validation

### Validation from Controller

Verify all fields before inserting/updating:

```php
$request->validate([
    'studentName' => 'required|string|max:255',
    'studentUserId' => 'required|integer|max:255',
    'studentAge' => 'required|integer|min:10|max:50',
    'studentDateOfBirth' => 'required|date',
    'studentGender' => 'required|in:male,female',
    'studentPercentage' => 'required|integer|min:0|max:100'
]);
```

### Display Errors Inside View Component

```blade
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
```

### Custom Error Messages

```php
$request->validate([
    'studentName' => 'required|string|max:255',
    'studentUserId' => 'required|integer|max:255',
    'studentAge' => 'required|integer|min:10|max:50',
    'studentDateOfBirth' => 'required|date',
    'studentGender' => 'required|in:male,female',
    'studentPercentage' => 'required|integer|min:0|max:100'
], [
    'studentName.required' => 'Student name is required',
    'studentAge.max' => 'Age must be under 50',
    'studentDateOfBirth.required' => 'Date of birth is required',
    'studentGender.required' => 'Gender is required',
    'studentPercentage.required' => 'Percentage is required',
    'studentUserId.required' => 'User id is required'
]);
```

---

## Form Request Validation

For clean and clear coding, use Form Request classes.

### Create Form Request

**Command:**

```bash
php artisan make:request StudentAddRequest
```

### Configure Form Request

Then go to `Http/Request` folder and make changes:

#### 1. Change Authorization

Make the return type from `false` to `true`:

```php
public function authorize(): bool
{
    return true;
}
```

#### 2. Add Validation Rules

Put all rules under this method:

```php
public function rules(): array
{
    return [
        'studentName' => 'required|string|max:255',
        'studentUserId' => 'required|integer|max:255',
        'studentAge' => 'required|integer|min:10|max:50',
        'studentDateOfBirth' => 'required|date',
        'studentGender' => 'required|in:male,female',
        'studentPercentage' => 'required|integer|min:0|max:100'
    ];
}
```

#### 3. Add Custom Error Messages

Add your custom error handling messages to a new method `messages()`:

```php
public function messages()
{
    return [
        'studentName.required' => 'Student name is required',
        'studentAge.max' => 'Age must be under 50',
        'studentDateOfBirth.required' => 'Date of birth is required',
        'studentGender.required' => 'Gender is required',
        'studentPercentage.required' => 'Percentage is required',
        'studentUserId.required' => 'User id is required'
    ];
}
```

#### 4. Update Controller Method

Change the request argument from `(Request $request)` to `(StudentAddRequest $request)`:

```php
public function createStudent(StudentAddRequest $request)
{
    // Your logic here
}
```

# Laravel File Storage, Relations and Authentication

## Retain Old Values After Error

To get old values back after error, replace:

```blade
value="{{ $Student->studentName }}"
```

With:

```blade
value="{{ old('studentName') }}"
```

---

## File Storage in Laravel

### Add Enctype to Form Element

```blade
<form enctype="multipart/form-data">
```

### Check if Image is Selected or Not

```php
$imagePath = null;
if ($request->hasFile('studentImage')) {
    $imagePath = $request->file('studentImage')->store('photoes', 'public');
}
```

### Validation for Images

```php
'studentImage' => 'nullable|image|mimes:png,jpg,jpeg,svg,gif|max:2048'
```

### Store File Path in Database

Store file at the folder location `storage/photoes`:

```php
$imagePath = null;
if ($request->hasFile('studentImage')) {
    $imagePath = $request->file('studentImage')->store('photoes', 'public');
}
$Student->profileImage = $imagePath;
```

### Display Image in UI

To display image in UI, first we need to create link from storage folder to public folder with command:

```bash
php artisan storage:link
```

Then display the image:

```blade
@if ($student->profileImage)
    <img src="{{ asset('storage/' . $student->profileImage) }}" width="50" />
@endif
```

### Delete Image When User is Deleted

```php
if ($student->profileImage) {
    Storage::disk('public')->delete($student->profileImage);
}
```

---

## Eloquent Relationships

Eloquent Relationships in Laravel is an ORM (Object-Relational Mapping) tool used to interact with a database in a more object-oriented manner. The relationships define how different models (tables) are related to each other.

### Types of Relationships

1. One to One
2. Has-One-Through
3. One to Many
4. Has-Many-Through
5. Many to Many
6. Polymorphic

---

## 1. One-to-One Relationship

A one-to-one relationship means that one record in a model is associated with exactly one record in another model.

### Example

Let's assume we have two models: `User` and `Profile`. Each User has one Profile.

**Database Tables:**

-   `users` table
-   `profiles` table (contains `user_id` to reference the users table)

**How to Define:**

In the `User` model:

```php
public function profile() {
    return $this->hasOne(Profile::class);
}
```

In the `Profile` model:

```php
public function user() {
    return $this->belongsTo(User::class);
}
```

**Accessing the Relation:**

```php
$user = User::find(1);
$profile = $user->profile;  // Access the related profile
```

---

## 2. Has-One-Through Relationship

A has-one-through relationship is used when a model has a one-to-one relationship with another model, but the linking table is in between.

### Example

Let's say we have three models: `Country`, `User`, and `Profile`. A Country has many Users, and each User has one Profile. The country indirectly has one Profile through the User.

**Database Tables:**

-   `countries` table
-   `users` table (linked to countries)
-   `profiles` table (linked to users)

**How to Define:**

In the `Country` model:

```php
public function profile() {
    return $this->hasOneThrough(Profile::class, User::class);
}
```

**Accessing the Relation:**

```php
$country = Country::find(1);
$profile = $country->profile;  // Access profile of the country through the user
```

---

## 3. One-to-Many Relationship

A one-to-many relationship means one record in the first model can be associated with many records in the second model.

### Example

Consider a `Post` and `Comment` model. A single Post can have many Comments.

**Database Tables:**

-   `posts` table
-   `comments` table (contains `post_id` to reference the posts table)

**How to Define:**

In the `Post` model:

```php
public function comments() {
    return $this->hasMany(Comment::class);
}
```

In the `Comment` model:

```php
public function post() {
    return $this->belongsTo(Post::class);
}
```

**Accessing the Relation:**

```php
$post = Post::find(1);
$comments = $post->comments;  // Get all comments related to this post
```

---

## 4. Has-Many-Through Relationship

A has-many-through relationship is used when you want to access a model's related models via an intermediate model, but there is no direct foreign key in the intermediate table for the relationship.

### Example

Let's say we have three models: `Country`, `User`, and `Post`. A Country has many Users, and each User has many Posts. The country indirectly has many Posts through Users.

**Database Tables:**

-   `countries` table
-   `users` table (linked to countries)
-   `posts` table (linked to users)

**How to Define:**

In the `Country` model:

```php
public function posts() {
    return $this->hasManyThrough(Post::class, User::class);
}
```

**Accessing the Relation:**

```php
$country = Country::find(1);
$posts = $country->posts;  // Get all posts related to the country through users
```

---

## 5. Many-to-Many Relationship

A many-to-many relationship means that multiple records in one model can be associated with multiple records in another model.

### Example

Consider `Role` and `User` models. A User can have many Roles, and a Role can be assigned to many Users.

**Database Tables:**

-   `users` table
-   `roles` table
-   `role_user` pivot table (containing `user_id` and `role_id`)

**How to Define:**

In the `User` model:

```php
public function roles() {
    return $this->belongsToMany(Role::class);
}
```

In the `Role` model:

```php
public function users() {
    return $this->belongsToMany(User::class);
}
```

**Accessing the Relation:**

```php
$user = User::find(1);
$roles = $user->roles;  // Get all roles assigned to this user
```

**To Attach a Role to a User:**

```php
$user->roles()->attach($roleId);
```

**To Detach a Role from a User:**

```php
$user->roles()->detach($roleId);
```

---

## 6. Polymorphic Relationships

A polymorphic relationship allows a model to belong to more than one other model on a single association.

### Example

Consider a `Comment` model that can belong to both `Post` and `Video` models. A Comment can be made on either a Post or a Video, so instead of creating two separate tables for comments (post_comments and video_comments), we use a single comments table with a polymorphic relationship.

**Database Tables:**

-   `posts` table
-   `videos` table
-   `comments` table (containing `commentable_id` and `commentable_type` to reference both Post and Video)

**How to Define:**

In the `Post` model:

```php
public function comments() {
    return $this->morphMany(Comment::class, 'commentable');
}
```

In the `Video` model:

```php
public function comments() {
    return $this->morphMany(Comment::class, 'commentable');
}
```

In the `Comment` model:

```php
public function commentable() {
    return $this->morphTo();
}
```

**Accessing the Relation:**

```php
$post = Post::find(1);
$comments = $post->comments;  // Get all comments related to the post

$video = Video::find(1);
$comments = $video->comments;  // Get all comments related to the video
```

**To Associate a Comment with a Post or Video:**

```php
$comment = new Comment();
$comment->body = 'Nice post!';
$post->comments()->save($comment);  // This will automatically set commentable_type to 'Post'
```

---

## Summary of Eloquent Relationships

| Relationship         | Description                                                                                        |
| -------------------- | -------------------------------------------------------------------------------------------------- |
| **One-to-One**       | One record in model A is related to one record in model B                                          |
| **Has-One-Through**  | One model (A) has one related model (C), but the relationship is through an intermediary model (B) |
| **One-to-Many**      | One record in model A can have many related records in model B                                     |
| **Has-Many-Through** | One model (A) can have many related models (C) through an intermediary model (B)                   |
| **Many-to-Many**     | Many records in model A can be associated with many records in model B through a pivot table       |
| **Polymorphic**      | A model can belong to more than one model, using a single relationship column (type and ID)        |

These relationships allow you to design more complex and flexible data models in your Laravel applications.

---

## Laravel 12 Authentication Packages

Laravel 12 offers four main authentication packages: **Bootstrap UI**, **Jetstream**, **Fortify**, and **Breeze**.

### Comparison Table

| Feature / Package             | Bootstrap UI                                | Jetstream                                                                  | Fortify                                                                                      | Breeze                                                       |
| ----------------------------- | ------------------------------------------- | -------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------- | ------------------------------------------------------------ |
| **Primary Focus**             | Basic authentication with minimal setup     | Comprehensive authentication with additional features                      | Backend-focused authentication (no UI)                                                       | Simple authentication with basic UI                          |
| **User Interface (UI)**       | Yes, includes Bootstrap-based UI            | Yes, with Tailwind CSS and a complete UI                                   | No built-in UI (only API responses)                                                          | Yes, simple UI with Tailwind CSS                             |
| **Frontend Framework**        | Bootstrap                                   | Tailwind CSS (includes Livewire for interactivity)                         | None (No frontend)                                                                           | Tailwind CSS                                                 |
| **Authentication Features**   | Login, Register, Forgot Password            | Login, Register, Two-Factor Authentication, Profile Management, API Tokens | Login, Registration, Password Reset, Two-Factor Authentication, Email Verification (via API) | Login, Register, Forgot Password                             |
| **Two-Factor Authentication** | No                                          | Yes                                                                        | Yes                                                                                          | No                                                           |
| **API Authentication**        | No                                          | Yes (via Laravel Sanctum)                                                  | Yes (via Laravel Sanctum)                                                                    | No                                                           |
| **Profile Management**        | No                                          | Yes (with Livewire)                                                        | No                                                                                           | No                                                           |
| **Team Management**           | No                                          | Yes (Team-based features like creating teams, managing roles)              | No                                                                                           | No                                                           |
| **Livewire Integration**      | No                                          | Yes                                                                        | No                                                                                           | No                                                           |
| **Customizable Views**        | Yes, but with Bootstrap components          | Yes, Tailwind-based views (customizable)                                   | N/A (no views included)                                                                      | Yes, simple Tailwind-based views                             |
| **Multi-Auth Support**        | Yes, requires manual configuration          | Yes, with support for teams and roles                                      | Yes, but requires manual configuration                                                       | Yes, but requires manual configuration                       |
| **Social Authentication**     | No                                          | Yes, via Laravel Socialite                                                 | No (API-based, no frontend)                                                                  | No                                                           |
| **Session / Remember Me**     | Yes, built-in support for sessions          | Yes, built-in support for sessions                                         | Yes                                                                                          | Yes                                                          |
| **Password Reset**            | Yes                                         | Yes                                                                        | Yes                                                                                          | Yes                                                          |
| **API / SPA Authentication**  | No                                          | Yes, built-in support (via Laravel Sanctum)                                | Yes, supports API/SPA authentication                                                         | No                                                           |
| **Installation Complexity**   | Low, quick and simple setup                 | Moderate, requires more configuration                                      | High, as it's only backend and requires you to build the UI separately                       | Low, quick and simple setup                                  |
| **Intended Use Case**         | Basic app with minimal authentication needs | Full-featured apps requiring user management and team collaboration        | API-based apps where authentication is handled via API (no UI)                               | Simple apps with standard authentication needs               |
| **Supports Laravel Fortify**  | No                                          | Yes                                                                        | Yes                                                                                          | No                                                           |
| **Backend Focus**             | No                                          | Yes (Livewire + Fortify)                                                   | Yes (completely backend)                                                                     | No                                                           |
| **Use Case Examples**         | Small apps or basic auth functionality      | SaaS apps, complex user management, and teams                              | API-only apps, mobile apps, or SPAs                                                          | Small apps, rapid prototypes, or simple authentication needs |

---

## Summary of Authentication Packages

### Bootstrap UI

-   **Simple and easy-to-implement** package with minimal authentication features
-   Comes with **Bootstrap-based UI** components but lacks advanced features like two-factor authentication or team management
-   **Ideal for:** Small applications where you just need login/register functionalities quickly

### Jetstream

-   **Full-featured authentication system** built with Tailwind CSS
-   Supports **two-factor authentication, team management, profile management**, and **API token management**
-   **Recommended for:** More complex apps like SaaS platforms or applications that require real-time features (Livewire)

### Fortify

-   **Backend-focused authentication** package with no UI components
-   Works well for **API-based applications** or SPAs where you want to handle authentication through an API (using Laravel Sanctum)
-   **Highly customizable** but requires you to build your own frontend/UI

### Breeze

-   **Simple and minimalistic** authentication solution using Tailwind CSS
-   Provides the **basic authentication features** such as login, registration, and password reset
-   **Ideal for:** Small projects, rapid prototyping, or when you need something simple and straightforward without complex features like teams or two-factor authentication

---

## Additional Resources

-   [Laravel Documentation](https://laravel.com/docs)
-   [Blade Templates Documentation](https://laravel.com/docs/12.x/blade)
-   [Laravel Eloquent Documentation](https://laravel.com/docs/eloquent)
-   [Laravel Query Builder Documentation](https://laravel.com/docs/queries)
-   [Laravel Migrations Documentation](https://laravel.com/docs/migrations)
-   [Laravel Validation Documentation](https://laravel.com/docs/validation)
-   [Laravel Form Requests Documentation](https://laravel.com/docs/validation#form-request-validation)
-   [Laravel CSRF Protection Documentation](https://laravel.com/docs/csrf)
-   [Laravel File Storage Documentation](https://laravel.com/docs/filesystem)
-   [Laravel Eloquent Relationships Documentation](https://laravel.com/docs/eloquent-relationships)
-   [Laravel Authentication Documentation](https://laravel.com/docs/authentication)
-   [Laravel Breeze Documentation](https://laravel.com/docs/starter-kits#laravel-breeze)
-   [Laravel Jetstream Documentation](https://jetstream.laravel.com)

---

**Note:** This guide is for reference purpose only.
