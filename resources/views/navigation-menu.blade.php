<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Include this in the <head> of your HTML -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .close{
            display: none;
        }
        .active {
            text-decoration: none;
            color: white;
            display: flex;
            background-color: black;
            border-radius: 5px;
            padding: 7px;
        }
        .active:hover{
            background-color: white;
            color: black;
        }
           .active:hover .my-icon{
           
            color: black;
        }
           .dashboard {
        border-radius: 5px;
        padding: 7px;
        margin: 20px 10px;
       position: relative;
    }
     .dashboard a {
        text-decoration: none;
      display:block;
        padding: 8px;
        border-radius: 4px;
    } 
    .drop-menu {
        display: none;
        list-style: none;
       
        margin-top: 5px;
        border-radius: 4px;
    }

     .drop-menu li a {
        padding: 8px 12px;
        display: block;
   
    } 

    .dashboard.open .drop-menu {
         background-color: black;
       color: white;
        display: block;
    }
           .transaction {
       background-color: black;
       color: white;
        position: relative; 
     }

     .transaction a {
        text-decoration: none;
        display: block;
        padding: 8px;
     
        border-radius: 4px;
    }

        .transaction.open .transaction-menu {
             background-color: black;
       color: white;
        display: block;
    }
     .transaction-menu {
        display: none;
        list-style: none;
      
        margin-top: 5px;
      
        border-radius: 4px;
    } 
     .user a {
        text-decoration: none;
        display: block;
        padding: 8px;
      
        border-radius: 4px;
    }
     .user_menu {
        display: none;
        list-style: none;
        
        margin-top: 5px;
      
        border-radius: 4px;
    }
    .user_menu li a {
        padding: 8px 12px;
        display: block;
        color: #333;
    }
     .user {
        border-radius: 5px;
        padding: 7px;
        margin: 20px 10px;
        position: relative;
    }
    .dashboard.open .user_menu{
        display: block;
       
    }
     .role {
        border-radius: 5px;
        padding: 7px;
        margin: 20px 10px;
       position: relative;
    }
     .role a {
        text-decoration: none;
      display:block;
        padding: 8px;
        background-color: black;
        border-radius: 4px;
    } 
    .role.open .drop-menu { 
         background-color: black;
       color: white;
        display: block;
    }
    .my-icon{
        padding-right: 10px;
        color: #d6dfe5;
    }
   .right{
    padding-top: 5px;
    float: right;
   }
   /* .breadcrumb {
    float: right;
    background: transparent;
    margin-top: 0;
    margin-bottom: 0;
    font-size: 12px;
    padding: 7px 5px;
    position: absolute;
    top: 15px;
    right: 10px;
    border-radius: 2px;
} */

   /* .sidebar {
  width: 250px;
  height: 100vh; 
  overflow-y: auto; 
  background-color: #f4f4f4;
  padding: 10px;
  border-right: 1px solid #ccc;
} */
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
    
    <!-- Primary Navigation Menu -->
 @php 
     $id = Auth::id();
