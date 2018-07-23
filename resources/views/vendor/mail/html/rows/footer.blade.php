<tr>
    <td>
        @component('mail::row', ['class' => 'footer row-fw'])
            {{ Illuminate\Mail\Markdown::parse($slot) }}
        @endcomponent
    </td>
</tr>
