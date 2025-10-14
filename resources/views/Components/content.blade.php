<table class="table table-bordered table-striped">
    <thead>
        <th> ID </th>
        <th> Student Name </th>
        <th> Age </th>
        <th> Gender </th>
        <th> Percentage </th>
        <th> Result </th>
    </thead>
    <tbody>
        @foreach ($students as $student)
            <tr>
                <td>{{ $student->id }}</td>
                <td>{{ $student->studentName }}</td>
                <td>{{ $student->age }}</td>
                <td>{{ $student->gender }}</td>
                <td>{{ $student->percentage }}</td>

                <td>
                    @if ($student->percentage >= 35)
                        <p class="bg-success text-white text-center rounded w-25 m-0">
                            Pass
                        </p>
                    @else
                        <p class="bg-danger text-white text-center rounded w-25 m-0">
                            Fail
                        </p>
                    @endif

                </td>
            </tr>
        @endforeach
    </tbody>
</table>
