<tr>
    <td>
        @component('mail::row', ['class' => 'footer'])
            {{ Illuminate\Mail\Markdown::parse($slot) }}
        @endcomponent
    </td>
</tr>
