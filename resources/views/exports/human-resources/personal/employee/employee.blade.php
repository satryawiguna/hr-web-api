<style type="text/css" media="all">
    .table__employee-export {
        border: solid 1px #F4F3F8;
        border-collapse: collapse;
        border-spacing: 0;
        font: normal 13px Arial, sans-serif;
    }

    .table__employee-export thead th {
        background-color: #F4F3F8;
        border: solid 1px #F4F3F8;
        color: #575962;
        padding: 10px;
        text-align: left;
        text-shadow: 1px 1px 1px #fff;
    }

    .table__employee-export tbody td {
        border: solid 1px #F4F3F8;
        color: #333;
        padding: 10px;
        text-shadow: 1px 1px 1px #fff;
    }
</style>

<table class="table__employee-export">
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
    @foreach($employees as $employee)
        <tr>
            <td>{{ $employee->full_name }}</td>
            <td>{{ $employee->nick_name }}</td>
            <td>{{ $employee->gender->name }}</td>
            <td>{{ $employee->order }}</td>
            <td>{{ $employee->birth_place }}</td>
            <td>{{ $employee->birth_date }}</td>
            <td>{{ $employee->bpjs_kesehatan_number }}</td>
            <td>{{ $employee->bpjs_kesehatan_date }}</td>
            <td>{{ $employee->bpjs_kesehatan_class }}</td>
        </tr>
    @endforeach
    </tbody>
</table>