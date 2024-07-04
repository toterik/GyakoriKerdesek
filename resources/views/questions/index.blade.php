<html>
    @include('menu.nav');
    @foreach ($questions as $question)
    <h3>
        <a href="{{ route('questions.show', ['topicName' => $topicName, 'questionId' => $question->id]) }}">
            {{ $question->title }} 
        </a>
    </h3>
    @endforeach

   
</html>