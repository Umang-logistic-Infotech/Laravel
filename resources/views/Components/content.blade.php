<div class="d-flex align-items-center">
    <form action={{ URL('/') }} method="GET">
        <div class="search p-2">
            {{-- <div class="search position-fixed"> --}}
            <input type="search" placeholder="Enter student name" id="search" name="search"
                value="{{ request('search') }}" />
            <button type="submit" class="btn border-black">search</button>
        </div>

    </form>
    <div>
        <a class="btn button border rounded" href="{{ URL('/addStudent') }}"> create student</a>
    </div>
</div>

{{-- <div style="height: 80"> --}}
<table class="table table-bordered table-striped p-1">
    <thead class="table-dark">

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
                <td id="delete-{{ $student->id }}">
                    <a href="{{ URL('/getStudent/' . $student->id) }}">
                        <img src="{{ asset('images/edit.svg') }}" class="deleteButton m-0" alt="Edit">
                    </a>
                </td>
                <td id="delete-{{ $student->id }}">
                    {{-- <a href="{{ URL('/deleteStudent/' . $student->id) }}"> --}}
                    <form action="{{ URL('/deleteStudent/' . $student->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this student?')">
                        @csrf
                        @method('delete')
                        <button type="submit" class="deleteButton m-0" style="background: none; border: none;">
                            <img src="{{ asset('images/delete.svg') }}" alt="Delete">
                        </button>
                    </form>

                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{-- </div> --}}


<div class="pagination justify-content-center">
    {{ $students->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>
