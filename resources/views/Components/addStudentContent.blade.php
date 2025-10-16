<div class="container">
    @if ($errors->any())
        <div class="alert alert-denger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ URL('/createStudent') }}" enctype="multipart/form-data">

        @csrf
        <div class="row m-4 p-2 border rounded">
            <label for="studentName" class="col-sm-2  col-form-label">Student Name :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="studentName" name="studentName" placeholder="Student Name"
                    aria-label="studentName">
            </div>
        </div>

        <div class="row m-4 p-2 border rounded">
            <label for="studentImage" class="col-sm-2  col-form-label">Student Profile Image :</label>
            <div class="col-sm-10">
                <input type="file" class="form-control" id="studentImage" name="studentImage"
                    placeholder="Student Image" aria-label="studentAge" accept="image/*">
            </div>
        </div>
        <div class="row m-4 p-2 border rounded">
            <label for="studentAge" class="col-sm-2  col-form-label">Student Age :</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="studentAge" name="studentAge" placeholder="Student Age"
                    aria-label="studentAge">
            </div>
        </div>

        <div class="row m-4 p-2 border rounded">
            <label for="studentPercentage" class="col-sm-2  col-form-label">Student Percentage :</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="studentPercentage" name="studentPercentage"
                    placeholder="Student Percentage" aria-label="studentPercentage">
            </div>
        </div>

        <div class="row m-4 p-2 border rounded">
            <label for="studentDateOfBirth" class="col-sm-2  col-form-label">Student Date Of Birth :</label>
            <div class="col-sm-10">

                <input type="date" class="form-control" id="studentDateOfBirth" name="studentDateOfBirth"
                    placeholder="Student Date Of Birth" aria-label="studentDateOfBirth">
            </div>
        </div>

        <div class="row m-4 p-2 border rounded">
            <label for="studentGender" class="col-sm-2  col-form-label">Student Gender :</label>
            <div class="col-sm-10">
                <select name="studentGender" class="form-control" aria-placeholder="Select Gender" id="studentGender"
                    name="studentGender">
                    <option selected value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
        </div>

        <div class="row m-4 p-2 border rounded">
            <label for="studentUserID" class="col-sm-2  col-form-label">Student User ID :</label>
            <div class="col-sm-10">

                <input type="number" class="form-control" value="1" id="studentUserId" name="studentUserId"
                    aria-label="studentUserId">
            </div>
        </div>

        <div class="row m-4 p-2">
            <div class="col-sm-2">
                <button type="submit" class="btn btn-primary form-control"> Save </button>
            </div>
        </div>
    </form>
</div>
</form>
</div>
