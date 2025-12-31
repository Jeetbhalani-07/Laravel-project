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
          
                {{ __('Role List') }}

        </x-slot>

        <div style="margin-top:20px;">


            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg " style="padding:20px 20px;">
                    <h1 style="text-align:center; font-size: 2em;"><i>Role List</i></h1>
  
                    <div style="display:block;margin:15px 20px; padding:5px 5px;">
                        <div style="float:right; padding: 5px 5px;">

                            <i>
                                Add role:
                            </i>
                            <a href="add_role" class="btn btn-primary">Add here</a>

                        </div>

                    </div>

                  <br><br>
                    <table border="1" class="table table-striped table-bordered border-dark">
                        <thead class="table-dark">
                            <tr>
                                <td>Role-Type</td>
                                <td>Permission</td>
                                <td>Edit/Delete</td>
                            </tr>
                        </thead>
                        @foreach ($role as $item)
@php
$permissions = json_decode($item['permission'],true);
$count = 0;
@endphp
                            <tr>
                                <td>{{ $item['role_type'] }}</td>
                                <td>
                                    @foreach ($permissions as $permission)
                                    @if($count == 0)

                                    @else
                                    ,
                                    @endif
                                    {{ $permission }}
                                   @php
                                   $count++;
                                   @endphp
                                    @endforeach
                                </td>

                                <td><a href="role/edit/{{ $item['id'] }}" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></a>
                                    <a href="role/delete/{{ $item['id'] }}" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
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
