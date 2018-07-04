<tr>
    <td>
        @component('mail::row', ['class' => 'socials'])
            <h2 class="socials__title">
                {{ __('mail.socials.title') }}
            </h2>

            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
                                    <table class="socials__table" width="{{ count($socials) * 32 + (count($socials) - 1) * 10 }}" align="center" border="0" cellpadding="0" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                @foreach($socials as $index => $socialData)
                                                    @component('mail::socials.item', $socialData)
                                                    @endcomponent

                                                    @if ($index !== count($socials) - 1)
                                                        <td class="social-separator" align="center" width="10"></td>
                                                    @endif
                                                @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        @endcomponent
    </td>
</tr>
