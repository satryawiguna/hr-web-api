<style type="text/css" media="all">
    .table_vacancies-export {
        border: solid 1px #F4F3F8;
        border-collapse: collapse;
        border-spacing: 0;
    }

    .table_vacancies-export thead th {
        background-color: #F4F3F8;
        border: solid 1px #F4F3F8;
        color: #575962;
        padding: 10px;
        text-align: left;
        text-shadow: 1px 1px 1px #fff;
    }

    .table_vacancies-export tbody td {
        border: solid 1px #F4F3F8;
        color: #333;
        padding: 10px;
        text-shadow: 1px 1px 1px #fff;
    }
</style>

<table class="table_vacancies-export">
    <thead>
    <tr>
        <th>Vacancy Name</th>
        <th>Gender</th>
        <th>Religion</th>
        <th>Marital Status</th>
        <th>NIK</th>
        <th>Name</th>
        <th>Country</th>
        <th>Province</th>
        <th>City</th>
        <th>Address</th>
        <th>Post Code</th>
        <th>Passport Number</th>
        <th>Passport Expired Date</th>
        <th>Visa Number</th>
        <th>Visa Expired Date</th>
        <th>Birth Date</th>
        <th>Birth Place</th>
        <th>Age</th>
        <th>Weight</th>
        <th>Height</th>
        <th>Phone</th>
        <th>Mobile</th>
        <th>Email</th>
        <th>Linkedin</th>
        <th>Website</th>
    </tr>
    </thead>
    <tbody>
    @foreach($applicants as $applicant)
        <tr>
            <td>{{ $applicant->vacancy->title ?? null }}</td>
            <td>{{ $applicant->gender->name ?? null }}</td>
            <td>{{ $applicant->religion->name ?? null }}</td>
            <td>{{ $applicant->maritalStatus->name ?? null }}</td>
            <td>{{ $applicant->nik ?? null }}</td>
            <td>{{ $applicant->full_name ?? null }}</td>
            <td>{{ $applicant->country ?? null }}</td>
            <td>{{ $applicant->state_or_province ?? null }}</td>
            <td>{{ $applicant->city ?? null }}</td>
            <td>{{ $applicant->address ?? null }}</td>
            <td>{{ $applicant->postcode ?? null }}</td>
            <td>{{ $applicant->passport_number ?? null }}</td>
            <td>{{ $applicant->passport_expired_date ?? null }}</td>
            <td>{{ $applicant->visa_number ?? null }}</td>
            <td>{{ $applicant->visa_expired_number ?? null }}</td>
            <td>{{ $applicant->birth_date ?? null }}</td>
            <td>{{ $applicant->birth_place ?? null }}</td>
            <td>{{ $applicant->age ?? null }}</td>
            <td>{{ $applicant->weight ?? null }}</td>
            <td>{{ $applicant->height ?? null }}</td>
            <td>{{ $applicant->phone ?? null }}</td>
            <td>{{ $applicant->mobile ?? null }}</td>
            <td>{{ $applicant->email ?? null }}</td>
            <td>{{ $applicant->linkedin ?? null }}</td>
            <td>{{ $applicant->website ?? null }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
