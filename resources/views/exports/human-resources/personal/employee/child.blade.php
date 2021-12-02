<style type="text/css" media="all">
    .table__child-export {
        border: solid 1px #F4F3F8;
        border-collapse: collapse;
        border-spacing: 0;
        font: normal 13px Arial, sans-serif;
    }

    .table__child-export thead th {
        background-color: #F4F3F8;
        border: solid 1px #F4F3F8;
        color: #575962;
        padding: 10px;
        text-align: left;
        text-shadow: 1px 1px 1px #fff;
    }

    .table__child-export tbody td {
        border: solid 1px #F4F3F8;
        color: #333;
        padding: 10px;
        text-shadow: 1px 1px 1px #fff;
    }
</style>

<table class="table__child-export">
    <thead>
    <tr>
        <th>Full Name</th>
        <th>Nick Name</th>
        <th>Gender</th>
        <th>Order</th>
        <th>Birth Place</th>
        <th>Birth Date</th>
        <th>BPJS Kesehatan Number</th>
        <th>BPJS Kesehatan Date</th>
        <th>BPJS Kesehatan Class</th>
    </tr>
    </thead>
    <tbody>
    @foreach($childs as $child)
        <tr>
            <td>{{ $child->full_name }}</td>
            <td>{{ $child->nick_name }}</td>
            <td>{{ $child->gender->name }}</td>
            <td>{{ $child->order }}</td>
            <td>{{ $child->birth_place }}</td>
            <td>{{ $child->birth_date }}</td>
            <td>{{ $child->bpjs_kesehatan_number }}</td>
            <td>{{ $child->bpjs_kesehatan_date }}</td>
            <td>{{ $child->bpjs_kesehatan_class }}</td>
        </tr>
    @endforeach
    </tbody>
</table>