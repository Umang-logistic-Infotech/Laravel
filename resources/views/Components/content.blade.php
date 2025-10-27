<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center px-3 py-2">
        <div class="d-flex align-items-center gap-3">
            <form action="{{ URL('dashboard/') }}" method="GET" enctype="multipart/form-data"
                class="d-flex align-items-center gap-2">
                <input type="search" placeholder="Enter student name" id="search" name="search"
                    value="{{ request('search') }}" class="form-control" />
                <button type="submit" class="btn btn-outline-dark">Search</button>
            </form>

            @if (@session('success'))
                {{ session('success') }}
            @endif

        </div>
        <div class="d-flex align-items-center">
            <a class="btn btn-outline-primary" href="{{ URL('/addStudent') }}">Create Student</a>

        </div>
    </div>

    <table class="table table-bordered table-striped p-1">
        <thead class="table-dark">

            <th> Profile Photo </th>
            <th> ID </th>
            <th> Student Name </th>
            <th> Age </th>
            <th> Date of Birth </th>
            <th> Gender </th>
            <th> Percentage </th>
            <th> Result </th>
            <th colspan="2"> Actions </th>
        </thead>
        <tbody class="table-group-divider">
            @foreach ($students as $student)
                <tr>
                    <td>
                        @if ($student->profileImage)
                            <img src="{{ asset('storage/' . $student->profileImage) }}" width="50" height="25"
                                class="rounded-circle" />
                        @else
                            <img src="{{ asset('images/default profile.png') }}" width="50" height="25"
                                class="rounded-circle" />
                        @endif
                    </td>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->studentName }}</td>
                    <td>{{ $student->age }}</td>
                    <td>{{ $student->date_of_birth }}</td>
                    <td>{{ $student->gender }}</td>
                    <td>{{ $student->percentage }}</td>

                    <td class="">
                        @if ($student->percentage >= 35)
                            <p class="bg-success text-white text-center rounded w-50 m-0">
                                Pass
                            </p>
                        @else
                            <p class="bg-danger text-white text-center rounded w-50 m-0">
                                Fail
                            </p>
                        @endif
                    </td>

                    @can('teacher')
                        @can('update', $student)
                            <td id="delete-{{ $student->id }}">
                                <a href="{{ URL('/getStudent/' . $student->id) }}">
                                    <img src="{{ asset('images/edit.svg') }}" class="deleteButton m-0" alt="Edit">
                                </a>
                            </td>
                            <td id="delete-{{ $student->id }}">
                                <form action="{{ URL('/deleteStudent/' . $student->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this student?')">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="deleteButton m-0" style="background: none; border: none;">
                                        <img src="{{ asset('images/delete.svg') }}" alt="Delete">
                                    </button>
                                </form>
                            </td>
                        @endcan
                    @endcan

                </tr>
            @endforeach
        </tbody>
    </table>


    <div class="pagination justify-content-center">
        {{ $students->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>

</div>
