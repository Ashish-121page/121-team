@if(auth()->user() && session()->has("admin_user_id") && session()->has("temp_user_id"))
    <div class="alert alert-warning logged-in-as mb-4">
        You are currently logged in as {{ auth()->user()->name }}. <a href="{{ route("panel.auth.logout-as") }}">Re-Login as {{ NameById(session()->get("admin_user_id")) }}</a>.
    </div><!--alert alert-warning logged-in-as-->
@endif