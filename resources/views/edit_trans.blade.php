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

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


</head>

<body>
    <x-app-layout>
        <x-slot name="header">
          
                {{ __('Add Financial Details') }}
           
        </x-slot>

        <div style="margin-top:20px;">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg " style="padding:20px 20px;">
                    <h1 style="text-align:center; font-size: 2em;"><i>Edit Transactions Details</i></h1>
                    <form action="/update" id="myForm" method="post" enctype="multipart/form-data" validate>
                        @csrf
                        @foreach ($data as $trans)

                            <input type="hidden" name="id" value="{{ $trans->id }}">
                            <label for="date">
                                Date:
                            </label>
                            <input type="date" name="date" id="date" class="form-control" value="{{ $trans->date }}"><br>
                            <label for="party_name">Party_name:</label>
                            <select name="party_id" id="party_name" class="form-control select2" required>
                                @foreach ($party as $item)

                                    <option value="{{ $item['id'] }}" {{ $item['id'] == $trans->party_id ? 'selected' : '' }}>
                                        {{ $item['name'] }}</option>
                                @endforeach
                            </select>
                            <br>
                            <br>
                            <label for="description">Description:</label>
                            <input type="text" name="description" id="description" class="form-control"
                                placeholder="Enter your description (eg:Groceries)" value="{{ $trans->description }}"><br>

                            <label for="category">Category:</label>
                            <input type="text" name="category" id="category" class="form-control"
                                placeholder="Enter your category (eg:Frozen food,Beverages)"
                                value="{{ $trans->category }}"><br>

                            <label for="type">Type:</label>
                            @if($trans->type === 'income')
                                <select name="type" id="" class="form-control">
                                    <option value="" disabled>select transaction type</option>
                                    <option value="income" selected>Income</option>
                                    <option value="expense">Expense</option>
                                </select>
                            @else
                                <select name="type" id="" class="form-control">
                                    <option value="" disabled>select transaction type</option>
                                    <option value="income">Income</option>
                                    <option value="expense" selected>Expense</option>
                                </select>
                            @endif
                            <br>

                            <label for="amount">Amount:</label>
                            <input type="text" name="amount" id="amount" class="form-control"
                                placeholder="Enter your Amount (eg:5000)" value="{{ $trans->amount }}"><br>
                            <input type="hidden" name="user_id" id="user_id" class="form-control"
                                value="{{ Auth::user()->id }}">

                            <button type="submit" id="submitBtn" class="btn btn-default btn-primary">Submit</button>
                        @endforeach
                    </form>
                </div>
            </div>
        </div>
    </x-app-layout>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>

        $(document).ready(function () {
            $('.select2').select2({
                placeholder: "Select a party",
                allowClear: true
            });
        });

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


        document.getElementById("myForm").addEventListener("submit", function (event) {


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