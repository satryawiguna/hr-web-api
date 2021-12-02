<style type="text/css" media="all">
    .table__project-mutation-export {
        border: solid 1px #F4F3F8;
        border-collapse: collapse;
        border-spacing: 0;
        font: normal 13px Arial, sans-serif;
    }

    .table__project-mutation-export thead th {
        background-color: #F4F3F8;
        border: solid 1px #F4F3F8;
        color: #575962;
        padding: 10px;
        text-align: left;
        text-shadow: 1px 1px 1px #fff;
    }

    .table__project-mutation-export tbody td {
        border: solid 1px #F4F3F8;
        color: #333;
        padding: 10px;
        text-shadow: 1px 1px 1px #fff;
    }
</style>

<table class="table__project-mutation-export">
    <thead>
    <tr>
        <th>Employee</th>
        <th>Project</th>
        <th>Mutation Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($projectMutations as $projectMutation)
        <tr>
            <td>{{ $projectMutation->employee->full_name }}</td>
            <td>{{ $projectMutation->project->name }}</td>
            <td>{{ $projectMutation->mutation_date }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
