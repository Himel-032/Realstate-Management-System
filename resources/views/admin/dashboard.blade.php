@include('admin.top')
<h2>Admin Dashboard</h2>

<p>
    Welcome, {{ Auth::guard('admin')->user()->name }}! You are logged in as an admin.
</p>