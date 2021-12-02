<style type="text/css" media="all">
    .table_project_terms-export {
        border: solid 1px #F4F3F8;
        border-collapse: collapse;
        border-spacing: 0;
    }

    .table_project_terms-export thead th {
        background-color: #F4F3F8;
        border: solid 1px #F4F3F8;
        color: #575962;
        padding: 10px;
        text-align: left;
        text-shadow: 1px 1px 1px #fff;
    }

    .table_project_terms-export tbody td {
        border: solid 1px #F4F3F8;
        color: #333;
        padding: 10px;
        text-shadow: 1px 1px 1px #fff;
    }
</style>

<table class="table_project_terms-export">
    <thead>
    <tr>
        <th>Project</th>
        <th>Step</th>
        <th>Name</th>
        <th>Value</th>
        <th>Description</th>
    </tr>
    </thead>
    <tbody>
    @foreach($projectTerms as $projectTerm)
        <tr>
            <td>{{ $projectTerm->project->name ?? null }}</td>
            <td>{{ $projectTerm->step ?? null }}</td>
            <td>{{ $projectTerm->name ?? null }}</td>
            <td>{{ $projectTerm->value ?? null }}</td>
            <td>{{ $projectTerm->description ?? null }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
