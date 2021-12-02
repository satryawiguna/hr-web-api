<style type="text/css" media="all">
    .table__work-competence-export {
        border: solid 1px #F4F3F8;
        border-collapse: collapse;
        border-spacing: 0;
        font: normal 13px Arial, sans-serif;
    }

    .table__work-competence-export thead th {
        background-color: #F4F3F8;
        border: solid 1px #F4F3F8;
        color: #575962;
        padding: 10px;
        text-align: left;
        text-shadow: 1px 1px 1px #fff;
    }

    .table__work-competence-export tbody td {
        border: solid 1px #F4F3F8;
        color: #333;
        padding: 10px;
        text-shadow: 1px 1px 1px #fff;
    }
</style>

<table class="table__work-competence-export">
    <thead>
    <tr>
        <th>Reference Number</th>
        <th>Competence</th>
        <th>Issue Date</th>
        <th>Validity</th>
    </tr>
    </thead>
    <tbody>
    @foreach($workCompetences as $workCompetence)
        <tr>
            <td>{{ $workCompetence->reference_number }}</td>
            <td>{{ $workCompetence->competence->name }}</td>
            <td>{{ $workCompetence->issue_date }}</td>
            <td>{{ $workCompetence->validity }}</td>
        </tr>
    @endforeach
    </tbody>
</table>