<style type="text/css" media="all">
    .table__letter-type-export {
        border: solid 1px #F4F3F8;
        border-collapse: collapse;
        border-spacing: 0;
        font: normal 13px Arial, sans-serif;
    }

    .table__letter-type-export thead th {
        background-color: #F4F3F8;
        border: solid 1px #F4F3F8;
        color: #575962;
        padding: 10px;
        text-align: left;
        text-shadow: 1px 1px 1px #fff;
    }

    .table__letter-type-export tbody td {
        border: solid 1px #F4F3F8;
        color: #333;
        padding: 10px;
        text-shadow: 1px 1px 1px #fff;
    }
</style>

<table class="table__letter-type-export">
    <thead>
    <tr>
        <th>Name</th>
        <th>Description</th>
    </tr>
    </thead>
    <tbody>
    @foreach($letterTypes as $letterType)
        <tr>
            <td>{{ $letterType->name }}</td>
            <td>{{ $letterType->description }}</td>
        </tr>
    @endforeach
    </tbody>
</table>