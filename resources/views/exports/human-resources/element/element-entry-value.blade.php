<style type="text/css" media="all">
    .table__element-entry-value-export {
        border: solid 1px #F4F3F8;
        border-collapse: collapse;
        border-spacing: 0;
        font: normal 13px Arial, sans-serif;
    }

    .table__element-entry-value-export thead th {
        background-color: #F4F3F8;
        border: solid 1px #F4F3F8;
        color: #575962;
        padding: 10px;
        text-align: left;
        text-shadow: 1px 1px 1px #fff;
    }

    .table__element-entry-value-export tbody td {
        border: solid 1px #F4F3F8;
        color: #333;
        padding: 10px;
        text-shadow: 1px 1px 1px #fff;
    }
</style>

<table class="table__element-entry-value-export">
    <thead>
    <tr>
        <th>Code</th>
        <th>Element</th>
        <th>Employee</th>
        <th>Effective Start Date</th>
        <th>Effective End Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($elementEntryValues as $elementEntryValue)
        <tr>
            <td>{{ $elementEntryValue->element->code }}</td>
            <td>{{ $elementEntryValue->element->name }}</td>
            <td>{{ $elementEntryValue->employee->full_name }}</td>
            <td>{{ $elementEntryValue->effective_start_date }}</td>
            <td>{{ $elementEntryValue->effective_end_date }}</td>
        </tr>
    @endforeach
    </tbody>
</table>