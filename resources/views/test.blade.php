<form action="{{ url('/test') }}" method="post">
    @csrf
    <button type="submit">Submit</button>
</form>