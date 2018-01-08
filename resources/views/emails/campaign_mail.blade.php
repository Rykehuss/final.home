<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Laravel Final Project</title>
</head>
<body style="background-color:#000; color: #ffffff;" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="1280" border="0" cellpadding="0" cellspacing="0" align="center" style="background:#000;">

    <tr valign="top">
        <td align="center" bgcolor="#000">
            <p style="margin: 12px; color: #8f8f8f; font-size: 12px; font-family: Tahoma, Geneva, sans-serif;">
                If the email is not displayed correctly, please follow this
                {{ link_to_route('campaign_mail', 'link', [$campaign, $subscriber], ['target' => 'blank']) }}.<br>
                Dear <strong>{{$subscriber->name}}</strong>! You received this email because user
                <strong>{{$campaign->updatedBy->name}}</strong> has
                included you in mailing list <strong>{{$campaign->bunch->name}}</strong>
            </p>
        </td>
    </tr>
    <tr align="center" valign="top" bgcolor="#000000">
        <td align="center" valign="middle" style="padding: 20px 0;">
            {!! $campaign->template->content !!}
        </td>
    </tr>
    <tr>
        <td bgcolor="#0d0f12">
            <p align="center" style="color: #6f6762; font-size: 13px; line-height: 18px; font-family: Arial; font-style: italic;">
                Rykehuss&nbsp;&copy;&nbsp;2018
            </p>
            <br>
        </td>
    </tr>
</table>
<div style="color:#000; font-size:14px; margin-top: 20px;">
    <center>
        {{--You can {{ link_to_route('unsubscribe', 'unsubscribe', [$campaign->template->id, $campaign->], ['target' => 'blank']) }} from the mailing list at any time.--}}
    </center>
</div>
</body>
</html>