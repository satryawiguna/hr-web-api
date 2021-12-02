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
        <th>Company Name</th>
        <th>Position Name</th>
        <th>Degree</th>
        <th>Publish Date</th>
        <th>Expired Date</th>
        <th>Title</th>
        <th>Start Salary</th>
        <th>End Salary</th>
        <th>Work Status</th>
        <th>Language</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($vacancies as $vacancy)
        <tr>
            <td>{{ $vacancy->company->name ?? null }}</td>
            <td>{{ $vacancy->position->name ?? null }}</td>
            <td>{{ $vacancy->degree->name ?? null }}</td>
            <td>{{ $vacancy->publish_date ?? null }}</td>
            <td>{{ $vacancy->expired_date ?? null }}</td>
            <td>{{ $vacancy->title ?? null }}</td>
            <td>{{ $vacancy->start_salary ?? null }}</td>
            <td>{{ $vacancy->end_salary ?? null }}</td>
            <td>{{ $vacancy->work_status ?? null }}</td>
            <td>{{ $vacancy->language ?? null }}</td>
            <td>{{ $vacancy->status ?? null }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
