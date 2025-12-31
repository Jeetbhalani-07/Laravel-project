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
     
            {{ __('Add party') }}
       
    </x-slot>

   <div style="margin-top:20px;">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
     <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg " style="padding:20px 20px;">
            <h1 style="text-align:center; font-size: 2em;"><i>Add party</i></h1>
    <form action="/add_party" id="myForm" method="post" enctype="multipart/form-data">
        @csrf
   
        <label for="party">Party:</label>
        <input type="text" name="name" id="party" class="form-control" placeholder="Enter your party_name "><br>
<br>
        <button type="submit" id="submitBtn" class="btn btn-default btn-primary">Submit</button>
    </form>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
  
    

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