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
       
            {{ __('Edit Role') }}
     
    </x-slot>

   <div style="margin-top:20px;">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
     <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg " style="padding:20px 20px;">
            <h1 style="text-align:center; font-size: 2em;"><i>Add Role</i></h1>
    <form action="/role/update" id="myForm" method="post" enctype="multipart/form-data">
        @csrf
   <input type="hidden" name="id" id="id" value="{{ $role['id'] }}">
        <label for="role">Role:</label>
        <input type="text" name="role" id="role" class="form-control" value="{{ $role['role_type'] }}"><br>
@php
$permissions = json_decode($role['permission'], true);
@endphp
        <label for="permission">permission:</label>
       <input type="checkbox" name="permission[]" id="permission" value="dashboard" {{ in_array("dashboard", $permissions) ? 'checked' : ''  }}>Dashboard
       <input type="checkbox" name="permission[]" id="transactionList" value="Transaction_list" {{ in_array("Transaction_list", $permissions) ? 'checked' : ''  }}>Transaction list
       <input type="checkbox" name="permission[]" id="permission" value="user" {{ in_array("user", $permissions) ? 'checked' : ''  }}>User
    <input type="checkbox" name="permission[]" id="permission" value="role" {{ in_array("role", $permissions) ? 'checked' : ''  }}>Role
       <br>
       <div id="addTransactionContainer" class="{{ in_array("Transaction_list", $permissions) ? '' : 'hidden'  }}">
            <input type="checkbox" name="permission[]" id="permission" value="add_transaction" {{ in_array("add_transaction", $permissions) ? 'checked' : ''  }}>Add transaction
            <input type="checkbox" name="permission[]" id="permission" value="edit_transaction" {{ in_array("edit_transaction", $permissions) ? 'checked' : ''  }}>Edit transaction
            <input type="checkbox" name="permission[]" id="permission" value="delete_transaction" {{ in_array("delete_transaction", $permissions) ? 'checked' : ''  }}>Delete transaction

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
            addTransactionContainer.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
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