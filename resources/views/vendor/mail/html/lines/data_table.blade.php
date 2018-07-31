@if($title)
    @component('mail::lines.title', ['title' => $title])
    @endcomponent
@endif

@component('mail::row', ['class' => 'row-fw'])
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
        <tbody>
            @foreach($data as $row)
                <tr>
                    <td>
                        {{ $row['label'] }}
                    </td>

                    <td>
                        {{ $row['value'] }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endcomponent
