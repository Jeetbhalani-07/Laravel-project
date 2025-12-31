    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
       

<style>
   
    .icon{
        transition: all .3s linear;
    position: absolute;
    bottom: 0px;
    right: 39%;
    z-index: 0;
    font-size: 90px;
    }
     .currency{
        transition: all .3s linear;
    position: absolute;
    bottom: -8%;
    right: 28%;
    z-index: 0;
    font-size: 90px;
    }
   
</style>


<x-app-layout :role="$role">
    <x-slot name="header">
       
            {{ __('Dashboard') }}
  
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <?php

$count = 0;
$income = 0;
$expense = 0;
$total = 0;

foreach ($data as $item) {
    if($item['type'] == 'income'){
        $income += $item['amount'];
    }
    elseif($item['type'] == 'expense'){
        $expense += $item['amount'];
    }
    else{}

    $count++;
}
$total += $income - $expense;
$decoded = json_decode($role[0]->permission); 
$valid = in_array("Transaction_list", $decoded) == 1 ? 'true' : 'false';
// print_r($valid);
// var_dump(in_array("add_user", $decoded));

                ?>
                <x-welcome />
                 <div class="row d-flex justify-content-center" style="border-radius:0px; margin:20px 10px; margin-top:0px;">

        <div class="box-body col-lg-3 col-xs-6" style="">
            <div class="small-box bg-info " >
                <div class="inner" style="padding:10px;">
<h3>{{ $count}}</h3>
<p>Transactions</p>
<p>{{ $total }}</p>
                </div>
                <div class="icon" id="icon">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <i class="bi bi-currency-exchange"></i>

</div>
                <a href="{{ $valid == 'true' ? route('transactions.display') : route('dashboard') }}" class="small-box-footer" style="position: relative;
    text-align: center;
    padding: 3px 0;
    color: #fff;
    color: rgba(255, 255, 255, 0.8);
    display: block;
    z-index: 10;
    background: rgba(0, 0, 0, 0.1);
    text-decoration: none;">More info</a>
        </div>
    </div>
            </div>
          
        </div>
    </div>
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
</x-app-layout>
