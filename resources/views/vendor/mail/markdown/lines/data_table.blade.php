@if($title)
## {{ $title }}
@endif

@foreach($data as $row)
| {{ $row['label'] }} | {{ $row['value'] }} |
@endforeach
