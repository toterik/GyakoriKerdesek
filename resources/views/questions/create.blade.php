<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Form</title>
</head>
<body>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    @include('menu.nav');
    <h2>Submit Your Post</h2>
    <form action="{{ route('questions.store') }}" method="post">
        @csrf
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br><br>
        <label for="body">Body:</label><br>
        <textarea id="body" name="body" rows="10" cols="50" required></textarea><br><br>
        <select id="topic" name="topic" required>
            @foreach ($topics as $topic)
                <option value="{{ $topic->name }}"> {{$topic->name}}</option>
            @endforeach
        </select><br><br>
        

        @if (Auth::check())
        <input type="submit" value="Submit">
        <input type="hidden" value="{{Auth::user()->id}}">
        @else
        <input type="submit" value="Submit" disabled> Jelentkezz be először a kérdés feltevéséhez
        @endif
    </form>

</body>
</html>