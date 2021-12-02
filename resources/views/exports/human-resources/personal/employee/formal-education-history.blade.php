<style type="text/css" media="all">
    .table__formal-education-history-export {
        border: solid 1px #F4F3F8;
        border-collapse: collapse;
        border-spacing: 0;
        font: normal 13px Arial, sans-serif;
    }

    .table__formal-education-history-export thead th {
        background-color: #F4F3F8;
        border: solid 1px #F4F3F8;
        color: #575962;
        padding: 10px;
        text-align: left;
        text-shadow: 1px 1px 1px #fff;
    }

    .table__formal-education-history-export tbody td {
        border: solid 1px #F4F3F8;
        color: #333;
        padding: 10px;
        text-shadow: 1px 1px 1px #fff;
    }
</style>

<table class="table__formal-education-history-export">
    <thead>
    <tr>
        <th>Name</th>
        <th>Degree</th>
        <th>Major</th>
        <th>Start Date</th>
        <th>End Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($formalEducationHistories as $formalEducationHistory)
        <tr>
            <td>{{ $formalEducationHistory->name }}</td>
            <td>{{ $formalEducationHistory->degree->name }}</td>
            <td>{{ $formalEducationHistory->major->name }}</td>
            <td>{{ $formalEducationHistory->start_date }}</td>
            <td>{{ $formalEducationHistory->end_date }}</td>
        </tr>
    @endforeach
    </tbody>
</table>