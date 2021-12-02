<style type="text/css" media="all">
    .table_project-export {
        border: solid 1px #F4F3F8;
        border-collapse: collapse;
        border-spacing: 0;
    }

    .table_project-export thead th {
        background-color: #F4F3F8;
        border: solid 1px #F4F3F8;
        color: #575962;
        padding: 10px;
        text-align: left;
        text-shadow: 1px 1px 1px #fff;
    }

    .table_project-export tbody td {
        border: solid 1px #F4F3F8;
        color: #333;
        padding: 10px;
        text-shadow: 1px 1px 1px #fff;
    }
</style>

<table class="table_project-export">
    <thead>
    <tr>
        <th>Company Name</th>
        <th>Type Contract</th>
        <th>Reference Number</th>
        <th>Name</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Activity</th>
        <th>Value</th>
    </tr>
    </thead>
    <tbody>
    @foreach($projects as $project)
        <tr>
            <td>{{ $project->company->name ?? null }}</td>
            <td>{{ $project->contractType->name ?? null }}</td>
            <td>{{ $project->reference_number ?? null }}</td>
            <td>{{ $project->name ?? null }}</td>
            <td>{{ $project->start_date ?? null }}</td>
            <td>{{ $project->end_date ?? null }}</td>
            <td>{{ $project->activity ?? null }}</td>
            <td>{{ $project->value ?? null }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
