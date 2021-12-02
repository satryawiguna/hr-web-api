<style type="text/css" media="all">
    .table__degree-export {
        border: solid 1px #F4F3F8;
        border-collapse: collapse;
        border-spacing: 0;
        font: normal 13px Arial, sans-serif;
    }

    .table__degree-export thead th {
        background-color: #F4F3F8;
        border: solid 1px #F4F3F8;
        color: #575962;
        padding: 10px;
        text-align: left;
        text-shadow: 1px 1px 1px #fff;
    }

    .table__degree-export tbody td {
        border: solid 1px #F4F3F8;
        color: #333;
        padding: 10px;
        text-shadow: 1px 1px 1px #fff;
    }
</style>

<table class="table__degree-export">
    <thead>
    <tr>
        <th>Name</th>
        <th>Description</th>
    </tr>
    </thead>
    <tbody>
    @foreach($degrees as $degree)
        <tr>
            <td>{{ $degree->name }}</td>
            <td>{{ $degree->description }}</td>
        </tr>
    @endforeach
    </tbody>
</table>