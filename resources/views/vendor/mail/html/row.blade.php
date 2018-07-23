<table class="row" align="center" width="615" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table class="{{ isset($class) ? $class : '' }} row-content" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        {{ $slot }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
