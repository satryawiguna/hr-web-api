<style type="text/css" media="all">
    .table__registration-letter-export {
        border: solid 1px #F4F3F8;
        border-collapse: collapse;
        border-spacing: 0;
        font: normal 13px Arial, sans-serif;
    }

    .table__registration-letter-export thead th {
        background-color: #F4F3F8;
        border: solid 1px #F4F3F8;
        color: #575962;
        padding: 10px;
        text-align: left;
        text-shadow: 1px 1px 1px #fff;
    }

    .table__registration-letter-export tbody td {
        border: solid 1px #F4F3F8;
        color: #333;
        padding: 10px;
        text-shadow: 1px 1px 1px #fff;
    }
</style>

<table class="table__registration-letter-export">
    <thead>
    <tr>
        <th>Employee</th>
        <th>Project</th>
        <th>Mutation Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($registrationLetters as $registrationLetter)
        <tr>
            <td>{{ $registrationLetter->employee->full_name }}</td>
            <td>{{ $registrationLetter->project->name }}</td>
            <td>{{ $registrationLetter->mutation_date }}</td>
        </tr>
    @endforeach
    </tbody>
</table>