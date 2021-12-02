<style type="text/css" media="all">
    .table__position-mutation-export {
        border: solid 1px #F4F3F8;
        border-collapse: collapse;
        border-spacing: 0;
        font: normal 13px Arial, sans-serif;
    }

    .table__position-mutation-export thead th {
        background-color: #F4F3F8;
        border: solid 1px #F4F3F8;
        color: #575962;
        padding: 10px;
        text-align: left;
        text-shadow: 1px 1px 1px #fff;
    }

    .table__position-mutation-export tbody td {
        border: solid 1px #F4F3F8;
        color: #333;
        padding: 10px;
        text-shadow: 1px 1px 1px #fff;
    }
</style>

<table class="table__position-mutation-export">
    <thead>
    <tr>
        <th>Employee</th>
        <th>Position</th>
        <th>Mutation Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($positionMutations as $positionMutation)
        <tr>
            <td>{{ $positionMutation->employee->full_name }}</td>
            <td>{{ $positionMutation->position->name }}</td>
            <td>{{ $positionMutation->mutation_date }}</td>
        </tr>
    @endforeach
    </tbody>
</table>