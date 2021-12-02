<style type="text/css" media="all">
    .table_termination-export {
        border: solid 1px #F4F3F8;
        border-collapse: collapse;
        border-spacing: 0;
    }

    .table_termination-export thead th {
        background-color: #F4F3F8;
        border: solid 1px #F4F3F8;
        color: #575962;
        padding: 10px;
        text-align: left;
        text-shadow: 1px 1px 1px #fff;
    }

    .table_termination-export tbody td {
        border: solid 1px #F4F3F8;
        color: #333;
        padding: 10px;
        text-shadow: 1px 1px 1px #fff;
    }
</style>

<table class="table_termination-export">
    <thead>
    <tr>
        <th>Employee Name</th>
        <th>Type</th>
        <th>Termination Date</th>
        <th>Note</th>
        <th>Severance</th>
    </tr>
    </thead>
    <tbody>
    @foreach($terminations as $termination)
        <tr>
            <td>{{ $termination->employee->full_name ?? null }}</td>
            <td>{{ $termination->type ?? null }}</td>
            <td>{{ $termination->termination_date ?? null }}</td>
            <td>{{ $termination->note ?? null }}</td>
            <td>{{ $termination->severance ?? null }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
