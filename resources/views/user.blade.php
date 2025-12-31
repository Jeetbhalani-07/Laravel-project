<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .open {
            display: block;
        }

        .close {
            display: none;
        }

        .side {
            margin-left: 380px;
        }
    </style>
</head>

<body>
    <x-app-layout>
        <x-slot name="header">
           
                {{ __('User Details') }}
        
        </x-slot>

        <div style="margin-top:20px;">


            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg " style="padding:20px 20px;">
                    <h1 style="text-align:center; font-size: 2em;"><i>User Details</i></h1>

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div style="display:block;margin:15px 20px; padding:5px 5px;">
                        <div style="float:right; padding: 5px 5px;">

                            <i>
                                Add user:
                            </i>
                            <a href="register" class="btn btn-primary">Add here</a>

                        </div>

                    </div>

                    <br>
                    <table border="1" class="table table-striped table-bordered border-dark">
                        <thead class="table-dark">
                            <tr>
                                <td>User_name</td>
                                <td>Email</td>
                                <td>Role</td>
                                <td>Edit/Delete</td>
                            </tr>
                        </thead>
                        @foreach ($user as $item)

                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->role_type }}</td>

                                <td><a href="user/edit/{{ $item->id }}" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></a>
                                    <a href="user/delete/{{ $item->id }}" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                                </td>

                            </tr>

                        @endforeach

                    </table>
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
    </script>
</body>

</html>