<style type="text/css" media="all">
    .table__work-experience-export {
        border: solid 1px #F4F3F8;
        border-collapse: collapse;
        border-spacing: 0;
        font: normal 13px Arial, sans-serif;
    }

    .table__work-experience-export thead th {
        background-color: #F4F3F8;
        border: solid 1px #F4F3F8;
        color: #575962;
        padding: 10px;
        text-align: left;
        text-shadow: 1px 1px 1px #fff;
    }

    .table__work-experience-export tbody td {
        border: solid 1px #F4F3F8;
        color: #333;
        padding: 10px;
        text-shadow: 1px 1px 1px #fff;
    }
</style>

<table class="table__work-experience-export">
    <thead>
    <tr>
        <th>Company</th>
        <th>Business Type</th>
        <th>Position</th>
        <th>Start Date</th>
        <th>End Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($workExperiences as $workExperience)
        <tr>
            <td>{{ $workExperience->company }}</td>
            <td>{{ $workExperience->business_type }}</td>
            <td>{{ $workExperience->position }}</td>
            <td>{{ $workExperience->start_date }}</td>
            <td>{{ $workExperience->end_date }}</td>
        </tr>
    @endforeach
    </tbody>
</table>