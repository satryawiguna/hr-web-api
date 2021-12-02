<style type="text/css" media="all">
    .table__work-area-export {
        border: solid 1px #F4F3F8;
        border-collapse: collapse;
        border-spacing: 0;
        font: normal 13px Arial, sans-serif;
    }

    .table__work-area-export thead th {
        background-color: #F4F3F8;
        border: solid 1px #F4F3F8;
        color: #575962;
        padding: 10px;
        text-align: left;
        text-shadow: 1px 1px 1px #fff;
    }

    .table__work-area-export tbody td {
        border: solid 1px #F4F3F8;
        color: #333;
        padding: 10px;
        text-shadow: 1px 1px 1px #fff;
    }
</style>

<table class="table__work-area-export">
    <thead>
    <tr>
        <th>Code</th>
        <th>Title</th>
    </tr>
    </thead>
    <tbody>
    @foreach($workAreas as $workArea)
        <tr>
            <td>{{ $workArea->code }}</td>
            <td>{{ $workArea->title }}</td>
        </tr>
    @endforeach
    </tbody>
</table>