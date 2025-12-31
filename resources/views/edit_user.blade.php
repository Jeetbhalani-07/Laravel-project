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
    </style>
</head>
<body>
    <x-app-layout>
    <x-slot name="header">
       
            {{ __('Update User detail') }}
      
    </x-slot>

   <div style="margin-top:20px;">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
     <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg " style="padding:20px 20px;">
            <h1 style="text-align:center; font-size: 2em;"><i>Edit Transactions Details</i></h1>
            @if ($errors->updatePassword->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->updatePassword->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
    <form action="{{ route('user.update', $user) }}" id="myForm" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $user->id }}">
   
         <label for="user_name">user_name:</label>
        <input type="text" name="user_name" id="user_name" class="form-control"  value="{{ $user->name }}"><br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" class="form-control"  value="{{ $user->email }}"><br>

        <label for="current_password">Current password:</label>
        <input type="password" name="current_password" id="current_password" class="form-control"  autocomplete="current-password"><br>

        <label for="password">New password:</label>
        <input type="password" name="password" id="password" class="form-control"><br>
       

        <label for="password_confirmed">Confirm_password:</label>
        <input type="password" name="password_confirmed" id="password_confirmed" class="form-control"><br>

        

        <label for="role_type">Role:</label>
         <select name="role_type" id="role_type"  class="block mt-1 w-full">

                    @foreach ($data as $role)
                    
                    <option value="{{ $role->id }}">{{ $role->role_type }}</option>
                    @endforeach
                </select>
<br>


        <button type="submit" id="submitBtn" class="btn btn-default btn-primary">Submit</button>
    </form>
            </div>
        </div>
    </div>
</x-app-layout>
     <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $('#sidebtn').on('click', function (event) {
            event.preventDefault();
            // $('#sidebar').toggleClass('close open');

            const sidebarstatus = $('#sidebar').hasClass('close');
            console.log(sidebarstatus);
            if (sidebarstatus) {

                // $('#sidebar').removeClass('close');
                // $('#sidebar').addClass('open');
                // $('body').addClass('side');
                $('#icon').removeClass('icon');

                $('#icon').addClass('currency');



            }
            else {
                // $('#sidebar').removeClass('open');
                // $('body').removeClass('side');

                // $('#sidebar').addClass('close');
                $('#icon').removeClass('currency');
                $('#icon').addClass('icon');
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