<html>
    @foreach ($questions as $question)
        <h3>{{$question-> title}}</h3>
        <p>{{$question-> body}}</p>
    @endforeach
   
</html>