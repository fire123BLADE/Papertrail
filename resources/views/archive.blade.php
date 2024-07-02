<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" type="x-icon" href="Web Logo.png">
    <title>Archive</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        table {
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
            max-width: 100%;
        }

        th, td {
            border: 2px solid black;
            text-align: center;
            padding: 8px;
        }

        th {
            background-color: beige;
            cursor: pointer;
        }

        tr {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #dddddd;
        }

        .status-red {
            color: red;
        }

        .status-yellow {
            color: yellow;
        }

        .status-green {
            color: green;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 25px;
            text-align: center;
            border: 2px solid black;
        }

        .status-green {
            color: green;
            background-color: lightgreen;
        }

        .status-yellow {
            color: yellow;
            background-color: lightyellow;
        }

        .status-red {
            color: red;
            background-color: lightcoral;
        }

        #searchInput {
            margin: 20px auto;
            display: block;
            width: 50%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Archive</h2>
    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for documents..">

    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="archiveTable">
            <thead class="thead-light">
                <tr>
                    <th onclick="sortTable(0)">DocumentID</th>
                    <th onclick="sortTable(1)">Subject</th>
                    <th onclick="sortTable(2)">UserID</th>
                    <th onclick="sortTable(3)">Date</th>
                    <th onclick="sortTable(4)">Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($groupedRecords as $key => $group)
                    @php
                        $status = 'approved';
                        foreach ($group as $document) {
                            if ($document->status === 'disapproved') {
                                $status = 'disapproved';
                                break;
                            } elseif ($document->status === 'pending') {
                                $status = 'pending';
                            }
                        }
                    @endphp

                    @foreach($group as $document)
                    <tr>
                        <td>{{ $document->Document_ID }}</td>
                        <td>{{ $document->Subject }}</td>
                        <td>{{ $document->RecipientEmail }}</td>
                        <td>{{ $document->Date }}</td>
                        <td>
                            <div class="status-badge {{ $status === 'approved' ? 'status-green' : ($status === 'disapproved' ? 'status-red' : 'status-yellow') }}">
                                {{ $status === 'approved' ? 'Completed' : ($status === 'disapproved' ? 'Incomplete' : 'Pending') }}
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('documents.view', ['filename' => $document->FileName]) }}" class="btn btn-success action-button">View</a>
                            
                        </td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
function searchTable() {
    var input, filter, table, tr, td, i, j, txtValue;
    input = document.getElementById('searchInput');
    filter = input.value.toUpperCase();
    table = document.getElementById('archiveTable');
    tr = table.getElementsByTagName('tr');
    
    for (i = 1; i < tr.length; i++) {
        tr[i].style.display = 'none';
        td = tr[i].getElementsByTagName('td');
        for (j = 0; j < td.length; j++) {
            if (td[j]) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = '';
                    break;
                }
            }
        }
    }
}

function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById('archiveTable');
    switching = true;
    dir = 'asc'; 
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName('td')[n];
            y = rows[i + 1].getElementsByTagName('td')[n];
            if (dir == 'asc') {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == 'desc') {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount++;
        } else {
            if (switchcount == 0 && dir == 'asc') {
                dir = 'desc';
                switching = true;
            }
        }
    }
}
</script>

</body>
</html>
