<style type="text/css" media="all">
    .table__non-formal-education-history-export {
        border: solid 1px #F4F3F8;
        border-collapse: collapse;
        border-spacing: 0;
        font: normal 13px Arial, sans-serif;
    }

    .table__non-formal-education-history-export thead th {
        background-color: #F4F3F8;
        border: solid 1px #F4F3F8;
        color: #575962;
        padding: 10px;
        text-align: left;
        text-shadow: 1px 1px 1px #fff;
    }

    .table__non-formal-education-history-export tbody td {
        border: solid 1px #F4F3F8;
        color: #333;
        padding: 10px;
        text-shadow: 1px 1px 1px #fff;
    }
</style>

<table class="table__non-formal-education-history-export">
    <thead>
    <tr>
        <th>Type</th>
        <th>Name</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Institution</th>
    </tr>
    </thead>
    <tbody>
    @foreach($nonFormalEducationHistories as $nonFormalEducationHistory)
        <tr>
            <td>{{ $nonFormalEducationHistory->type }}</td>
            <td>{{ $nonFormalEducationHistory->name }}</td>
            <td>{{ $nonFormalEducationHistory->start_date }}</td>
            <td>{{ $nonFormalEducationHistory->end_date }}</td>
            <td>{{ $nonFormalEducationHistory->institution }}</td>
        </tr>
    @endforeach
    </tbody>
</table>