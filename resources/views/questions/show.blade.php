
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question</title>
</head>
<body>
    @include('menu.nav');
    <h1>{{ $question->title }} by {{$userName}}</h1>
    <p>{{ $question->body }}</p>

    @if (count($answers) == 0)
        <h3>Be the first one to answer this question!!</h3>
    @else
    <h2>Answers:</h2>
    <ul>
        @foreach ($answers as $answer)
            <li>{{ $answer->body }}</li>
        @endforeach
    </ul>
    @endif

    {{ $answers->links() }}

    @if (Auth::check())
        <h2>Submit your answer:</h2>
        <form action="{{route('answers.create')}} " method="POST">
            @csrf
            <input type="hidden" name="question_id" value="{{ $question->id }}">
            <div>
                <textarea name="body" rows="5" cols="50" placeholder="Type your answer here..." required></textarea>
            </div>
            <div>
                <button type="submit">Submit Answer</button>
            </div>
        </form>
    @else
        <h3>You need to <a href="{{ route('login') }}">log in</a> to submit an answer.</h3>
    @endauth

</body>
</html>