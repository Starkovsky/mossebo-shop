<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
    <style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>

    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" height="100%">
                <table class="content-body" width="100%" cellpadding="0" cellspacing="0">
                    {{ $header ?? '' }}

                    <tr>
                        <td style="padding: 12px"></td>
                    </tr>

                    <tr>
                        <td>
                            @component('mail::row', ['class' => 'socials'])
                                <div class="content">
                                    {{ Illuminate\Mail\Markdown::parse($slot) }}
                                </div>
                            @endcomponent
                        </td>
                    </tr>

                    @if($actionButton)
                        <tr>
                            <td style="padding: 12px"></td>
                        </tr>

                        {{ $actionButton }}
                    @endif

                    @if($actionImage)
                        <tr>
                            <td style="padding: 12px"></td>
                        </tr>

                        {{ $actionImage }}
                    @endif

                    @if($socials)
                        <tr>
                            <td style="padding: 16px"></td>
                        </tr>

                        {{ $socials }}
                    @endif

                    @if($footer->toHtml())
                        <tr>
                            <td>
                                @component('mail::separator', ['color' => 'light'])
                                @endcomponent
                            </td>
                        </tr>

                        {{ $footer }}
                    @endif
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
