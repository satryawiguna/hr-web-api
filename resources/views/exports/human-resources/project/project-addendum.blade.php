<style type="text/css" media="all">
    .table_project_addendum-export {
        border: solid 1px #F4F3F8;
        border-collapse: collapse;
        border-spacing: 0;
    }

    .table_project_addendum-export thead th {
        background-color: #F4F3F8;
        border: solid 1px #F4F3F8;
        color: #575962;
        padding: 10px;
        text-align: left;
        text-shadow: 1px 1px 1px #fff;
    }

    .table_project_addendum-export tbody td {
        border: solid 1px #F4F3F8;
        color: #333;
        padding: 10px;
        text-shadow: 1px 1px 1px #fff;
    }
</style>

<table class="table_project_addendum-export">
    <thead>
    <tr>
        <th>Project Name</th>
        <th>Reference Number</th>
        <th>Name</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Value</th>
    </tr>
    </thead>
    <tbody>
    @foreach($projectAddendums as $projectAddendum)
        <tr>
            <td>{{ $projectAddendum->project->name ?? null }}</td>
            <td>{{ $projectAddendum->reference_number ?? null }}</td>
            <td>{{ $projectAddendum->name ?? null }}</td>
            <td>{{ $projectAddendum->start_date ?? null }}</td>
            <td>{{ $projectAddendum->end_date ?? null }}</td>
            <td>{{ $projectAddendum->value ?? null }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
