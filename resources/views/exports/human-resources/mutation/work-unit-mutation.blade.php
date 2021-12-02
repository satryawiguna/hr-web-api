<style type="text/css" media="all">
    .table__work-unit-mutation-export {
        border: solid 1px #F4F3F8;
        border-collapse: collapse;
        border-spacing: 0;
        font: normal 13px Arial, sans-serif;
    }

    .table__work-unit-mutation-export thead th {
        background-color: #F4F3F8;
        border: solid 1px #F4F3F8;
        color: #575962;
        padding: 10px;
        text-align: left;
        text-shadow: 1px 1px 1px #fff;
    }

    .table__work-unit-mutation-export tbody td {
        border: solid 1px #F4F3F8;
        color: #333;
        padding: 10px;
        text-shadow: 1px 1px 1px #fff;
    }
</style>

<table class="table__work-unit-mutation-export">
    <thead>
    <tr>
        <th>Employee</th>
        <th>Work Unit</th>
        <th>Mutation Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($workUnitMutations as $workUnitMutation)
        <tr>
            <td>{{ $workUnitMutation->employee->full_name }}</td>
            <td>{{ $workUnitMutation->workUnit->title }}</td>
            <td>{{ $workUnitMutation->mutation_date }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
