<style type="text/css" media="all">
    .table__organization-history-export {
        border: solid 1px #F4F3F8;
        border-collapse: collapse;
        border-spacing: 0;
        font: normal 13px Arial, sans-serif;
    }

    .table__organization-history-export thead th {
        background-color: #F4F3F8;
        border: solid 1px #F4F3F8;
        color: #575962;
        padding: 10px;
        text-align: left;
        text-shadow: 1px 1px 1px #fff;
    }

    .table__organization-history-export tbody td {
        border: solid 1px #F4F3F8;
        color: #333;
        padding: 10px;
        text-shadow: 1px 1px 1px #fff;
    }
</style>

<table class="table__organization-history-export">
    <thead>
    <tr>
        <th>Name</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Activity</th>
    </tr>
    </thead>
    <tbody>
    @foreach($organizationHistories as $organizationHistory)
        <tr>
            <td>{{ $organizationHistory->name }}</td>
            <td>{{ $organizationHistory->start_date }}</td>
            <td>{{ $organizationHistory->end_date }}</td>
            <td>{{ $organizationHistory->activity }}</td>
        </tr>
    @endforeach
    </tbody>
</table>