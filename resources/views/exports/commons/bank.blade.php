<style type="text/css" media="all">
    .table__bank-export {
        border: solid 1px #F4F3F8;
        border-collapse: collapse;
        border-spacing: 0;
        font: normal 13px Arial, sans-serif;
    }

    .table__bank-export thead th {
        background-color: #F4F3F8;
        border: solid 1px #F4F3F8;
        color: #575962;
        padding: 10px;
        text-align: left;
        text-shadow: 1px 1px 1px #fff;
    }

    .table__bank-export tbody td {
        border: solid 1px #F4F3F8;
        color: #333;
        padding: 10px;
        text-shadow: 1px 1px 1px #fff;
    }
</style>

<table class="table__bank-export">
    <thead>
    <tr>
        <th>Name</th>
        <th>Description</th>
    </tr>
    </thead>
    <tbody>
    @foreach($banks as $bank)
        <tr>
            <td>{{ $bank->name }}</td>
            <td>{{ $bank->description }}</td>
        </tr>
    @endforeach
    </tbody>
</table>