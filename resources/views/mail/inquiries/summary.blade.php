<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;font-size:14px;line-height:20px;">
    @foreach ($summary as $label => $value)
        <tr>
            <td valign="top" style="padding:10px 12px 10px 0;border-top:1px solid #E2E9F2;color:#5B6880;width:38%;">{{ $label }}</td>
            <td valign="top" style="padding:10px 0;border-top:1px solid #E2E9F2;color:#172033;white-space:pre-line;">{{ $value }}</td>
        </tr>
    @endforeach
</table>
