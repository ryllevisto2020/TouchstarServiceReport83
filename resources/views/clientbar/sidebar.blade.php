<aside class="sidebar" id="sidebar">
    
    <!-- Header -->
    <div class="flex flex-col items-center justify-center py-6 border-b border-white/10">
        <img src="{{asset('images/logo.png')}}" 
             alt="TouchStar PMS" 
             class="w-24 h-24 rounded-full">

        <div class="mt-3 text-center">
            <h1 class="text-white font-semibold text-base leading-tight">
                Touchstar Medical
            </h1>
            <p class="text-blue-200 text-xs">
                Enterprise Inc.
            </p>
        </div>
    </div>

    <!-- Navigation Menu -->
    <div class="px-4 py-6">
        <ul class="space-y-2">
             <li>
                <a href="/client/dashboard" class="nav-button">
                    <div class="flex items-center">
                        <i class="fa-solid fa-cogs w-5 text-center"></i>
                        <span class="ml-3">Dashboard</span>
                    </div>
                </a>
            </li>

            <!-- Machines -->
            <li class="nav-item">
                <button class="nav-button" onclick="toggleDropdown('machines-dropdown', 'machines-chevron')">
                    <div class="flex items-center">
                        <i class="fa-solid fa-cogs w-5 text-center"></i>
                        <span class="ml-3">Machines</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-xs chevron" id="machines-chevron"></i>
                </button>
                <div class="dropdown-content" id="machines-dropdown">
                    <a href="{{route('clients.machines')}}" class="dropdown-link">
                        <i class="fa-solid fa-plus w-4 mr-2"></i>
                        Installed Machines
                    </a>
                </div>
            </li>
            <!-- Service Management -->
            <li class="nav-item">
                <button class="nav-button" onclick="toggleDropdown('pms-dropdown', 'pms-chevron')">
                    <div class="flex items-center">
                        <i class="fa-solid fa-screwdriver-wrench w-5 text-center"></i>
                        <span class="ml-3">Service Management</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-xs chevron" id="pms-chevron"></i>
                </button>
                <div class="dropdown-content" id="pms-dropdown">
                    <a href="{{route('client.service.history')}}" class="dropdown-link">
                        <i class="fa-solid fa-book-medical w-4 mr-2"></i>
                        Service Report History
                    </a>
                </div>
            </li>  
             <li>
                <a href="" class="nav-button">
                    <div class="flex items-center">
                        <i class="fa-solid fa-cogs w-5 text-center"></i>
                        <span class="ml-3">Ticketing System (Underdevelopment)</span>
                    </div>
                </a>
            </li>
        </ul>
    </div>

    <!-- Client Profile Section -->
   <div class="user-profile">
        <div class="flex items-center">
           <div class="h-10 w-10 rounded-full overflow-hidden shadow-lg">
                @auth
                    @if(auth()->user()->profile_picture)
                        <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}"
                            alt="Profile Picture"
                            class="h-full w-full object-cover">
                    @else
                        <div class="h-full w-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center text-white font-semibold">
                            {{ auth()->user()->initials }}
                        </div>
                    @endif
                @else
                    <div class="h-full w-full bg-gray-500 flex items-center justify-center text-white font-semibold">
                        U
                    </div>
                @endauth
            </div>
            <div class="ml-3 flex-1 min-w-0">
                <p class="text-sm font-medium text-white truncate">
                    @auth("touchstaraclientccount")
                            {{$client_detail->client_name }}
                    @endauth
                </p>
                <p class="text-xs text-blue-200 font-medium truncate">
                    @auth("touchstaraclientccount")
                        {{ strtoupper($client_detail->client_name) }}
                    @else
                        GUEST
                    @endauth
                </p>
            </div>
            @auth("touchstaraclientccount")
                <form method="POST" action="{{ route('client.logout') }}" class="ml-2">
                    @csrf
                    <button type="submit" 
                            class="text-white/70 hover:text-white transition-colors duration-200 p-2 rounded-md hover:bg-white/10" 
                            title="Logout">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </button>
                </form>
            @endauth
        </div>
    </div>

</aside>
