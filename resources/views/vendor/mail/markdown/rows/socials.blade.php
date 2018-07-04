### {{ __('mail.socials.title') }}

@foreach($socials as $index => $socialData)
    [![{{ $socialData['title'] }}]({{ $socialData['image'] }})]({{ $socialData['url'] }})
@endforeach
