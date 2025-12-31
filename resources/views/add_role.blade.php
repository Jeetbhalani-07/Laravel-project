<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .hidden{
            display: none;
        }
    </style>
</head>
<body>
   <x-app-layout>
    <x-slot name="header">
        
            {{ __('Add Role') }}
        
    </x-slot>

   <div style="margin-top:20px;">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
     <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg " style="padding:20px 20px;">
            <h1 style="text-align:center; font-size: 2em;"><i>Add Role</i></h1>
    <form action="/add_role" id="myForm" method="post" enctype="multipart/form-data">
        @csrf
   
        <label for="role">Role:</label>
        <input type="text" name="role" id="role" class="form-control" placeholder="Enter your role (eg:Admin,user,CA)"><br>

        <label for="permission">permission:</label>
       <input type="checkbox" name="permission[]" id="permission" value="dashboard">Dashboard
       <input type="checkbox" name="permission[]" id="transactionList" value="Transaction_list">Transaction list
       <input type="checkbox" name="permission[]" id="permission" value="user">User
    <input type="checkbox" name="permission[]" id="permission" value="role">Role

       <br>
       <div id="addTransactionContainer" class="hidden">
            <input type="checkbox" name="permission[]" id="permission" value="add_transaction">Add transaction
            <input type="checkbox" name="permission[]" id="permission" value="edit_transaction">Edit transaction
            <input type="checkbox" name="permission[]" id="permission" value="delete_transaction">Delete transaction

       </div>
   


      
        <br>

  

        <button type="submit" id="submitBtn" class="btn btn-default btn-primary">Submit</button>
    </form>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    const transactionListCheckbox = document.getElementById('transactionList');
    const addTransactionContainer = document.getElementById('addTransactionContainer');

    transactionListCheckbox.addEventListener('change', function () {
        if (this.checked) {
            addTransactionContainer.classList.remove('hidden');
        } else {
            addTransactionContainer.classList.add('hidden');
            // Optionally uncheck the "Add transaction" checkbox when hiding
            addTransactionContainer.querySelector('input[type="checkbox"]').checked = false;
        }
    });
    

  document.getElementById("myForm").addEventListener("submit", function(event) {

    const submitBtn = document.getElementById("submitBtn");
    submitBtn.disabled = true; // Disable the button to prevent double clicks

    // Example: simulate async operation (like sending data via fetch)
    setTimeout(() => {
      console.log("Form submitted successfully!");

      // Re-enable if needed after processing (optional)
      // submitBtn.disabled = false;
    }, 2000);
  });

</script>
</body>
</html>