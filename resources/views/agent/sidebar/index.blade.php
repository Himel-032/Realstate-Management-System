<ul class="list-group list-group-flush">
    <li class="list-group-item {{ request()->is('agent/dashboard') ? 'active' : '' }}">
        <a href="{{ route('agent_dashboard') }}">Dashboard</a>
    </li>
    <li class="list-group-item {{ request()->is('agent/payment') ? 'active' : '' }}">
        <a href="{{ route('agent_payment') }}">Make Payment</a>
    </li>
    <li class="list-group-item">
        <a href="">Orders</a>
    </li>
    <li class="list-group-item">
        <a href="">Add Property</a>
    </li>
    <li class="list-group-item">
        <a href="">All Properties</a>
    </li>
    <li class="list-group-item">
        <a href="">Messages</a>
    </li>
    <li class="list-group-item {{ request()->is('agent/profile') ? 'active' : '' }}">
        <a href="{{ route('agent_profile') }}">Edit Profile</a>
    </li>
    <li class="list-group-item">
        <a href="{{ route('agent_logout') }}">Logout</a>
    </li>
</ul>