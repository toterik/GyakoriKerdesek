<!DOCTYPE html>
<html>
<head>
    <title>List of Topics</title>
</head>
<body>
    <h1>List of Topics</h1>
    <!-- Check if there are topics -->
    @if ($topics->isEmpty())
        <p>No topics available.</p>
    @else
        <!-- Loop through topics and display them -->
        @foreach ($topics as $topic)
            <p>{{ $topic->name }} - {{ $topic->description }}</p>
        @endforeach
    @endif
</body>
</html>
