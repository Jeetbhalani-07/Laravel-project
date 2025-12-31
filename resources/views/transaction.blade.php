<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
         .open{
        display: block;
    }
    .close{
        display: none;
    }
    .side{
       margin-left:380px;
    }
    .dataTables_wrapper .dataTables_length select{
        width: 70px;
    }
    </style>
    <!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- jQuery (already included) -->





</head>

<body>
    <x-app-layout>
    <x-slot name="header">
     
            {{ __('Financial Budget') }}
       
    </x-slot>
@php
$permissions = json_decode($role[0]['permission'], true);
@endphp
   <div style="margin-top:20px;">

   
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg " style="padding:20px 20px;">
            <h1 style="text-align:center; font-size: 2em;"><i>Transactions Details</i></h1>
            <?php
$income = 0;
$expense = 0;
$total = 0;
?>
@if (in_array("add_transaction", $permissions))

<div style="display:block;margin:15px 20px; padding:5px 5px;">
        <div style="float:right; padding: 5px 5px;">

        <i>
            Add transaction:
        </i>
            <a href="add" class="btn btn-primary">Add here</a>
        
    </div>

</div>
@endif
      <br>      
            <div class="filter">
                <div class="filter-body">
                    <form action="/update" method="get">
                        <label for="">Start Date:</label>
                        <input type="date" name="start" id="">
                        <label for="">End date:</label>
                        <input type="date" name="end" id="">
                        <button class="btn btn-primary" type="submit">Filter</button>
                    </form>
                </div>
            </div><br><br>
            <table border="1" id="trans-table" class="table table-striped table-bordered border-dark">
            <thead class="table-dark">  
            <tr>
                    <td>Date</td>
                    <td>Party-name</td>
                    <td>Description</td>
                    <td>Category</td>
                    <td>Type</td>
                    <td>Edit/Delete</td>
                    <td>Amount</td>
            
                </tr>
              
                </thead>
               
               
            </table>

       </div>
    </div>
</div>
</x-app-layout>
<script>
    const currentUserId = {{ Auth::id() }};
    const isAdmin = {{ $role[0]['role_type'] === 'admin' ? 'true' : 'false' }};
    const Edit = {{ in_array('edit_transaction', $permissions) == 1 ? 'true' : 'false' }};
    const Delete = {{ in_array('delete_transaction', $permissions) == 1 ? 'true' : 'false' }};
</script>

        <script>
            $(function () {
                $('#trans-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('transactions.display') }}",
                    columns: [
                        { data: 'date', name: 'transactions.date' },
                        { data: 'party_name', name: 'parties.name' },
                        { data: 'description', name: 'transactions.description' },
                        { data: 'category', name: 'transactions.category' },
                        { data: 'type', name: 'transactions.type' },
                  {
    data: 'id',
    name: 'id',
    render: function (data, type, row) {
        if (isAdmin === true || currentUserId == row.user_id) {
            let actions = '';

            if (Edit == true) {
                actions += `<a href="edit/${data}" class="btn btn-sm btn-warning"><i class="fa-solid fa-pencil"></i></a> `;
            }

            if (Delete == true) {
                actions += `<a href="delete/${data}" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></a>`;
            }

            return actions !== '' ? actions : `You don't have access`;
        } else {
            return `You don't have permission`;
        }
    }
},

                        
                        { data: 'amount', name: 'transactions.amount' }
                    ]
                });
            });
        </script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

</body>

</html>