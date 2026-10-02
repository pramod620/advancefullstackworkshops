<?php

use App\Models\Student;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider within a group
| which contains the "web" middleware group. Now create something great!
|
*/

// Home page
Route::get('/', function () {
    return redirect()->route('students.create');
});

// Step 9: Show the Create Student form
Route::get('/student/create', function () {
    return view('student.create');
})->name('students.create');

// Step 9: Handle form submission (basic version without validation)
Route::post('/student-basic', function (Request $request) {
    $student_data = $request->only([
        'name',
        'email',
        'phone',
        'address',
        'date_of_birth',
    ]);

    $student = Student::create($student_data);

    return "Student {$student->name} created successfully!";
});

// Step 10: Handle form submission (with validation)
Route::post('/student', function (Request $request) {
    $validated = $request->validate([
        'name'          => 'required|string|max:255',
        'email'         => 'required|email|max:255',
        'phone'         => 'required|string|max:20',
        'address'       => 'nullable|string|max:500',
        'date_of_birth' => 'nullable|date',
    ]);

    $student = Student::create($validated);

    return "Student {$student->name} created successfully!";
});

// Step 12: Student List Route
Route::get('/students', function () {
    $students = Student::all();

    return view('student.list', [
        'students' => $students
    ]);
})->name('students.index');

// Step 12: Create Student Route with Validation + Redirect
Route::post('/student', function (Request $request) {
    $validated = $request->validate([
        'name'          => 'required|string|max:255',
        'email'         => 'required|email|max:255',
        'phone'         => 'required|string|max:20',
        'address'       => 'nullable|string|max:500',
        'date_of_birth' => 'nullable|date',
    ]);

    $student = Student::create($validated);

    return redirect()->route('students.index')
        ->with('success', "Student {$student->name} created successfully!");
});

// Step 13: Student Detail Route
Route::get('/students/{id}', function ($id) {
    $student = Student::findOrFail($id);

    return view('student.detail', [
        'student' => $student
    ]);
});

// Step 14: Student Edit Routes
Route::get('/students/{id}/edit', function ($id) {
    $student = Student::findOrFail($id);

    return view('student.edit', [
        'student' => $student
    ]);
});

Route::put('/students/{id}', function (Request $request, $id) {
    $student = Student::findOrFail($id);

    $validated = $request->validate([
        'name'          => 'required|string|max:255',
        'email'         => ['required', 'email', 'max:255', Rule::unique('students')->ignore($student->id)],
        'phone'         => 'required|string|max:20',
        'address'       => 'nullable|string',
        'date_of_birth' => 'nullable|date',
    ]);

    $student->update($validated);

    return redirect('/students/' . $student->id)
        ->with('success', 'Student updated successfully!');
});

// Step 15: Student Delete Route
Route::delete('/students/{id}', function ($id) {
    $student = Student::findOrFail($id);
    $student->delete();

    return redirect('/students')
        ->with('success', 'Student deleted successfully!');
});
