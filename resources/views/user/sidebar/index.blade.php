<ul class="list-group list-group-flush">
    <li class="list-group-item {{ request()->is('dashboard') ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="list-group-item {{ request()->is('message/*') ? 'active' : '' }}">
        <a href="{{ route('message') }}">Messages</a>
    </li>
    <li class="list-group-item {{ request()->is('wishlist') ? 'active' : '' }}">
        <a href="{{ route('wishlist') }}">Wishlist</a>
    </li>
    <li class="list-group-item {{ request()->is('profile') ? 'active' : '' }}">
        <a href="{{ route('profile') }}">Edit Profile</a>
    </li>
    <li class="list-group-item">
        <a href="{{ route('logout') }}">Logout</a>
    </li>
</ul>