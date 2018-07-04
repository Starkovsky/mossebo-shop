<tr>
    <td>
        @component('mail::row', ['class' => 'action-button'])
            @component('mail::button', ['url' => $url])
                {{ $text }}
            @endcomponent
        @endcomponent
    </td>
</tr>
