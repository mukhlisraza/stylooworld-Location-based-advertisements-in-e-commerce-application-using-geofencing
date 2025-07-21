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
                Welcome to kirmaan.org. Your Account details are below:
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Name: {{$name}}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Mobile: {{$mobile}}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Email: {{$email}}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Password: ***** (as choosen by you)</td>
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