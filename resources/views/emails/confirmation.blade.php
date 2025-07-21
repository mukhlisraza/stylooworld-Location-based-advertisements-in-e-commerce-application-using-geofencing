<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <table>
        <tr>
            <td>Dear {{$name}}!</td>
        </tr>
        <tr>
            <td>
                Please Click on the below link to activate your account :-
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><a href="{{url('confirm/'.$code)}}"> Confirm Account</a></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                Thanks & regards,
            </td>
        </tr>
        <tr>
            <td>
                kirmaan.org
            </td>
        </tr>
    </table>
</body>

</html>