$role = DB::table('users')->join('role', 'users.role_id', '=', 'role.id')->where('users.id', $id)->select('role.id', 'role.permission', 'role.role_type')->get();
$decoded = json_decode($role[0]->permission);
// print_r($decoded);
// var_dump(in_array("add_user", $decoded));
        @endphp

     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="">
        <div class="flex justify-between h-16">
            <div id="sidebar" class="sidebar close"
                style="background-color:black; color: white; position: fixed; width: 30%; height: 100%; left: 0px; overflow-y: auto;">
                <div class="body-sidebar" style="z-index:99; padding-top:10px; padding: 15px;">
                    <div class="side-header" style="font-size: 2em; background-color: #1b1919ff; border-radius: 7px;">Main navigation</div>
                    <!-- <div class="side-header" style="font-size: 2em; padding: 15px;">{{ Auth::user()->name }}</div> -->

                    <div class="dashboard" style="border-radius: 5px; padding: 7px; margin: 20px 10px;"><a href="{{ route('profile.show') }}"
                            :active="request()->routeIs('profile')" class="active"><i class="fa-solid fa-user my-icon"></i>{{ __('Profile') }}</a>
                    </div>
                @if(in_array("dashboard", $decoded))
                    <div class="dashboard" style="border-radius: 5px; padding: 7px; margin: 20px 10px;"><a
                            href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')"
                           class="active"><i class="fa-solid fa-house my-icon" ></i>Dashboard</a>
                    </div>
                    @endif

             @if(in_array("Transaction_list", $decoded) || in_array("add_transaction", $decoded))
             <div class="dashboard" id="transactionDropdown">
                <a href="#1" onclick="toggletransaction()" class="active"> <i class="fa-solid fa-chart-simple my-icon"></i>Transaction<i class="fa-solid fa-angle-down right"></i></a>
                <ul class="drop-menu" id="transaction_menu">

                    @if(in_array("Transaction_list", $decoded))
                        <!-- <div class="dashboard" style="border-radius: 5px; padding: 7px; margin: 20px 10px;"><a
                                href="{{ route('list') }}" :active="request()->routeIs('list')" class="active">Transaction
                                list</a></div> -->
                              <li><a href="{{ route('transactions.display') }}" class="active"><i class="fa-solid fa-money-check-dollar my-icon"></i>Transaction list</a></li>

                     @endif
                           @if(in_array("add_transaction", $decoded))
                                <div class="transaction" id="addtransactionDropdown">
                                    <a href="#" onclick="toggleDropdown()" class="active"><i class="fa-solid fa-credit-card my-icon"></i>Add Transaction<i class="fa-solid fa-angle-down right"></i></a>
                                    <ul class="transaction-menu" id="add_transaction">
                                        <li><a href="{{ route('income') }}" class="active"><i class="fa-solid fa-money-bill-transfer my-icon"></i>Add Income</a></li>
                                        <li><a href="{{ route('expense') }}" class="active"><i class="fa-solid fa-money-bill-transfer my-icon"></i>Add Expense</a></li>
                                        <!-- Add more items here -->
                                    </ul>
                                </div>
                    @endif
                    </ul>
                    </div>
    
                        @endif
                          
                    @if(in_array("user", $decoded) || in_array("add_user", $decoded))
                            <div class="dashboard" id="usersDropdown">
                                <a href="#3" onclick="toggleuser()" class="active"><i class="fa-solid fa-users my-icon"></i>User<i class="fa-solid fa-angle-down right"></i></a>
                                <ul class="drop-menu" id="user_menu">

                                    @if(in_array("user", $decoded))
                                                <!-- <div class="dashboard" style="border-radius: 5px; padding: 7px; margin:20px 10px;"><a
                                                href="{{ route('register') }}" :active="request()->routeIs('register')"
                                                class="active">Add
                                                user</a></div> -->
                                        <li><a href="{{ route('user') }}" class="active"><i class="fa-solid fa-address-book my-icon"></i>User List</a></li>

                                        <li><a href="{{ route('register') }}" class="active"><i class="fa-solid fa-user-plus my-icon"></i>Add user</a></li>

                                                @endif
                                </ul>
                            </div>
                    @endif

                    @if(in_array("role", $decoded))
                    <div class="role" id="roleDropdown">
                        <a href="#4" onclick="togglerole()" class="active"><i class="fa-solid fa-user-shield my-icon"></i>
                            Role<i class="fa-solid fa-angle-down right"></i></a>
                        <ul class="drop-menu" id="role-menu">
                            <li><a href="{{ route('role') }}" class="active"><i class="fa-solid fa-user-shield my-icon"></i>Role List</a></li>
                            <li><a href="{{ route('add_role') }}" class="active"><i class="fa-solid fa-user-secret my-icon"></i>Add role</a></li>
                        </ul>
                    </div>
                    @endif

 <div class="role" id="partyDropdown">
                        <a href="#5" onclick="toggleparty()" class="active"><i class="fa-solid fa-user-shield my-icon"></i>
                            party<i class="fa-solid fa-angle-down right"></i></a>
                        <ul class="drop-menu" id="role-menu">
                            <li><a href="{{ route('party') }}" class="active"><i class="fa-solid fa-user-shield my-icon"></i>Party List</a></li>
                            <li><a href="{{ route('add_party') }}" class="active"><i class="fa-solid fa-user-secret my-icon"></i>Add party</a></li>
                        </ul>
                    </div>

                    <div class="dashboard" style="border-radius: 5px; padding: 7px; margin:20px 10px;">
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                
                                    <a href="{{ route('logout') }}" @click.prevent="$root.submit();" class="active">
                                      <i class="fa-solid fa-arrow-right-from-bracket my-icon"></i>  {{ __('Log Out') }}
                                    </a>
                                </form>
                        </div>
                </div>
            </div>
            <div class="flex">
                <div class="side-btn shrink-0 flex items-center" style="margin-right: 25px;">
                    <!-- <button type="button" onclick="window.history.back()">Back</button> -->
                     <!-- <button type="button"><a href="{{request()->is('dashboard') ? route('dashboard') : url()->previous() }}" class="btn btn-dark" style="margin:5px 5px;"><i class="fa-solid fa-arrow-left"></i></a></button>-->
                    <button id="sidebtn" type="button"
                        class="p-2 bg-black rounded-md hover:bg-gray-800 transition duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div> 

               
            </div>


            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <!-- <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div> -->

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 me-3">
                        <img class="size-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                            alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}"
                        :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"
                        :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-responsive-nav-link>
                    @endcan

                    <!-- Team Switcher -->
                    @if (Auth::user()->allTeams()->count() > 1)
                        <div class="border-t border-gray-200"></div>

                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Switch Teams') }}
                        </div>

                        @foreach (Auth::user()->allTeams() as $team)
                            <x-switchable-team :team="$team" component="responsive-nav-link" />
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
    </div>
</nav>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
    function toggletransaction() {
        document.getElementById("transactionDropdown").classList.toggle("open");
    }
      function toggleDropdown() {
        document.getElementById("addtransactionDropdown").classList.toggle("open");
    }
     function toggleuser() {
        document.getElementById("usersDropdown").classList.toggle("open");
    }
     function togglerole() {
        document.getElementById("roleDropdown").classList.toggle("open");
    }
     function toggleparty() {
        document.getElementById("partyDropdown").classList.toggle("open");
    }
</script>

   